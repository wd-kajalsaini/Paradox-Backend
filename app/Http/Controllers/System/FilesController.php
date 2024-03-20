<?php
namespace App\Http\Controllers\System;
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
class FilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
        
    }
    public function index()
    {
        $data['page_title']='Files';
        $data['link']='Files';
        return view('system.files',$data);
    }
    
    
}
