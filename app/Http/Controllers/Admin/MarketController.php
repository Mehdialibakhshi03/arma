<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormValuesDataTable;
use App\Events\MarketTimeUpdated;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\CargoInsurance;
use App\Models\CompanyType;
use App\Models\ContainerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Incoterms;
use App\Models\IncotermsVersion;
use App\Models\InspectionPlace;
use App\Models\Market;
use App\Models\MarketSetting;
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
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MarketController extends Controller
{
    public function index()
    {
        $group_markets = Market::all()->groupby('date');
        return view('admin.markets.index', compact('group_markets'));
    }

    public function create()
    {
        $sales_offer_form_copy = SalesOfferForm::where('status', 5)->get();
        return view('admin.markets.create', compact('sales_offer_form_copy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'commodity_id' => 'required',
            'step_price_competition' => 'required',
            'bid_deposit' => 'required',
            'offer_price' => 'required',
            'description' => 'nullable',
        ]);
        Market::create($request->all());
        session()->flash('success', 'New Market Created Successfully');
        return redirect()->route('admin.markets.index');
    }

    public function edit(Market $market)
    {
        $sales_offer_form_copy = SalesOfferForm::where('status', 5)->get();
        return view('admin.markets.edit', compact('market', 'sales_offer_form_copy'));
    }

    public function update(Market $market, Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'commodity_id' => 'required',
            'step_price_competition' => 'required',
            'bid_deposit' => 'required',
            'offer_price' => 'required',
            'description' => 'nullable',
        ]);
        $request['status'] = 7;
        if (Carbon::now() < $request->start) {
            $request['status'] = 1;
        }
        $market->update($request->all());
        return redirect()->route('admin.markets.index')->with('success', 'Market updated successfully');
    }

    public function sales_form($page_type = 'Create', $item = 'null')
    {
        $sale_form_exist = 0;
        $route = null;
        $form = [];
        if ($page_type === 'Create') {
            $route = route('admin.market.sale_form.update_or_store');
            $form_exist = SalesOfferForm::where('user_id', \auth()->id())->exists();
            if ($form_exist) {
                $sale_form_exist = 1;
                $form = SalesOfferForm::where('user_id', \auth()->id())->latest()->first();
            }
        }
        if ($page_type === 'Edit') {
            $sale_form_exist = 1;
            $route = route('admin.market.sale_form.update_or_store', ['item' => $item]);
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
        return view('admin.markets.sales_form', compact(
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

    public function settings()
    {
        $ready_to_open = MarketSetting::where('key', 'ready_to_open')->pluck('value')->first();
        $opening = MarketSetting::where('key', 'opening')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $bid_deposit_text_area=MarketSetting::where('key', 'bid_deposit_text_area')->pluck('value')->first();
        $term_conditions=MarketSetting::where('key', 'term_conditions')->pluck('value')->first();
        return view('admin.markets.setting', compact('q_1', 'q_2', 'q_3', 'ready_to_open', 'opening','bid_deposit_text_area','term_conditions'));
    }

    public function settings_update(Request $request)
    {
        $ready_to_open = $request->ready_to_open;
        $opening = $request->opening;
        $q_1 = $request->q_1;
        $q_2 = $request->q_2;
        $q_3 = $request->q_3;
        $bid_deposit_text_area = $request->bid_deposit_text_area;
        $term_conditions = $request->term_conditions;
        $array = [
            'ready_to_open' => $ready_to_open,
            'opening' => $opening,
            'q_1' => $q_1,
            'q_2' => $q_2,
            'q_3' => $q_3,
            'bid_deposit_text_area' => $bid_deposit_text_area,
            'term_conditions' => $term_conditions,
        ];
        foreach ($array as $key => $val) {
            MarketSetting::where('key', $key)->update(['value' => $val]);
        }
        session()->flash('success', 'Successfully updated');
        broadcast(new MarketTimeUpdated());
        return redirect()->back();
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
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
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
                return redirect()->route('sale_form', ['page_type' => 'Edit', 'item' => $sale_form->id])->withErrors($validator->errors());
            }
        }
    }

    public function getMarket(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $market = Market::where('id', $market_id)->first();
            $status = $market->Status->title;
            $color = $market->Status->color;
            return response()->json([1, $status, $color]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }

    }

    public function check_market_status_for_continue(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $status = $request->status;
            $market = Market::find($market_id);
            $price = $market->offer_price;
            $max_quantity = $market->SalesForm->max_quantity;
            if ($status===4){
                $base_price = $price / 2;
                $bids = $market->Bids()->where('price', '>=', $base_price)->get();
                if (count($bids)>0){
                    return response()->json([1,'continue']);
                }
                $market->update([
                    'status'=>7
                ]);
                return response()->json([1,'close']);
            }
            if ($status==6){
                $bids_exists = $market->Bids()->where('price', '>=', $price)->exists();
                if (!$bids_exists){
                    $market->update([
                        'status'=>7
                    ]);
                    return response()->json([1,'close']);
                }
                $bids_quantity = $market->Bids()->where('price', '>=', $price)->sum('quantity');
                if ($max_quantity>=$bids_quantity){
                    $market->update([
                        'status'=>8
                    ]);
                    return response()->json([1,'finish']);
                }else{
                    return response()->json([1,'continue']);
                }
            }

        }catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function Upload_files($env, $file)
    {
        $fileNamePrimaryImage = generateFileName($file->getClientOriginalName());
        $file->move(\public_path($env), $fileNamePrimaryImage);
        return $fileNamePrimaryImage;
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
