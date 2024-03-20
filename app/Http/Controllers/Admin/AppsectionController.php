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
use App\AppSection;
use App\Show;
use App\SectionShowLink;

class AppsectionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function index(){
        $data['page_title'] = 'Section';
        $data['link'] = 'Section_Management';
        $data['sections'] = AppSection::withCount('shows')->orderBy('sort_order')->get();
        return view('sections.index', $data);
    }

        /* Sort order */

    public function sortOrder(Request $request){
        $input = $request->all();
        if (isset($input['orderArray']) && !empty($input['orderArray'])) {
            $order = array_column($input['orderArray'], 'data_order');
            sort($order);
            foreach ($input['orderArray'] as $key => $value) {
                AppSection::where(['id' => $value['data_id']])->update(['sort_order' => $order[$key]]);
            }
        }
    }

    public function add(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new AppSection();

            $newDataField = ['name' => $input['name']];
            $sortValue = AppSection::max('sort_order');
            $newDataField['sort_order'] = $sortValue+1;
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                foreach($input['shows'] as $show_key => $show){
                    $section_show[] = ['section_id' => $newData->id, 'show_id' => $show, 'sort_order' => ($show_key+1),'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                SectionShowLink::insert($section_show);
                DB::commit();
                \Session::flash('message', 'Section added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('appSectionsListing');
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Add Section';
        $data['link'] = 'Section_Management';
        $data['shows'] = Show::select('id','title','banner')->get();

        return view('sections.add', $data);
    }

    public function edit($id, Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = AppSection::find($id);

            $newDataField = ['name' => $input['name']];
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                SectionShowLink::where(['section_id' => $newData->id])->delete();
                foreach($input['shows'] as $show_key => $show){
                    $section_show[] = ['section_id' => $newData->id, 'show_id' => $show, 'sort_order' => ($show_key+1), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                SectionShowLink::insert($section_show);
                DB::commit();
                \Session::flash('message', 'Section added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('appSectionsListing');
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Edit Section';
        $data['link'] = 'Section_Management';
        $data['section_data'] = AppSection::find($id);
        $data['shows'] = Show::select('id','title','banner')->get();
        $sections_shows = SectionShowLink::where(['section_id' => $id])->get()->toArray();
        $data['selected_shows'] = array_column($sections_shows,'show_id');

        return view('sections.edit', $data);
    }

    /* Delete Section */

    public function delete($id) {
        if (AppSection::destroy($id)) {
            \Session::flash('message', 'Section Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Section Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

    public function shows($id, Request $request){
        $data['page_title'] = 'Section Shows';
        $data['link'] = 'Section_Management';
        $data['shows'] = SectionShowLink::with('show_list')->where(['section_id' =>$id])->orderBy('sort_order')->get();
        return view('sections.shows', $data);
    }

    public function showSort(Request $request){
        $input = $request->all();
        if (isset($input['orderArray']) && !empty($input['orderArray'])) {
            $order = array_column($input['orderArray'], 'data_order');
            sort($order);
            foreach ($input['orderArray'] as $key => $value) {
                SectionShowLink::where(['id' => $value['data_id']])->update(['sort_order' => $order[$key]]);
            }
        }
    }

}
