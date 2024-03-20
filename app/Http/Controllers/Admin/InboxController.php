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
use App\Inbox;

class InboxController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['mark_read']]);
    }

    /* Listing of inbox message */

    public function index() {
        $data['page_title'] = 'Inbox';
        $data['link'] = 'Inbox';
        $data['inbox_data'] = Inbox::get();

        return view('inbox.index', $data);
    }

    /* Mark Read */

    public function mark_read(Request $request) {
        $input = $request->all();
        Inbox::where(['id' => $input['data_id']])->update(['is_read' => 1]);
        $inboxMessage = Inbox::with('sender:id,first_name,last_name,avatar')->find($input['data_id']);
        return view('inbox.message', ['inboxMessage' => $inboxMessage]);
    }

}
