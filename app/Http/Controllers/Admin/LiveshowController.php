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
use View;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\ShowBanner;
use App\Show;
use App\SectionShowLink;

class LiveshowController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function index(Request $request){
        $data['page_title'] = 'Live Shows';
        $data['link'] = 'Live_Shows';
        $data['shows'] = Show::whereNotNull('live_at')->whereNull('stop_at')->orderBy('live_at')->withCount(['subscribed_users','show_questions'])->get();
        return view('liveshow.index', $data);
    }

    public function stop($id) {
        $show = Show::find($id);
        $show->fill(['stop_at' => Date("Y-m-d H:i:s")]);
        $show->save();
        return response()->json(['status' => 1, 'message' => "Show removed from live list"]);
    }

}
