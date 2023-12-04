<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Market;
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
}
