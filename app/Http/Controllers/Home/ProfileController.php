<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
}
