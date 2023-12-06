<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormValuesDataTable;
use App\Exports\FormValuesExport;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Jobs\CustomMessageToUserJob;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\MailMessages;
use App\Models\Market;
use App\Models\Setting;
use App\Models\UserForm;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class FormValueController extends Controller
{
    public function index(FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form') or \Auth::user()->can('manage-form')) {
            $forms = Form::all();
            return $dataTable->render('form_value.index', compact('forms'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function showSubmitedForms($status)
    {
        $user = auth()->user();
        if ($status == 1) {
            $title = 'Approved Commodity';
        } else {
            $title = UserStatus::where('id', $status)->pluck('title')->first();
        }
        $user_role = $user->Roles()->first()->name;
        if ($user_role == 'admin') {
            if ($status==2){
                $form_values = FormValue::where('status',$status)->paginate(20);
            }else{
                $form_values = FormValue::whereIn('status',[0,1])->paginate(20);
            }

        } else {
            $form_values = FormValue::where('status',$status)->where('user_id', $user->id)->paginate(20);
        }
        return view('admin.form_value.view_submited_form',compact('title','form_values'));
    }

    public function show($id)
    {
        if (\Auth::user()->can('commodity-show')) {
            $form_value = FormValue::find($id);
            $array = json_decode($form_value->json);
            return view('admin.form_value.view', compact('form_value', 'array'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function changeStatus(Request $request)
    {
        $form_id = $request->form_id;
        $status = $request->status;
        $form_value = FormValue::where('id', $form_id)->first();
        $form_value->update([
            'status' => $status
        ]);
        if ($status == 1) {
            Market::create([
                'form_value_id' => $form_value->id,
            ]);
        }
        if ($status == 2) {
            $form_value->Market()->delete();
        }
        //send email to user
        $st = UserStatus::where('id', $status)->first();
        $email = $form_value->User->email;
        $mail = MailMessages::where('type', 'changeStatusFormToUser')->first();
        $message = $mail->text;
        $message = str_replace('{status}', $st->title, $message);
        $title = $mail->title;
        dispatch(new CustomMessageToUserJob($message, $title, '', $email));
        session()->flash('success', 'Status Change Successfully!');
        $rout = route('admin.form.values', ['status' => 0]);
        return response()->json([1, $rout]);
    }

    public function edit($id)
    {
        if (\Auth::user()->can('commodity-edit')) {
            $usr = \Auth::user();
            $user_role = $usr->roles->first()->id;
            $form_value = FormValue::find($id);
            $formallowededit = UserForm::where('role_id', $user_role)->where('form_id', $form_value->form_id)->count();

            $array = json_decode($form_value->json);
            $form = $form_value->Form;
            $frm = Form::find($form_value->form_id);
            return view('admin.form.fill', compact('form', 'form_value', 'array'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('commodity-delete')) {
            FormValue::find($id)->delete();
            return redirect()->back()->with('success', __('Form successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function download_pdf($id)
    {
        $form_value = FormValue::where('id', $id)->first();
        if ($form_value) {
            $form_value->createPDF();
        } else {
            $form_value = FormValue::where('id', '=', $id)->first();
            if (!$form_value) {
                $id = Crypt::decryptString($id);
                $form_value = FormValue::find($id);
            }
            if ($form_value) {
                $form_value->createPDF();
            } else {
                return redirect()->route('home')->with('error', __('File is not exist.'));
            }
        }
    }

    public function export(Request $request)
    {
        $form = Form::find($request->form_id);
        return Excel::download(new FormValuesExport($request), $form->title . '.csv');
    }

    public function download_csv_2($id)
    {
        $form_value = FormValue::where('id', '=', $id)->first();
        if (!$form_value) {
            $id = Crypt::decryptString($id);
            $form_value = FormValue::find($id);
        }
        if ($form_value) {
            $form_value->createCSV2();
            return response()->download(storage_path('app/public/csv/Survey_' . $form_value->id . '.xlsx'))->deleteFileAfterSend(true);
        } else {
            return redirect()->route('home')->with('error', __('File is not exist.'));
        }
    }

    public function export_xlsx(Request $request)
    {
        $form = Form::find($request->form_id);
        return Excel::download(new FormValuesExport($request), $form->title . '.xlsx');
    }

    public function getGraphData(Request $request, $id)
    {
        $form = Form::find($id);
        $chartData = UtilityFacades::dataChart($id);
        return view('form_value.chart', compact('chartData', 'id', 'form'));
    }

    public function submit_form(Request $request)
    {
        $user = auth()->user();
        $user_info = 'Name: ' . $user->name . ' Email: ' . $user->email;
        try {
            $form_value_id = $request->form_value_id;
            $form_value = FormValue::where('id', $form_value_id)->first();
            session()->forget('success');
            $form_value->update(['status' => 0]);
            $rout = route('admin.form.values', ['status' => 0, 'user' => $user->id]);
            $email = Setting::where('key', 'email')->pluck('value')->first();
            //send email to admin
            $mail = MailMessages::where('type', 'formFilledToAdmin')->first();
            $message = $mail->text;
            $title = $mail->title;
            $message = str_replace('{user}', $user_info, $message);
            dispatch(new CustomMessageToUserJob($message, $title, '', $email));
            //send email to user
            $email = $user->email;
            $mail = MailMessages::where('type', 'formFilledToUser')->first();
            $message = $mail->text;
            $title = $mail->title;
            dispatch(new CustomMessageToUserJob($message, $title, '', $email));
            return response()->json([1, 'Form Submitted Successfully', $rout]);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }

    public function copy_form(Request $request)
    {
        try {
            $form_value_id = $request->form_value_id;
            $form_value = FormValue::where('id', $form_value_id)->first();
            $form_value_copy = FormValue::create($form_value->toArray());
            $form_value_copy->update(['parent' => $form_value->id]);
            session()->forget('success');
            $form_value->update(['status' => 0]);
            return response()->json([1, 'Form Copied Successfully']);
        } catch (\Exception $exception) {
            return response()->json([0, $exception->getMessage()]);
        }
    }
}
