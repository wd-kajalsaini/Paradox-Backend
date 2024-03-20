<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sections;
use DB;
use App\User;
use App\Inbox;
use App\ActiveUsersRecord;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $data['page_title'] = 'Dashboard';
        $data['link'] = 'Dashboard';
        $data['total_users'] = User::where(['is_verified' => 1])->count();
        $data['total_payments_for_products'] = 0;
        $data['unread_messages'] = Inbox::where(['is_read' => 0])->count();
        $data['online_users'] = User::where(['is_online' => 1])->count();
        $data['inbox_data'] = Inbox::where(['is_read' => 0])->take(10)->orderBy('id', 'desc')->get();
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        for ($i = 1; $i <= $num_of_days; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $active_users_count = ActiveUsersRecord::whereDate('created_at',date('Y').'-'.date('m').'-'.$day)->count();
            $dates[] = array($day,$active_users_count);
        }
        $data['active_users'] = json_encode($dates);
        return view('dashboard', $data);
    }

    public function graph_data(Request $request){
        $input = $request->all();
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $input['month'], date('Y'));
        for ($i = 1; $i <= $num_of_days; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $active_users_count = ActiveUsersRecord::whereDate('created_at',date('Y').'-'.$input['month'].'-'.$day)->count();
            $dates[] = array($day,$active_users_count);
        }
        echo json_encode($dates);
    }

}
