<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    public function index()
    {
        return view('frontend.home.index');
    }
}
