<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user=auth()->user();
        return view('home.profile.index',compact('user'));
    }
}
