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
use App\Group;
use App\GroupContact;

class GroupController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', []);
    }

    /* Listing of inbox message */

    public function index() {
        $data['page_title'] = 'Groups';
        $data['link'] = 'Groups';
        $data['groupListing'] = Group::with('owner:id,first_name,last_name')->withCount(['group_members'])->get();
        return view('groups.index', $data);
    }

    /* Mark Read */

    public function view($id, Request $request) {
        $data['page_title'] = 'Groups';
        $data['link'] = 'Groups';
        $data['groupDetail'] = Group::with('owner:id,first_name,last_name')->with('group_members')->withCount(['group_members'])->find($id);
        return view('groups.view', $data);
    }

    /* Delete Group */

    public function delete(Request $request, $id) {
        DB::beginTransaction();
        try {
            GroupContact::where(['group_id' => $id])->delete();
            Group::destroy($id);

            DB::commit();
            \Session::flash('message', 'Group Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Group Deleted Successfully"]);
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

}
