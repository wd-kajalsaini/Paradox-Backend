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

class BannerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function shows(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            try{
                DB::beginTransaction();
                ShowBanner::truncate();
                foreach($input['shows'] as $show_key => $show){
                    $banner_show[] = ['show_id' => $show, 'sort_order' => ($show_key+1), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                ShowBanner::insert($banner_show);
                DB::commit();
                \Session::flash('message', 'Banner updated successfully!');
                \Session::flash('class', 'success');
            } catch (Exception $e) {
                DB::rollBack();
                \Session::flash('message', 'Something went wrong');
                \Session::flash('class', 'error');
            }
            return redirect()->route('bannerShowsListing');
        }
        $data['page_title'] = 'Banner Shows';
        $data['link'] = 'Banner_Shows';
        $data['shows'] = ShowBanner::with('show_list')->orderBy('sort_order')->get();
        $data['overall_shows'] = Show::select('id','title','banner')->get();
        $sections_shows = ShowBanner::get()->toArray();
        $data['selected_shows'] = array_column($sections_shows,'show_id');
        return view('banner.shows', $data);
    }

    public function showSort(Request $request){
        $input = $request->all();
        if (isset($input['orderArray']) && !empty($input['orderArray'])) {
            $order = array_column($input['orderArray'], 'data_order');
            sort($order);
            foreach ($input['orderArray'] as $key => $value) {
                ShowBanner::where(['id' => $value['data_id']])->update(['sort_order' => $order[$key]]);
            }
        }
    }

}
