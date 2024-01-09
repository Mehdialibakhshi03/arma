<?php

namespace App\Http\Controllers\Home;

use App\Events\ChangeSaleOffer;
use App\Events\MarketStatusUpdated;
use App\Events\NewBidCreated;
use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Models\BidHistory;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\MarketStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class MarketHomeController extends Controller
{
    public function bid(Market $market)
    {
        if (!auth()->check()) {
            session()->flash('Login', 'Please login');
            return redirect()->route('home.index');
        }
        $market_status = $market->status;
//        if ($market_status == 4 or $market_status == 5 or $market_status == 6 ) {
//            session()->flash('market_open_finished','You Just Enter The Market When Is Open');
//            return redirect()->route('home.index');
//        }
        $result = $this->statusTimeMarket($market);
        $market['difference'] = $result[0];
        $market['status'] = $result[1];
        $market['benchmark1'] = $result[2];
        $market['benchmark2'] = $result[3];
        $market['benchmark3'] = $result[4];
        $market['benchmark4'] = $result[5];
        $market['benchmark5'] = $result[6];
        $market['benchmark6'] = $result[7];
        $bids = $market->Bids()->orderBy('price', 'desc')->take(10)->get();
        $bid_deposit_text_area = MarketSetting::where('key', 'bid_deposit_text_area')->pluck('value')->first();
        $term_conditions = MarketSetting::where('key', 'term_conditions')->pluck('value')->first();
        return view('home.market.index', compact('market', 'bids', 'bid_deposit_text_area', 'term_conditions'));
    }

    public function GetMarket(Request $request){
        $market_id=$request->market_id;
        $market=Market::where('id',$market_id)->first();
        $result = $this->statusTimeMarket($market);
        $market['difference'] = $result[0];
        $market['status'] = $result[1];
        $market['benchmark1'] = $result[2];
        $market['benchmark2'] = $result[3];
        $market['benchmark3'] = $result[4];
        $market['benchmark4'] = $result[5];
        $market['benchmark5'] = $result[6];
        $market['benchmark6'] = $result[7];
        $view=view('home.market.benchmark_info',compact('market'))->render();
        return response()->json([1,$view]);
    }

    public function refreshMarketTable()
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'open_duration')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;

        try {
            $markets = Market::where('start', '>', Carbon::yesterday())->orderBy('start', 'asc')->get();
            foreach ($markets as $market) {
                $this->statusTimeMarket($market, $ready_to_duration, $open_duration, $q_1, $q_2, $q_3);
            }
            $view = view('home.partials.market', compact('markets'))->render();
            return response()->json([1, $view]);
        } catch (\Exception $e) {
            return response()->json([0, $e->getMessage()]);
        }
    }

    public function refreshMarket(Request $request)
    {
        $market = Market::where('id', $request->market)->first();
        $result = $this->statusTimeMarket($market);
        $time = $this->convertTime($result[0]);
        $market = Market::where('id', $request->market)->first();
        $market_is_open = 1;
        $market_status = $market->status;
        if ($market_status == 1 or $market_status == 2 or $market_status == 7) {
            $market_is_open = 0;
        }

        return response()->json([1, $market->Status->title, $time, $market->Status->color, $market_is_open]);
    }

    public function refreshBidTable(Request $request)
    {
        $bids = BidHistory::where('market_id', $request->market)->orderBy('price', 'desc')->take(10)->get();
        $view = view('home.market.bidder_table', compact('bids'))->render();
        return response()->json([1, $view]);
    }

    public function refreshSellerTable(Request $request)
    {
        $market = Market::find($request->market);
        $view = view('home.market.seller_table', compact('market'))->render();
        return response()->json([1, $view]);
    }

    public function change_market_status(Request $request)
    {
        try {
            $market_id = $request->market_id;
            $status = $request->status;
            Market::where('id', $market_id)->update([
                'status' => $status
            ]);
            broadcast(new MarketStatusUpdated($market_id));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function seller_change_offer(Request $request)
    {
        try {
            $user_id = auth()->id();
            $price = $request->price;
            $quantity = $request->quantity;
            $market_id = $request->market_id;
            $status = $request->status;
            $market = Market::where('id', $market_id)->first();
            $currency = $market->SalesForm->currency;
//            if ($user_id != $market->user_id) {
//                return response()->json([1, 'error','You Do Not Have Permission To Change Offer']);
//            }
            if ($status == '4') {
                //quotation 1/2
                $pre_max_quantity = $market->SalesForm->max_quantity;
                if ($quantity <= $pre_max_quantity) {
                    return response()->json([1, 'error', 'Just You Can Increase Quantity']);
                }
                $market->SalesForm()->update(['max_quantity' => $quantity]);
            }
            if ($status == '5') {
                //quotation 2/2
                $highest_price_exists = $market->Bids()->Orderby('price', 'desc')->exists();
                if ($highest_price_exists) {
                    $highest = $market->Bids()->Orderby('price', 'desc')->first();
                    $highest_price = $highest->price;
                    if ($price != $highest_price) {
                        return response()->json([1, 'error', 'Your New Price Just Can be: ' . $highest_price . ' ' . $currency]);
                    }
                    $market->SalesForm()->update(['price' => $price]);
                }

            }
            broadcast(new ChangeSaleOffer($market->id));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function bid_market(Request $request)
    {
        $market = Market::find($request->market);
        if ($market->status == 6) {
            $validator = $request->validate([
                'price' => 'required',
            ]);
            $best_bid = $market->Bids()->where('user_id', auth()->id())->orderBy('price', 'asc')->first();
            if ($best_bid){
                $request['quantity'] = $best_bid->quantity;
            }else{
                $message = 'You Cannot Permission To Bid Because You Didnot Enter Any Bid In Previous Level';
                return ['alert','error',$message];

            }
        } else {
            $validator = $request->validate([
                'price' => 'required',
                'quantity' => 'required',
            ]);

        }
        $price = $market->offer_price;
        $min_order = $market->SalesForm->min_order;
        $max_quantity = $market->SalesForm->max_quantity;
        $unit = $market->SalesForm->unit;

        $currency = $market->SalesForm->currency;
        $base_price = $price / 2;


        try {
//            $bid_permission = $this->Bid_Permissions();
//            if ($bid_permission['response'] === 'error') {
//                return response()->json([$bid_permission['response'], $bid_permission['message']]);
//            }
            $Opening_roles = $this->Opening_roles($request->all(), $min_order, $max_quantity, $unit, $currency, $base_price, $price, $market);
            if (!$Opening_roles[0]) {
                $error_type = $Opening_roles['validate_error'];
                $key = $Opening_roles['key'];
                $message = $Opening_roles['message'];
                return response()->json([$error_type, $key, $message]);
            }
            $pre_user_bid=$market->Bids()->where('user_id', auth()->id())->first();
            if ($pre_user_bid){
                $tries=$pre_user_bid->tries+1;
                $pre_user_bid->delete();
            }else{
                $tries=1;
            }
            BidHistory::create([
                'user_id' => auth()->id(),
                'market_id' => $request->market,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'tries' => $tries,
            ]);
            broadcast(new NewBidCreated($request->market));
            return response()->json([1, 'success']);
        } catch (\Exception $e) {
            return response()->json([0, 'error']);
        }
    }

    public function remove_bid(Request $request)
    {
        try {
            $bid_id = $request->bid_id;
            $bid = BidHistory::where('id', $bid_id,)->where('user_id', auth()->id())->first();
            $market_id = $bid->market_id;
            $bid->delete();
            broadcast(new NewBidCreated($market_id));
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    function Opening_roles($request, $min_order, $max_quantity, $unit, $currency, $base_price, $price, $market)
    {
        if ($request['price'] < $base_price) {
            $key = 'price';
            $message = 'min price you can enter is: ' . $base_price . ' ' . $currency;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }
        if ($request['price'] > $price) {
            $key = 'price';
            $message = 'Max price you can enter is: ' . $price . ' ' . $currency;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }
        if ($request['quantity'] > $max_quantity) {
            $key = 'quantity';
            $message = 'Max quantity you can enter is: ' . $max_quantity . ' ' . $unit;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }

        if ($request['quantity'] < $min_order) {
            $key = 'quantity';
            $message = 'Min quantity you can enter is: ' . $min_order . ' ' . $unit;
            return [0 => false, 'validate_error' => 'price_quantity', 'key' => $key, 'message' => $message];
        }
        if ($market->status === 3) {
            $user_bids = $market->Bids()->where('user_id', auth()->id())->where('tries',3)->get();
            if ($user_bids) {
                $key = 'bid number';
                $message = 'Maximum number You Can Bid is: 3';
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }
        $this_my_bid_exists = $market->Bids()->where('price', $request['price'])->where('quantity', $request['quantity'])->where('user_id', auth()->id())->exists();
        if ($this_my_bid_exists) {
            $key = 'bid_exists';
            $message = 'Please enter different Bid';
            return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
        }
        $bid_exists = $market->Bids()->exists();
        if ($bid_exists) {
            $highest_price = $market->Bids()->orderBy('price', 'desc')->first();
            $highest_price = $highest_price->price;
            if ($request['price'] < $highest_price) {
                $key = 'highest_price';
                $message = 'Your New Bid Must Better Than Previous!';
                return [0 => false, 'validate_error' => 'alert', 'key' => $key, 'message' => $message];
            }
        }


        return [0 => true];
    }

    public function Bid_Permissions()
    {
        //            //user must login
        if (!auth()->check()) {
            $msg = 'You must Login!';
            return ['response' => 'error', 'message' => $msg];
        }
//            //user must bidder
        if (!auth()->user()->hasRole('buyer')) {
            $msg = 'You must Buyer!';
            return ['response' => 'error', 'message' => $msg];
        }
        //user can bid
        $user = auth()->user();
        if ($user->can_bid === 0) {
            $msg = 'You Do not have permission to Bid!';
            return ['response' => 'error', 'message' => $msg];
        }
        return ['response' => true, 'message' => 'success'];
    }
}
