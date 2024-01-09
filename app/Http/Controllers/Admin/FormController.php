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
        $role = \auth()->user()->Roles()->first()->name;
        session()->forget('form_id_exists');
        $sale_form_exist = 0;
        $route = route('sale_form.update_or_store');
        $form = [];
        if ($page_type === 'Create') {
            if (isset($_GET['previous_form'])) {
                $sale_form_exist = 1;
                $form = SalesOfferForm::where('id', $_GET['previous_form'])->first();
            } else {

                $form_exist = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 1)->exists();

                if ($form_exist) {
                    $sale_form_exist = 1;
                    $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 0)->where('is_save', 1)->latest()->first();
                } else {

                    $form_exist = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 1)->first();
                    if ($form_exist) {
                        $sale_form_exist = 0;
                        $form = SalesOfferForm::where('user_id', \auth()->id())->where('is_complete', 1)->latest()->first();
                        session()->flash('form_id_exists', $form->id);
                        $form = [];
                    }
                }
            }


        }
        if ($page_type === 'Edit') {
            $sale_form_exist = 1;
            $route = route('sale_form.update_or_store', ['item' => $item]);
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
            'item',
            'role'
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
            if ($validate_items['is_save'] == 1) {
                $user_forms = SalesOfferForm::where('user_id', $sale_form->user_id)->where('id', '!=', $sale_form->id)->get();
                foreach ($user_forms as $user_form) {
                    $user_form->update(['is_save' => 0]);
                }
                session()->flash('success', 'Your Information has been saved successfully');
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id]);
            }
            if ($validator->fails()) {
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
            }
            return redirect()->back()->with('success', 'updated successfully');

        } else {

            $sale_form = SalesOfferForm::create($validate_items->except('_token')->all());
            $sale_form_id = $sale_form->id;
            $unique_number = 'Arma-' . $sale_form_id;
            $sale_form->update(['unique_number', $unique_number]);

            if ($is_complete == 1) {
                session()->flash('need_submit', 1);
            }

            if ($validate_items['is_save'] == 1) {
                $user_forms = SalesOfferForm::where('user_id', $sale_form->user_id)->where('id', '!=', $sale_form->id)->get();
                foreach ($user_forms as $user_form) {
                    $user_form->update(['is_save' => 0]);
                }
                session()->flash('success', 'Your Information has been saved successfully');
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id]);
            }

            if ($validator->fails()) {
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
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
        $items = SalesOfferForm::where('status', $status)->where('is_complete', 1)->paginate(100);
        return view('admin.sales_form.list', compact('items'));
    }

    public function sales_form_remove(Request $request)
    {
        $id = $request->id;
        $sales_form = SalesOfferForm::where('id', $id)->first();
        $sales_form->delete();
        $sales_form_copy = SalesOfferFormCopy::where('id', $id)->first();
        if ($sales_form_copy) {
            $sales_form_copy->delete();
        }

        session()->flash('success', 'Your Item Deleted Successfully');
        return response()->json([1]);
    }

    public function Final_Submit(Request $request)
    {
        try {
            $id = $request->id;
            $sales_form = SalesOfferForm::where('id', $id)->first();
            $sales_form->update(['status' => 1]);
            $role = auth()->user()->Roles()->first()->name;
            if ($role == 'seller') {
                $rote = route('seller.requests');
            }
            if ($role == 'admin') {
                $rote = route('admin.sales_form.index', ['status' => 1]);
            }

            return response()->json([1, $rote]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function sales_form_show(SalesOfferForm $id)
    {
        $role = \auth()->user()->Roles()->first()->name;
        $sale_form_exist = 1;
        $form = $id;
        $route = route('sale_form.update_or_store');
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
        $item = null;
        $is_show = 1;
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
            'item',
            'is_show',
            'role'
        ));
    }

    public function change_status(Request $request)
    {
        try {
            $new_status = $request->status_id;
            $has_deposit = $request->has_deposit;
            $deposit_value = $request->deposit_value;
            $data_pending_message = $request->data_pending_message;
            if ($new_status == 5) {
                if ($has_deposit == 0) {
                    $new_status = 5;
                } else {
                    $new_status = 2;
                }
            }
            $form_id = $request->form_id;
            $sale_form = SalesOfferForm::where('id', $form_id)->first();
            $sale_form->update([
                'status' => $new_status,
                'has_deposit' => $has_deposit,
                'deposit_value' => $deposit_value,
                'data_pending_message' => $data_pending_message,
            ]);
//            if ($new_status == 5) {
//                SalesOfferFormCopy::create($sale_form->toArray());
//            }
            session()->flash('success', 'Successfully Updated');
            return response()->json([1, 'success'], 200);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function rules($item)
    {
        $rules = [
            //company
            'company_name' => 'required',
            'company_type' => 'required',
            //unit and currency
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
            'increase_quantity' => 'nullable',
            'increase_quantity_value' => ['required_if:increase_quantity,Yes'],
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
            'packing_other' => ['required_if:packing,other'],
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
            'exclude_market' => ['required_unless:destination,open'],
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
            'pre_code' => 'required',
            'contact_person_mobile_phone' => 'required',
            'platform' => 'required',
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
                    'safety_product_file' => 'nullable',
                ];
            } else {
                $rules += [
                    'safety_product_file' => 'nullable',
                ];
            }
            //
            if ($reach_certificate_file == null) {
                $rules += [
                    'reach_certificate_file' => 'nullable',
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
