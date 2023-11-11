<?php

namespace App\Http\Controllers;

use App\DataTables\DashboardWidgetDataTable;
use App\Facades\UtilityFacades;
use App\Models\DashboardWidget;
use App\Models\Faq;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Poll;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', '2fa']);
    }

    public function landingPage($lang = 'en')
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }
        \App::setLocale($lang);
        $forms = Form::where('assign_type', 'public')->get();
        $faqs = Faq::all();
        $features = json_decode(UtilityFacades::getsettings('feature_setting'));
        return view('welcome', compact('lang', 'features', 'faqs', 'forms'));
    }

    public function index()
    {
        $this->middleware(['auth', '2fa']);
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        } else {
            $widgets = DashboardWidget::orderBy('position')->get();
            $usr = \Auth::user();
            $user_id = $usr->id;
            $roles = Role::where('name', $usr->type)->first();
            $role_id = $usr->roles->first()->id;
            if ($usr->type == 'Admin') {
                $user = User::count();
                $form = Form::count();
                $submitted_form = FormValue::count();
                $poll = Poll::count();
                $s_form = FormValue::count();
                $forms = Form::count();
            } else {
                $user = User::count();
                $s_form = FormValue::count();
                $form = Form::whereIn('id', function ($query) use ($role_id) {
                    $query->select('form_id')->from('user_forms')->where('role_id', $role_id);
                })->count();
                $submitted_form = FormValue::select(['form_values.*', 'forms.title'])
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->where(function ($query1) use ($role_id, $user_id) {
                    $query1->whereIn('form_values.form_id', function ($query) use ($role_id) {
                        $query->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
                    })
                        ->orWhereIn('form_values.form_id', function ($query) use ($user_id) {
                            $query->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
                        })
                        ->OrWhere('assign_type', 'public');
                    })->count();
                    $forms = Form::where(function ($query) use ($role_id, $user_id) {
                                $query->whereIn('id', function ($query1) use ($role_id) {
                                    $query1->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
                                })->OrWhereIn('id', function ($query1) use ($user_id) {
                                    $query1->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
                                })->OrWhere('assign_type', 'public');
                               })->count();
                $poll = Poll::count();
            }
            return view('dashboard/home', compact('user', 'form', 'submitted_form', 'widgets', 'poll', 's_form', 'forms'));
        }
    }

    // public function form_details($id, Request $request)
    // {
    //     // dd($request->all());
    //     $form = Form::all();
    //     dd($form);
    //     return view('dashboard/home', compact('user'));

    //     // $post = Posts::where('slug', $slug)->first();
    //     // $random_posts = Posts::where('slug', '!=', $slug)->get();
    //     // $random_posts_limit = Posts::where('slug', '!=', $slug)->limit(2)->get();
    //     // return view('admin.posts.details', compact('post', 'random_posts', 'random_posts_limit'));
    // }

    public function indexdashboard(DashboardWidgetDataTable $dataTable)
    {
        return $dataTable->render('dashboard.index');
        if (\Auth::user()->can('manage-dashboardwidget')) {
            dd('if');

        } else {
            dd('else');
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function createdashboard()
    {
        if (\Auth::user()->can('create-dashboardwidget')) {
            if (Auth::user()->type == 'Admin') {
                $form = form::all();
            } else {
                $form = form::select('id', 'title')->where('created_by', Auth::user()->id)->get();
            }
            $poll = Poll::all();
            $p = [];
            $p[''] = __('Please select type');
            if (count($form) > 0) {
                $p['form'] = "Form";
            }
            if (count($poll) > 0) {
                $p['poll'] = "Poll";
            }
            $forms = [];
            $forms[''] = __('No select title');
            foreach ($form as $val) {
                $forms[$val->id] = $val->title;
            }
            $polls = [];
            $polls[''] = __('No select title');
            foreach ($poll as $value) {
                $polls[$value->id] = $value->title;
            }
            return view('dashboard.create', compact('forms', 'polls', 'p'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function storedashboard(Request $request)
    {
        if (\Auth::user()->can('create-dashboardwidget') && Auth::user()->type == 'Admin') {
            $validator = \Validator::make($request->all(), [
                'title' => 'required',
                'size' => 'required',
                'type' => 'required',
                'chart_type' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->errors();
                return redirect()->back()->with('errors', $messages->first());
            }
            if ($request->type == 'form') {
                $wid         = DashboardWidget::orderBy('id', 'DESC')->first();
                $widget             = new DashboardWidget();
                $widget->title       = $request->title;
                $widget->size      = $request->size;
                $widget->type      = $request->type;
                $widget->form_id       = $request->form_title;
                $widget->field_name      = $request->field_name;
                $widget->chart_type      = $request->chart_type;
                $widget->created_by = Auth::user()->id;
                $widget->position      = (!empty($wid) ? ($wid->position + 1) : 0);
                $widget->save();
            } else {
                $wid         = DashboardWidget::orderBy('id', 'DESC')->first();
                $widget             = new DashboardWidget();
                $widget->title       = $request->title;
                $widget->size      = $request->size;
                $widget->type      = $request->type;
                $widget->poll_id       = $request->poll_title;
                $widget->chart_type      = $request->chart_type;
                $widget->created_by = Auth::user()->id;
                $widget->position      = (!empty($wid) ? ($wid->position + 1) : 0);
                $widget->save();
            }
            return redirect()->route('admin.dashboard')
                ->with('success', __('Dashboard created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function editdashboard($id)
    {
        if (\Auth::user()->can('edit-dashboardwidget')) {
            $dashboard = DashboardWidget::find($id);
            $form = form::all();
            $polls = [];
            $forms = [];
            $poll = Poll::all();
            $label = [];
            if ($dashboard->type == 'form') {
                foreach ($form as $val) {
                    $forms[$val->id] = $val->title;
                }
                $form_title =  form::find($dashboard->form_id);
                $home = json_decode($form_title->json);
                foreach ($home as $hom) {
                    foreach ($hom as $key => $var) {
                        if ($var->type == 'select' || $var->type == 'radio-group' || $var->type == 'date' || $var->type == 'checkbox-group' || $var->type == 'starRating') {
                            $label[$var->name] = $var->label;
                        }
                    }
                }
            } else {
                foreach ($poll as $val) {
                    $polls[$val->id] = $val->title;
                }
            }
            return view('dashboard.edit', compact('dashboard', 'polls', 'label', 'forms'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function updatedashboard(Request $request, $id)
    {
        if (\Auth::user()->can('edit-dashboardwidget') && Auth::user()->type == 'Admin') {
            $validator = \Validator::make($request->all(), [
                'title' => 'required',
                'size' => 'required',
                'type' => 'required',
                'chart_type' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->errors();
                return redirect()->back()->with('errors', $messages->first());
            }
            $dashboard = DashboardWidget::find($id);
            $dashboard->title = $request->title;
            $dashboard->size = $request->size;
            $dashboard->type = $request->type;
            if ($request->type == 'form') {
                $dashboard->form_id = $request->form_title;
                $dashboard->field_name = $request->field_name;
            } else {
                $dashboard->poll_id = $request->poll_title;
            }
            $dashboard->chart_type = $request->chart_type;
            $dashboard->update();
            return redirect()->route('admin.dashboard')->with('success', __('Dashboard updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function deletedashboard($id)
    {
        if (\Auth::user()->can('delete-dashboardwidget') && Auth::user()->type == 'Admin') {
            $dashboard = DashboardWidget::find($id);
            $dashboard->delete();
            return redirect()->route('admin.dashboard')
                ->with('success', __('Dashboard deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function WidgetChnages(Request $request)
    {
        $widget = $request->widget;
        $form = form::find($widget);
        $home = json_decode($form->json);
        $label = [];
        if (isset($home)) {
            foreach ($home as $hom) {
                foreach ($hom as $key => $var) {
                    if ($var->type == 'select' || $var->type == 'radio-group' || $var->type == 'date' || $var->type == 'checkbox-group' || $var->type == 'starRating') {
                        $label[$key] = $var;
                    }
                }
            }
        }
        return response()->json($label, 200);
    }

    public function updatedash(Request $request)
    {
        if (\Auth::user()->can('manage-dashboardwidget')) {
            $widgets = $request->all();
            foreach ($widgets['position'] as $key => $item) {
                $dash = DashboardWidget::where('id', '=', $item)->first();
                $dash->position = $key;
                $dash->save();
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
