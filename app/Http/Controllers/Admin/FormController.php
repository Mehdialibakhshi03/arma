<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormsDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleFormRequest;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\AssignFormRole;
use App\Models\AssignFormsRoles;
use App\Models\AssignFormsUsers;
use App\Models\AssignFormUser;
use App\Models\CargoInsurance;
use App\Models\CompanyType;
use App\Models\ContainerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\Form;
use App\Models\FormComments;
use App\Models\FormCommentsReply;
use App\Models\FormValue;
use App\Models\Incoterms;
use App\Models\IncotermsVersion;
use App\Models\InspectionPlace;
use App\Models\Packing;
use App\Models\PaymentTerm;
use App\Models\PriceType;
use App\Models\QualityQuantityInspector;
use App\Models\SalesOfferForm;
use App\Models\SalesOfferFormCopy;
use App\Models\ShippingTerm;
use App\Models\TargetMarket;
use App\Models\THCIncluded;
use App\Models\ToleranceWeightBy;
use App\Models\Units;
use App\Models\User;
use App\Models\UserForm;
use App\Rules\CommaSeparatedEmails;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use function App\Http\Controllers\public_path;


class FormController extends Controller
{
    public function index(FormsDataTable $dataTable)
    {
        return $dataTable->render('admin.form.index');
    }

    public function create()
    {
        if (\auth()->user()->can('form-create')) {
            return view('admin.form.create');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:forms,title'
        ]);
        $form = new Form();
        $form->title = $request->title;
        $form->json = '';
        $form->html = '';
        $form->created_by = Auth::user()->id;
        $form->save();
        return redirect()->route('admin.forms.index')->with('success', __('Form created successfully.'));
    }


    public function edit($id)
    {
        $usr = \Auth::user();
        $user_role = $usr->roles->first()->id;
        $formallowededit = UserForm::where('role_id', $user_role)->where('form_id', $id)->count();
//        if (\Auth::user()->can('edit-form') && $usr->type == 'Admin') {
        $form = Form::find($id);
        $next = Form::where('id', '>', $form->id)->first();
        $previous = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
        $form_roles = $form->Roles->pluck('id')->toArray();
        $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'id');
        $formRole = $form->assignedroles->pluck('id')->toArray();
        $form_role = Role::pluck('name', 'id');
        $formUser = $form->assignedusers->pluck('id')->toArray();
        $form_user = User::where('id', '!=', 1)->pluck('name', 'id');
        $payment_type = [];
        if (UtilityFacades::getsettings('stripesetting') == 'on') {
            $payment_type['stripe'] = 'Stripe';
        }
        if (UtilityFacades::getsettings('paypalsetting') == 'on') {
            $payment_type['paypal'] = 'Paypal';
        }
        if (UtilityFacades::getsettings('razorpaysetting') == 'on') {
            $payment_type['razorpay'] = 'Razorpay';
        }
        if (UtilityFacades::getsettings('paytmsetting') == 'on') {
            $payment_type['paytm'] = 'Paytm';
        }
        if (UtilityFacades::getsettings('flutterwavesetting') == 'on') {
            $payment_type['flutterwave'] = 'Flutterwave';
        }
        if (UtilityFacades::getsettings('paystacksetting') == 'on') {
            $payment_type['paystack'] = 'Paystack';
        }
        if (UtilityFacades::getsettings('coingatesetting') == 'on') {
            $payment_type['coingate'] = 'Coingate';
        }
        if (UtilityFacades::getsettings('mercadosetting') == 'on') {
            $payment_type['mercado'] = 'Mercado';
        }
        return view('admin.form.edit', compact('form', 'form_roles', 'roles', 'payment_type', 'form_user', 'formUser', 'formRole', 'form_role', 'next', 'previous'));
