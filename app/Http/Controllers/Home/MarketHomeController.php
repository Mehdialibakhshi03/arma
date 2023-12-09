<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BidHistory;
use App\Models\Market;
use App\Models\MarketSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarketHomeController extends Controller
{
    public function bid(Market $market)
    {
        $result=$this->statusTimeMarket($market);
        $market['difference']=$result[0];
        $market['status']=$result[1];
        $market['benchmark1']=$result[2];
        $market['benchmark2']=$result[3];
        $market['benchmark3']=$result[4];
        $market['benchmark4']=$result[5];
        $market['benchmark5']=$result[6];
        $market['benchmark6']=$result[7];
        $bids = $market->Bids()->orderBy('price', 'desc')->take(10)->get();
        return view('home.market.index', compact('market','bids'));
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
        $view = view('home.partials.bids_table', compact('bids'))->render();
        return response()->json([1, $view]);
    }

    public function bid_market(Request $request)
    {
        $validator = $request->validate([
            'price' => 'required',
            'quantity' => 'required',
        ]);
        try {
            //user must login
            if (!auth()->check()) {
                $msg = 'You must Login!';
                return response()->json(['login', $msg]);
            }
            //user must bidder
            if (!auth()->user()->hasRole('buyer')) {
                $msg = 'You must Buyer!';
                return response()->json(['bidder', $msg]);
            }
            //user can bid or not
            $pre_bid = BidHistory::where('user_id', auth()->id())->where('market_id', $request->market)->first();
            if ($pre_bid) {
                if ($request->price <= $pre_bid->price) {
                    $msg = 'Your New Bid Must Better Than Previous!';
                    return response()->json(['better_Bid', $msg]);
                }
                $pre_bid->delete();
            }
            BidHistory::create([
                'user_id' => auth()->id(),
                'market_id' => $request->market,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);
            return response()->json([1, 'success']);
        } catch (\Exception $e) {
            return response()->json([0, 'error']);
        }
    }
}
