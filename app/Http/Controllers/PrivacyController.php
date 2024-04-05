<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function privacy_policy(){
        return view('static_pages/privacyPolicy');
    }
}