//        } else {
//            if (\Auth::user()->can('edit-form') && $formallowededit > 0) {
//                $form = Form::find($id);
//                $next = Form::where('id', '>', $form->id)->first();
//                $previous = Form::where('id', '<', $form->id)->orderBy('id', 'desc')->first();
//                $form_roles = $form->Roles->pluck('id')->toArray();
//                $roles = Role::pluck('name', 'id');
//                $formRole = $form->assignedroles->pluck('id')->toArray();
//                $form_role = Role::pluck('name', 'id');
//                $formUser = $form->assignedusers->pluck('id')->toArray();
//                $form_user = User::where('id', '!=', 1)->pluck('name', 'id');
//                return view('admin.form.edit', compact('form', 'form_roles', 'form_role', 'form_user', 'formUser', 'formRole', 'next', 'previous'));
//            } else {
//                return redirect()->back()->with('failed', __('Permission denied.'));
//            }
//        }
    }

    public function update(Request $request, Form $form)
    {
        if (\Auth::user()->can('edit-form')) {
            $rules = [
                'title' => 'required',
            ];
            $ccemails = implode(',', $request->ccemail);
            $bccemails = implode(',', $request->bccemail);
            if ($ccemails) {
                $request->validate([
                    'ccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            if ($bccemails) {
                $request->validate([
                    'bccemail' => ['nullable', new CommaSeparatedEmails],
                ]);
            }
            $validator = Validator::make($request->all(), $rules);
            $request->validate([
                'email' => ['nullable', new CommaSeparatedEmails],
            ]);
            if ($request->payment_type == "paystack") {
                if ($request->currency_symbol != '₦' || $request->currency_name != 'NGN') {
                    return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. Please enter NGN currency and ₦ symbol.'));
                }
            }
            if ($request->payment_type == "paytm") {
                if ($request->currency_symbol != '₹' || $request->currency_name != 'INR') {
                    return redirect()->back()->with('failed', __('Currency not suppoted this payment getway. Please enter INR currency and ₹ symbol.'));
                }
            }
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('failed', $messages->first());
            }
            $filename = $form->logo;
            $emails = $form->logo;
            if (request()->file('form_logo')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                $file = $request->file('form_logo');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form_logo');
                } else {
                    return redirect()->route('admin.forms.index')->with('failed', __('File type not valid.'));
                }
            }
            if (isset($request->email) and !empty($request->email)) {
                $emails = implode(',', $request->email);
            }
            if (isset($request->ccemail) and !empty($request->ccemail)) {
                $ccemails = implode(',', $request->ccemail);
            }
            if (isset($request->bccemail) and !empty($request->bccemail)) {
                $bccemails = implode(',', $request->bccemail);
            }
            $form->title = $request->title;
            $form->success_msg = $request->success_msg;
            $form->thanks_msg = $request->thanks_msg;
            $form->logo = $filename;
            $form->email = $emails;
            $form->ccemail = $ccemails;
            $form->bccemail = $bccemails;
            $form->payment_status = ($request->payment == 'on') ? '1' : '0';
            $form->allow_comments = ($request->allow_comments == 'on') ? '1' : '0';
            $form->allow_share_section = ($request->allow_share_section == 'on') ? '1' : '0';
            $form->amount = ($request->amount == '') ? '0' : $request->amount;
            $form->currency_symbol = $request->currency_symbol;
            $form->currency_name = $request->currency_name;
            $form->payment_type = $request->payment_type;
            $form->created_by = Auth::user()->id;
            $form->assign_type = $request->assign_type;
            // $form->assign_form = ($request->assignform == 'on') ? '0' : '1';
            $form->save();
            if ($request->assign_type == 'role') {
                $id = $form->id;
                AssignFormsUsers::where('form_id', $id)->delete();
                $form->assignRole($request->roles);
            }
            if ($request->assign_type == 'user') {
                $id = $form->id;
                AssignFormsRoles::where('form_id', $id)->delete();
                $form->assignUser($request->users);
            }
            if ($request->assign_type == 'public') {
                $id = $form->id;
                AssignFormsRoles::where('form_id', $id)->delete();
                AssignFormsUsers::where('form_id', $id)->delete();
            }
            $form->assignFormRoles($request->roles);
            return redirect()->route('admin.forms.index')->with('success', __('Form updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy(Form $form)
    {
        $id = $form->id;
        $comments = FormComments::where('form_id', $id)->get();
        $comments_reply = FormCommentsReply::where('form_id', $id)->get();
        AssignFormsRoles::where('form_id', $id)->delete();
        AssignFormsUsers::where('form_id', $id)->delete();
        foreach ($comments as $allcomments) {
            $commentsids = $allcomments->id;
            $commentsall = FormComments::find($commentsids);
            if ($commentsall) {
                $commentsall->delete();
            }
        }
        foreach ($comments_reply as $comments_reply_all) {
            $comments_reply_ids = $comments_reply_all->id;
            $reply = FormCommentsReply::find($comments_reply_ids);
            if ($reply) {
                $reply->delete();
            }
        }
        $form->delete();
        return redirect()->back()->with('success', __('Form deleted successfully'));
    }

    public function design($id)
    {

        $form = Form::find($id);
        if ($form) {
            return view('admin.form.design', compact('form'));
        } else {
            return redirect()->back()->with('failed', __('Form not found.'));
        }

    }

    public function designtest($id)
    {

        $form = Form::find($id);
        if ($form) {
            return view('form.test_design', compact('form'));
        } else {
            return redirect()->back()->with('failed', __('Form not found.'));
        }

    }

    public function designUpdate(Request $request, $id)
    {
        $form = Form::find($id);
        if ($form) {
            $form->json = $request->json;
            $field_name = json_decode($request->json);
            $arr = [];
            foreach ($field_name[0] as $k => $fields) {
                if ($fields->type == "header" || $fields->type == "paragraph") {
                    $arr[$k] = $fields->type;
                } else {
                    $arr[$k] = $fields->name;
                }
            }
            $form->save();
            return redirect()->route('admin.forms.index')->with('success', __('Form updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Form not found.'));
        }
    }

    public function fill($id)
    {
        $form = Form::find($id);
        $form_value = null;
        $array = $form->getFormArray();
        return view('admin.form.fill', compact('form', 'form_value', 'array'));
    }

    public function publicFill($id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $form = Form::find($id);
            $form_value = null;
            if ($form) {
                $array = $form->getFormArray();
                return view('form.public_fill', compact('form', 'form_value', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        } else {
            abort(404);
        }
    }

    public function qrCode($id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        $form = Form::find($id);
        $view = view('form.public_fill_qr', compact('form'));
        return ['html' => $view->render()];
    }

    public function fillStore(Request $request, $id)
    {

        $form = Form::find($id);
        if (UtilityFacades::getsettings('CAPTCHASETTING')) {
            if (UtilityFacades::keysettings('captcha') == 'hcaptcha') {
                if (empty($_POST['h-captcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check hcaptcha.')], 200);
                    } else {
                        return redirect()->back()->with('failed', __('Please check hcaptcha.'));
                    }
                }
            }
            if (UtilityFacades::keysettings('captcha') == 'recaptcha') {
                if (empty($_POST['g-recaptcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check recaptcha.')], 200);
                    } else {
                        return redirect()->back()->with('failed', __('Please check recaptcha.'));
                    }
                }
            }
        }

        if ($form) {
            $questions = [];
            $client_emails = [];
            if ($request->form_value_id) {
                $form_value = FormValue::find($request->form_value_id);
                $array = json_decode($form_value->json);
            } else {
                $array = $form->getFormArray();
            }
            // dd($array);
            foreach ($array as &$rows) {
                foreach ($rows as &$row) {
                    // dd($row->type);
                    if ($row->type == 'checkbox-group') {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'file') {
                        if ($row->subtype == "fineuploader") {
                            $file_size = number_format($row->max_file_size_mb / 1073742848, 2);
                            $file_limit = $row->max_file_size_mb / 1024;
                            if ($file_size < $file_limit) {
                                $values = [];
                                $value = explode(',', $request->input($row->name));
                                foreach ($value as $file) {
                                    $values[] = $file;
                                }
                                $row->value = $values;
                            } else {
                                return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                            }
                        } else {
                            if ($row->file_extention == 'pdf') {
                                $allowedfileExtension = ['pdf'];
                            } elseif ($row->file_extention == 'excel') {
                                $allowedfileExtension = ['csv', 'xlsx'];
                            } else {
                                $allowedfileExtension = ['jpg', 'jpeg', 'png'];
                            }
                            $requiredextention = implode(',', $allowedfileExtension);
                            $file_size = number_format($row->max_file_size_mb / 1073742848, 2);
                            $file_limit = $row->max_file_size_mb / 1024;
                            if ($file_size < $file_limit) {
                                if ($row->multiple) {
                                    if ($request->hasFile($row->name)) {
                                        $values = [];
                                        $files = $request->file($row->name);
                                        foreach ($files as $file) {
                                            $extension = $file->getClientOriginalExtension();
                                            $check = in_array($extension, $allowedfileExtension);
                                            if ($check) {
                                                if ($extension == 'csv') {
                                                    $name = \Str::random(40) . '.' . $extension;
                                                    $file->move(storage_path() . '/app/form_values/' . $form->id, $name);
                                                    $values[] = 'form_values/' . $form->id . '/' . $name;
                                                } else {
                                                    // $filename = $file->store('form_values/' . $form->id);
                                                    // $values[] = $filename;
                                                    // $filename = $file->store('form_values/' . $form->id);
                                                    $path = Storage::path("form_values/$form->id");
                                                    $filename = $file->store('form_values/' . $form->id);
                                                    $newpath = Storage::path($filename);
                                                    chmod("$path", 0777);
                                                    chmod("$newpath", 0777);
                                                    $values[] = $filename;
                                                }
                                            } else {
                                                if (isset($request->ajax)) {
                                                    return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                                } else {
                                                    return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                                }
                                            }
                                        }
                                        $row->value = $values;
                                    }
                                } else {
                                    if ($request->hasFile($row->name)) {
                                        $values = '';
                                        $file = $request->file($row->name);
                                        $extension = $file->getClientOriginalExtension();
                                        $check = in_array($extension, $allowedfileExtension);
                                        if ($check) {
                                            if ($extension == 'csv') {
                                                $name = \Str::random(40) . '.' . $extension;
                                                $file->move(storage_path() . '/app/form_values/' . $form->id, $name);
                                                $values = 'form_values/' . $form->id . '/' . $name;
                                                chmod("$values", 0777);
                                            } else {
                                                // $filename = $file->store('form_values/' . $form->id);
                                                // $values = $filename;
                                                // $filename = $file->store('form_values/' . $form->id);
                                                $path = Storage::path("form_values/$form->id");
                                                $filename = $file->store('form_values/' . $form->id);
                                                $newpath = Storage::path($filename);
                                                chmod("$path", 0777);
                                                chmod("$newpath", 0777);
                                                $values = $filename;
                                            }
                                        } else {
                                            if (isset($request->ajax)) {
                                                return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                            } else {
                                                return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                            }
                                        }
                                        $row->value = $values;
                                    }
                                }
                            } else {
                                return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                            }
                        }
                    } elseif ($row->type == 'radio-group') {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'autocomplete') {
                        if (isset($row->multiple)) {
                            foreach ($row->values as &$value) {
                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {
                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'select') {
                        if (isset($row->multiple) & !empty($row->multiple)) {
                            foreach ($row->values as &$value) {
                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {
                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'date') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'number') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'textarea') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'text') {
                        $client_email = '';
                        if ($row->subtype == 'email') {
                            if (isset($row->is_client_email) && $row->is_client_email) {

                                $client_emails[] = $request->{$row->name};
                            }
                        }
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'starRating') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'SignaturePad') {
                        if (property_exists($row, 'value')) {
                            $filepath = $row->value;
                            if ($request->{$row->name} == '') {
                                $url = $row->value;
                            } else {
                                $url = $request->{$row->name};
                                $imageContent = file_get_contents($url);
                                $filePath = Storage::path($filepath);
                                $file = file_put_contents($filePath, $imageContent);
                            }

                            $row->value = $filepath;
                        } else {
                            if (!file_exists(Storage::path("form_values/$form->id"))) {
                                mkdir(Storage::path("form_values/$form->id"), 0777, true);
                                chmod(Storage::path("form_values/$form->id"), 0777);
                            }
                            $filepath = "form_values/$form->id/" . rand(1, 1000) . '.png';
                            $url = $request->{$row->name};
                            $imageContent = file_get_contents($url);
                            $filePath = Storage::path($filepath);
                            $file = file_put_contents($filePath, $imageContent);
                            $row->value = $filepath;
                        }
                    } elseif ($row->type == 'location') {
                        foreach ($request->{$row->name} as $value) {
                            $row->value = [
                                'lat' => $value['latitude'],
                                'lng' => $value['longitude'],
                            ];
                        }
                    }
                }
            }
            if ($request->form_value_id) {
                $form_value->json = json_encode($array);
                $form_value->save();
            } else {
                if (\Auth::user()) {
                    $user_id = \Auth::user()->id;
                } else {
                    $user_id = NULL;
                }
                $data = [];

                $data['form_id'] = $form->id;
                $data['user_id'] = $user_id;
                $data['json'] = json_encode($array);
                $form_value = FormValue::create($data);
            }
            $emails = explode(',', $form->email);
            $ccemails = explode(',', $form->ccemail);
            $bccemails = explode(',', $form->bccemail);
            if ($form->ccemail && $form->bccemail) {
                try {
                    Mail::to($form->email)
                        ->cc($form->ccemail)
                        ->bcc($form->bccemail)
                        ->send(new FormSubmitEmail($form_value));
                } catch (\Exception $e) {
                }
            } else if ($form->ccemail) {
                try {
                    Mail::to($emails)
                        ->cc($ccemails)
                        ->send(new FormSubmitEmail($form_value));
                } catch (\Exception $e) {
                }
            } else if ($form->bccemail) {
                try {
                    Mail::to($emails)
                        ->bcc($bccemails)
                        ->send(new FormSubmitEmail($form_value));
                } catch (\Exception $e) {
                }
            } else {
                try {
                    Mail::to($emails)->send(new FormSubmitEmail($form_value));
                } catch (\Exception $e) {
                }
            }
            foreach ($client_emails as $client_email) {
                try {
                    Mail::to($client_email)->send(new Thanksmail($form_value));
                } catch (\Exception $e) {
                }
            }
            if ($form->payment_type != 'coingate' && $form->payment_type != 'mercado') {
                $success_msg = strip_tags($form->success_msg);
            }
            if ($request->form_value_id) {
                $success_msg = strip_tags($form->success_msg);
            }
            if (isset($request->ajax)) {
                $user = \auth()->user();
                if ($user->hasRole('Admin')) {
                    $route = null;
                } else {
                    $route = route('admin.form.values', ['status' => 3, 'user' => auth()->user()->id]);
                }
                return response()->json(['is_success' => true, 'message' => __($success_msg), 'redirect' => $route], 200);
            } else {
                return redirect()->back()->with('success', __($success_msg));
            }
        } else {
            if (isset($request->ajax)) {
                return response()->json(['is_success' => false, 'message' => __('Form not found')], 200);
            } else {
                return redirect()->back()->with('failed', __('Form not found.'));
            }
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->upload->store('editor');
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = Storage::url($fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function duplicate(Request $request)
    {
        $form = Form::find($request->form_id);
        if ($form) {
            $newform = Form::create([
                'title' => $form->title . ' (copy)',
                'logo' => $form->logo,
                'email' => $form->email,
                'success_msg' => $form->success_msg,
                'thanks_msg' => $form->thanks_msg,
                'json' => $form->json,
                'html' => $form->html,
                'payment_status' => $form->payment_status,
                'amount' => $form->amount,
                'currency_symbol' => $form->currency_symbol,
                'currency_name' => $form->currency_name,
                'payment_type' => $form->payment_type,
                'created_by' => $form->created_by,
                'is_active' => $form->is_active,
            ]);
            return redirect()->back()->with('success', __('Form duplicate successfully.'));
        } else {
            return redirect()->back()->with('errors', __('Form not found.'));
        }
    }

    public function ckupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = __('Image uploaded successfully');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function dropzone(Request $request, $id)
    {

        $values = [];
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $allowedfileExtension = ['jpeg', 'jpg', 'png'];
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form_values/' . $id);
                    $values[] = $filename;
                } else {
                    return response()->json(['errors' => 'Only jpg,jpeg,png file allowed']);
                }
            }
            return response()->json(['success' => 'File uploded successfully.', 'filename' => $values]);
        } else {
            return response()->json(['errors' => 'File not found.']);
        }
    }

    public function formStatus($id)
    {
        if (\Auth::user()->can('manage-form')) {
            $forms = Form::find($id);
            if ($forms->is_active == 1) {
                $forms->is_active = 0;
                $forms->save();
                return redirect()->back()->with('success', 'Form deactiveted successfully.');
            } else {
                $forms->is_active = 1;
                $forms->save();
                return redirect()->back()->with('success', 'Form Activeted Successfully.');
            }
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function sales_form($page_type = 'Create', $item = 'null')
    {
        $sale_form_exist = 0;
        $route = null;
        $form = [];
        if ($page_type === 'Create') {
            $route = route('admin.sale_form.update_or_store');
            $form_exist = SalesOfferForm::where('user_id', \auth()->id())->exists();
            if ($form_exist) {
                $sale_form_exist = 1;
                $form = SalesOfferForm::where('user_id', \auth()->id())->latest()->first();
            }
        }
        if ($page_type === 'Edit') {
            $sale_form_exist = 1;
            $route = route('admin.sale_form.update_or_store', ['item' => $item]);
            $form = SalesOfferForm::where('id', $item)->first();
        }
        $company_types = CompanyType::all();
        $unites = Units::all();
        $currencies = Currency::all();
        $tolerance_weight_by = ToleranceWeightBy::all();
        $Incoterms = Incoterms::all();
        $incoterms_version = IncotermsVersion::all();
        $countries = Country::all();
        $priceTypes = PriceType::all();
        $paymentTerms = PaymentTerm::all();
        $packing = Packing::all();
        $shipping_terms = ShippingTerm::all();
        $container_types = ContainerType::all();
        $thcincluded = THCIncluded::all();
        $flexi_type_tank = FlexiTankType::all();
        $destination = Destination::all();
        $targetMarket = TargetMarket::all();
        $qualityQuantityInspector = QualityQuantityInspector::all();
        $InspectionPlace = InspectionPlace::all();
        $cargoInsurance = CargoInsurance::all();
        return view('admin.sales_form.create', compact(
            'sale_form_exist',
            'form',
            'route',
            'company_types',
            'unites',
            'currencies',
            'tolerance_weight_by',
            'Incoterms',
            'incoterms_version',
            'countries',
            'priceTypes',
            'paymentTerms',
            'packing',
            'container_types',
            'shipping_terms',
            'thcincluded',
            'flexi_type_tank',
            'destination',
            'targetMarket',
            'qualityQuantityInspector',
            'InspectionPlace',
            'cargoInsurance',
        ));
    }

    public function sales_form_update_or_store(Request $request, $item = null)
    {
        $is_complete = 0;
        $rules = $this->rules($item);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $is_complete = 1;
        }
        $validate_items = $validator->valid();
        $validate_items = collect($validate_items);
        $env = env('SALE_OFFER_FORM');
        $files = ['specification_file', 'picture_packing_file', 'quality_inspection_report_file', 'safety_product_file', 'reach_certificate_file'];
        foreach ($files as $file) {
            if ($validate_items->has($file)) {
                if ($validate_items->has('form_id')) {
                    $path = public_path($env, $file);
                    unlink($path);
                }
                $file_name = $this->Upload_files($env, $validate_items[$file]);
            } else {
                if ($item != null) {
                    //is_update
                    $form = SalesOfferForm::where('id', $item)->first();
                    $file_name = $form[$file];
                } else {
                    $file_name = '';
                }

            }
            $validate_items[$file] = $file_name;
        }
        $has_loading = $validate_items->has('has_loading') ? 1 : 0;
        $accept_terms = $validate_items->has('accept_terms') ? 1 : 0;
        $user_id = \auth()->id();
        $validate_items['user_id'] = $user_id;
        $validate_items['has_loading'] = $has_loading;
        $validate_items['accept_terms'] = $accept_terms;
        $validate_items['is_complete'] = $is_complete;
        if ($item != null) {
            $sale_form = SalesOfferForm::where('id', $item)->first();
            if ($sale_form->unique_number == null) {
                $unique_number = 'Arma-' . $sale_form->id;
                $validate_items['unique_number'] = $unique_number;
            }
            $sale_form->update($validate_items->except('_token')->all());
            if ($is_complete == 1 and $sale_form->status == 0) {
                session()->flash('need_submit', 1);
            }
            if ($validator->fails()) {
                return redirect()->route('admin.sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
            }
            return redirect()->back()->with('success', 'updated successfully');
        } else {
            $sale_form = SalesOfferForm::create($validate_items->except('_token')->all());
            $sale_form_id = $sale_form->id;
            $unique_number = 'Arma-' . $sale_form_id;
            $sale_form->update(['unique_number', $unique_number]);
            if ($is_complete == 1 and $sale_form->status) {
                session()->flash('need_submit', 1);
            }
            if ($validator->fails()) {
                return redirect()->route('admin.sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
            }
        }
    }

    public function Upload_files($env, $file)
    {
        $fileNamePrimaryImage = generateFileName($file->getClientOriginalName());
        $file->move(\public_path($env), $fileNamePrimaryImage);
        return $fileNamePrimaryImage;
    }

    public function sales_form_index($status)
    {
        $user = \auth()->user();
        if ($user->Roles[0]->name === 'admin') {
            $user_id = null;
        } else {
            $user_id = $user->id;
        }
        $items = SalesOfferForm::when($user_id != null, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        })->where('status', $status)->where('is_complete', 1)->paginate(100);
        return view('admin.sales_form.list', compact('items'));
    }

    public function sales_form_remove(Request $request)
    {
        $id = $request->id;
        $sales_form = SalesOfferForm::where('id', $id)->first();
        $sales_form->delete();
        $sales_form_copy = SalesOfferFormCopy::where('id', $id)->first();
        if ($sales_form_copy){
            $sales_form_copy->delete();
        }

        session()->flash('success', 'Your Item Deleted Successfully');
        return response()->json([1]);
    }

    public function change_status(Request $request)
    {
        $form_id = $request->form_id;
        $new_status = $request->new_status;
        $sale_form = SalesOfferForm::where('id', $form_id)->first();
        $sale_form->update([
            'status' => $new_status
        ]);
        if ($new_status==4){
            SalesOfferFormCopy::create($sale_form->toArray());
        }
        session()->flash('success', 'Status was Changed Successfully');
        return response()->json([1]);
    }

    public function rules($item)
    {
        $rules = [
            'company_name' => 'required',
            'company_type' => 'required',
            'unit' => 'required',
            'unit_other' => ['required_if:unit,other'],
            'currency' => 'required',
            'currency_other' => ['required_if:currency,other'],
            'commodity' => 'required',
            'type_grade' => 'required',
            'hs_code' => 'nullable',
            'cas_no' => 'nullable',
            'product_more_details' => 'nullable',
            'specification' => 'nullable',
            //file
            'quality_inspection_report' => 'required',
            //file
            'max_quantity' => 'required',
            'min_order' => 'required',
            'tolerance_weight' => 'nullable',
            'tolerance_weight_by' => 'nullable',
            'partial_shipment' => 'nullable',
            'partial_shipment_number' => ['required_if:partial_shipment,Yes'],
            'shipment_more_detail' => 'nullable',
            'incoterms' => 'required',
            'incoterms_other' => ['required_if:incoterms,other'],
            'incoterms_version' => 'nullable',
            'country' => 'required',
            'port_city' => 'required',
            'incoterms_more_detail' => 'nullable',
            'price_type' => 'required',
            'formulla' => ['required_if:price_type,Formulla'],
            'price' => ['required_if:price_type,Fix'],
            'payment_term' => 'required',
            'payment_term_description' => 'required',
            'packing' => 'required',
            'packing_more_details' => 'nullable',
            'packing_other' => ['required_unless:packing,other'],
            'marking_more_details' => 'nullable',
            'picture_packing' => 'nullable',
            //file
            'possible_buyers' => 'nullable',
            'cost_per_unit' => ['required_if:possible_buyers,Yes'],
            'origin_country' => 'required',
            'origin_port_city' => 'required',
            'origin_more_details' => 'nullable',
            //loading
            'has_loading' => 'nullable',
            'loading_type' => ['required_if:has_loading,1'],
            'loading_country' => ['required_unless:loading_type,null'],
            'loading_port_city' => ['required_unless:loading_type,null'],
            'loading_from' => ['required_unless:loading_type,null'],
            'loading_to' => ['required_unless:loading_type,null'],
            'bulk_loading_rate' => 'nullable|number|integer',
            'loading_bulk_shipping_term' => 'nullable',
            'loading_container_type' => 'nullable',
            'loading_container_thc_included' => 'nullable',
            'loading_flexi_tank_type' => ['required_if:loading_type,Flexi Tank'],
            'loading_flexi_tank_thc_included' => 'nullable',
            'loading_more_details' => 'nullable',
            //discharging
            'has_discharging' => 'nullable',
            'discharging_type' => ['required_if:has_discharging,1'],
            'discharging_country' => ['required_unless:discharging_type,null'],
            'discharging_port_city' => ['required_unless:discharging_type,null'],
            'discharging_from' => ['required_unless:discharging_type,null'],
            'discharging_to' => ['required_unless:discharging_type,null'],
            'bulk_discharging_rate' => 'nullable|number|integer',
            'discharging_bulk_shipping_term' => 'nullable',
            'discharging_container_type' => 'nullable',
            'discharging_container_thc_included' => 'nullable',
            'discharging_flexi_tank_type' => ['required_if:discharging_type,Flexi Tank'],
            'discharging_flexi_tank_thc_included' => 'nullable',
            'discharging_more_details' => 'nullable',
            //destination
            'destination' => 'nullable',
            'exclude_market' => 'nullable',
            'target_market' => 'nullable',
            //inspection
            'quality_quantity_inspection' => 'required',
            'inspection_place' => 'required',
            'inspection_more_detail' => 'nullable',
            //insurance
            'cargo_insurance' => 'nullable',
            'insurance_more_details' => 'nullable',
            //safety
            'safety_product' => 'required',
            //file
            //reach certificate
            'reach_certificate' => 'required',
            //file
            //documents
            'documents_count' => 'required',
            'documents_options' => ['required_if:documents_count,No'],
            'document_more_detail' => 'nullable',
            //contact person
            'contact_person_name' => 'required',
            'contact_person_job_title' => 'required',
            'contact_person_email' => 'required',
            'contact_person_mobile_phone' => 'required',
            //last part
            'last_more_detail' => 'nullable',
            'accept_terms' => 'required',
        ];

        if ($item != null) {
            //is_update
            $form = SalesOfferForm::where('id', $item)->first();
            $specification_file = $form['specification_file'];
            $quality_inspection_report_file = $form['quality_inspection_report_file'];
            $picture_packing_file = $form['picture_packing_file'];
            $safety_product_file = $form['safety_product_file'];
            $reach_certificate_file = $form['reach_certificate_file'];
            //
            if ($specification_file == null) {
                $rules += [
                    'specification_file' => ['required_if:specification,null'],
                ];
            } else {
                $rules += [
                    'specification_file' => 'nullable',
                ];
            }
            //
            if ($quality_inspection_report_file == null) {
                $rules += [
                    'quality_inspection_report_file' => 'required_if:quality_inspection_report,Yes',
                ];
            } else {
                $rules += [
                    'quality_inspection_report_file' => 'nullable',
                ];
            }
            //
            if ($picture_packing_file == null) {
                $rules += [
                    'picture_packing_file' => ['required_if:picture_packing,Yes'],
                ];
            } else {
                $rules += [
                    'picture_packing_file' => 'nullable',
                ];
            }
            //
            if ($safety_product_file == null) {
                $rules += [
                    'safety_product_file' => ['required_if:safety_product,Yes'],
                ];
            } else {
                $rules += [
                    'safety_product_file' => 'nullable',
                ];
            }
            //
            if ($reach_certificate_file == null) {
                $rules += [
                    'reach_certificate_file' => ['required_if:reach_certificate,Yes'],
                ];
            } else {
                $rules += [
                    'reach_certificate_file' => 'nullable',
                ];
            }


        } else {
            //is_create
            $rules += [
                'specification_file' => ['required_if:specification,null'],
                'quality_inspection_report_file' => ['required_if:quality_inspection_report,Yes'],
                'picture_packing_file' => ['required_if:picture_packing,Yes'],
                'safety_product_file' => ['required_if:safety_product,Yes'],
                'reach_certificate_file' => ['required_if:reach_certificate,Yes'],
            ];

        }
        return $rules;
    }
}
