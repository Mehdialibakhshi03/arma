<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $yesterday = Carbon::yesterday();
        $tomorrow = Carbon::tomorrow();
        $future = $yesterday->copy()->addDay(4);
        $markets_groups = Market::where('date', '>', $yesterday)->where('date', '<', $future)->get()->groupby('date');
        $latest_today_market = Market::where('date', '>', $yesterday)->where('date', '<', $tomorrow)->orderby('time', 'desc')->first();
        if ($latest_today_market) {
            $latest_today_market_id = $latest_today_market->id;
        } else {
            $latest_today_market_id = null;
        }
        foreach ($markets_groups as $markets) {
            foreach ($markets as $market) {
                $result = $this->statusTimeMarket($market);
                $market['difference'] = $result[0];
                $market['status'] = $result[1];
                $market['benchmark1'] = $result[2];
                $market['benchmark2'] = $result[3];
                $market['benchmark3'] = $result[4];
                $market['benchmark4'] = $result[5];
                $market['benchmark5'] = $result[6];
                $market['benchmark6'] = $result[7];
                $market['date_time'] = $result[8];
            }
        }

        $UserRegistered = session()->exists('UserRegistered');
        session()->forget('UserRegistered');
        $UserRegistered_message = Message::where('type', 'UserRegistered')->first();
        return view('home.index.index', compact('UserRegistered', 'UserRegistered_message', 'markets_groups', 'latest_today_market_id'));
    }

    public function redirectUser()
    {
        $user_check = auth()->check();
        if ($user_check) {
            $user = auth()->user();
            if ($user->hasRole(['admin'])) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole(['seller'])) {
                return redirect()->route('seller.dashboard');
            }
            if ($user->hasRole(['bidder'])) {
                return redirect()->route('bidder.dashboard');
            }
            dd('redirectUser');
        } else {
            return redirect()->route('home.index');
        }

    }
}
