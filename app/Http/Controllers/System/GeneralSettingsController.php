<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Managers;
use DB;
use App\Permissions;
use App\Sections;
use Route;
use App\ManagerTypes;
use Auth;
use Storage;
use Hash;
use File;
use App\Dictionary;
use App;
use Cookie;
use App\User;

class GeneralSettingsController extends Controller {
   
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    /* Retrieve all the application users */

    public function index() {
        $data['page_title'] = 'System/General Settings';
        $data['link'] = 'Users';
        $data['userListing'] = User::get();
        return view('users.index', $data);
    }

}