<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\CargoInsurance;
use App\Models\CompanyType;
use App\Models\ContainerType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\FlexiTankType;
use App\Models\Incoterms;
use App\Models\IncotermsVersion;
use App\Models\InspectionPlace;
use App\Models\Packing;
use App\Models\PaymentTerm;
use App\Models\PriceType;
use App\Models\QualityQuantityInspector;
use App\Models\SalesOfferForm;
use App\Models\ShippingTerm;
use App\Models\TargetMarket;
use App\Models\THCIncluded;
use App\Models\ToleranceWeightBy;
use App\Models\Units;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        return view('seller.dashboard');
    }

    public function profile()
    {
        return view('seller.profile');
    }

    public function requests()
    {
        $id = auth()->id();
        $items = SalesOfferForm::where('user_id', $id)->where('is_complete', 1)->paginate();
        return view('seller.sales_form.list', compact('items'));
    }

}
