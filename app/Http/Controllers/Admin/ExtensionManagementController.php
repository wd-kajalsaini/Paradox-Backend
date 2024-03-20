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
use App\CountryExtension;
use App\Exports\ExtensionExport;
use App\Imports\ExtensionImport;
use Maatwebsite\Excel\Facades\Excel;

class ExtensionManagementController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['app_content_field_ajax']]);
    }

    /* Listing of extensions */

    public function index() {
        $data['page_title'] = 'Extension Management';
        $data['link'] = 'Extension_Management';
        $data['country_extensions'] = CountryExtension::get();

        return view('extension_management.index', $data);
    }

    /* Add extension */

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new CountryExtension();
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Extension added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('extensionManagementListing');
            }
        }
        $data['page_title'] = 'Add Extension';
        $data['link'] = 'Extension_Management';

        return view('extension_management.add', $data);
    }

    /* Edit extension */

    public function edit(Request $request, $id) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = CountryExtension::find($id);
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Extension updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('extensionManagementListing');
            }
        }
        $data['page_title'] = 'Edit Extension';
        $data['link'] = 'Extension_Management';
        $data['country_extension'] = CountryExtension::find($id);
        return view('extension_management.edit', $data);
    }

    /* Delete Extension */

    public function delete(Request $request, $id) {
        if (CountryExtension::destroy($id)) {
            \Session::flash('message', 'Extension Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Extension Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

    public function export() {
        return Excel::download(new ExtensionExport, 'extension_template' . date('Ymdhis') . '.xlsx');
    }

    public function import(Request $request) {
        try {
            $import = new ExtensionImport();
            $import->import($request->file('iExtension'));
            \Session::flash('message', 'Data Imported Successfully.');
            \Session::flash('class', 'success');
            return back();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $k => $failure) {
                $errors[$k]['Rows'] = $failure->row();
                $errors[$k]['errors'] = $failure->errors(); // Actual error messages from Laravel validator
            }

            $mErrors = [];
            foreach ($errors as $k => $error) {
                foreach ($error['errors'] as $err) {
                    $mErrors[$error['Rows']][] = $err;
                }
            }
            foreach ($mErrors as $row => $errors) {
                $mErrors[$row] = implode(', ', $errors);
            }

            $errorHtml = View::make('extension_management/importStatus', ['errors' => $mErrors]);
            $errorHtml = $errorHtml->render();
//             \Session::flash('import_error', $errorHtml);
            return back()->with('import_error',$errorHtml);
        }
    }

}
