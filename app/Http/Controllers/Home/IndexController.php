<?php

namespace App\Http\Controllers\Home;

use App\Events\SendMessageToClientEvent;
use App\Events\test;
use App\Http\Controllers\Controller;
use App\Models\BidHistory;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $UserRegistered = session()->exists('UserRegistered');
        session()->forget('UserRegistered');
        $UserRegistered_message = Message::where('type', 'UserRegistered')->first();
        return view('home.index.index', compact('UserRegistered', 'UserRegistered_message'));
    }

    public function redirectUser()
    {
        $user_check = auth()->check();
        if ($user_check) {
            $user = auth()->user();
            if ($user->hasRole(['admin', 'seller'])) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home.index');
            }
        } else {
            return redirect()->route('home.index');
        }

    }

    public function bid(Market $market)
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'open_duration')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
        return view('home.market.index', compact('market'));
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
            $markets = Market::where('start', '>', Carbon::now()->copy()->addMinutes(-$endMinutes))->orderBy('start', 'asc')->get();
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
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'open_duration')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
        $market=Market::where('id',$request->market)->first();
        $this->statusTimeMarket($market, $ready_to_duration, $open_duration, $q_1, $q_2, $q_3);
        $market=Market::where('id',$request->market)->first();
        return response()->json([1,$market->Status->title]);
    }

    public function statusTimeMarket($market, $ready_to_duration, $open_duration, $q_1, $q_2, $q_3)
    {
        $startTime = Carbon::parse($market->start);
        $now = Carbon::now();
        $benchmark1 = $startTime->copy()->addMinutes(-$ready_to_duration);
        $benchmark2 = $startTime;
        $benchmark3 = $startTime->copy()->addMinutes($open_duration);
        $benchmark4 = $benchmark3->copy()->addMinutes($q_1);
        $benchmark5 = $benchmark4->copy()->addMinutes($q_2);
        $benchmark6 = $benchmark5->copy()->addMinutes($q_3);
        if ($now < $benchmark1) {
            $status = 1;
            //normal show time
        } elseif ($benchmark1 < $now and $now < $benchmark2) {
            $status = 2;
            //ready to open
        } elseif ($benchmark2 < $now and $now < $benchmark3) {
            $status = 3;
            //open
        } elseif ($benchmark3 < $now and $now < $benchmark4) {
            $status = 4;
            //open(1/3)
        } elseif ($benchmark4 < $now and $now < $benchmark5) {
            $status = 5;
            //open(2/3)
        } elseif ($benchmark5 < $now and $now < $benchmark6) {
            $status = 6;
            //open(3/3)
        } else {
            $status = 7;
            //close
        }
        $market->update(['status' => $status]);
    }

    public function refreshBidTable(Request $request)
    {
        $bids=BidHistory::where('market_id',$request->market)->orderBy('price','desc')->take(5)->get();
        $view =view('home.partials.bids_table',compact('bids'))->render();
        return response()->json([1,$view]);
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
            if (!auth()->user()->hasRole('admin')) {
                $msg = 'You must Bidder!';
                return response()->json(['bidder', $msg]);
            }
            //user can bid or not
            BidHistory::create([
                'user_id' => 1,
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
