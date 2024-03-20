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
use App\KvitelProduct;

class KvitelProductController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['app_content_field_ajax']]);
    }

    /* Listing of extensions */

    public function index() {
        $data['page_title'] = 'Kvitel Products';
        $data['link'] = 'Kvitel_Products';
        $data['kvitel_products'] = KvitelProduct::get();

        return view('kvitel_products.index', $data);
    }

    /* Add extension */

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new KvitelProduct();
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            if (empty($input['is_best'])) {
                $newDataField['is_best'] = 0;
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Product added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('kvitelProductsListing');
            }
        }
        $data['page_title'] = 'Kvitel Products';
        $data['link'] = 'Kvitel_Products';

        return view('kvitel_products.add', $data);
    }

    /* Edit extension */

    public function edit(Request $request, $id) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = KvitelProduct::find($id);
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            if (empty($input['is_best'])) {
                $newDataField['is_best'] = 0;
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Extension updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('kvitelProductsListing');
            }
        }
        $data['page_title'] = 'Edit Product';
        $data['link'] = 'Kvitel_Products';
        $data['kvitel_product'] = KvitelProduct::find($id);
        return view('kvitel_products.edit', $data);
    }

    /* Delete Extension */

    public function delete(Request $request, $id) {
        if (KvitelProduct::destroy($id)) {
            \Session::flash('message', 'Product Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Product Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

}
