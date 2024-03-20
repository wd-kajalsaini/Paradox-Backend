<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Ad;

class AdController extends Controller {

    public function __construct() {

    }

    public function index(Request $request) {
        $ads = Ad::get();
        return response()->json(['status' => 1, 'data' => $ads]);
    }

}
