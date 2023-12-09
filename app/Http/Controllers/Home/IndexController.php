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
        $markets = Market::where('start', '>', Carbon::yesterday())->orderBy('start', 'asc')->get();
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
        }
        $UserRegistered = session()->exists('UserRegistered');
        session()->forget('UserRegistered');
        $UserRegistered_message = Message::where('type', 'UserRegistered')->first();
        return view('home.index.index', compact('UserRegistered', 'UserRegistered_message', 'markets'));
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
}
