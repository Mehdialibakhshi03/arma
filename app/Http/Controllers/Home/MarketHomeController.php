<?php

namespace App\Http\Controllers\Home;

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
        $market_status=$market->status;
        if($market_status==4 or $market_status==5 or $market_status==6){
            return redirect()->route('home.index');
        }
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
        return view('home.market.index', compact('market', 'bids'));
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
            $market = Market::where('id', $market_id)->first();
            if ($user_id != $market->user_id) {
                return response()->json([1, 'user_different']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function bid_market(Request $request)
    {
        $validator = $request->validate([
            'price' => 'required',
            'quantity' => 'required',
        ]);
        $market = Market::find($request->market);
        $price = $market->SalesForm->price;
        $min_order = $market->SalesForm->min_order;
        $max_quantity = $market->SalesForm->max_quantity;
        $unit = $market->SalesForm->unit;

        $currency = $market->SalesForm->currency;
        $base_price = $price / 2;
        $Opening_roles = $this->Opening_roles($request->all(), $min_order, $max_quantity, $unit, $currency, $base_price, $price, $market);
        if (!$Opening_roles[0]) {
            $error_type = $Opening_roles['validate_error'];
            $key = $Opening_roles['key'];
            $message = $Opening_roles['message'];
            return response()->json([$error_type, $key, $message]);
        }

        try {
//            //user must login
//            if (!auth()->check()) {
//                $msg = 'You must Login!';
//                return response()->json(['login', $msg]);
//            }
//            //user must bidder
//            if (!auth()->user()->hasRole('buyer')) {
//                $msg = 'You must Buyer!';
//                return response()->json(['bidder', $msg]);
//            }
//            //user can bid or not
//            $pre_bid = BidHistory::where('user_id', auth()->id())->where('market_id', $request->market)->first();
//            if ($pre_bid) {
//                if ($request->price <= $pre_bid->price) {
//                    $msg = 'Your New Bid Must Better Than Previous!';
//                    return response()->json(['better_Bid', $msg]);
//                }
//                $pre_bid->delete();
//            }
            BidHistory::create([
                'user_id' => 1,
                'market_id' => $request->market,
                'price' => $request->price,
                'quantity' => $request->quantity,
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
            $bid=BidHistory::where('id', $bid_id,)->where('user_id', auth()->id())->first();
            $market_id=$bid->market_id;
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
            $user_bids = $market->Bids()->where('user_id', auth()->id())->get();
            if (count($user_bids) > 2) {
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
}
