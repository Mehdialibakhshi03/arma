<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewUserRegisteredForAdminJob;
use App\Models\Market;
use App\Models\Message;
use App\Models\Setting;
use Carbon\Carbon;
use http\Env\Request;

class IndexController extends Controller
{
    public function index()
    {

        $UserRegistered = session()->exists('UserRegistered');
        session()->forget('UserRegistered');
        $UserRegistered_message = Message::where('type', 'UserRegistered')->first();
        $markets = Market::where('start', '>', Carbon::today())->get();
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

    public function bid(Market $market)
    {
        return view('home.market.index',compact('market'));
    }
}
