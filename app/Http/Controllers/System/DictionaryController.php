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
class DictionaryController extends Controller
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
    public function dictionary()
    {
       
        $data['dictionary'] = Dictionary::get();
        $data['page_title']='Dictionary';
        $data['link']='Dictionary';
        return view('system.dictionary',$data);
    }
    //add dictionary
    public function addDictionary(Request $request)
    {
        
        if($request->isMethod('post')){

            $request->validate([
            
                'variable' => 'required',
                'english' => 'required',
                'hebrew' => 'required'
            ]);
            // database transaction
            DB::beginTransaction();
            try {
                $dictionaryData=collect($request->all())->forget('_token')->toArray();
                $dictionary =Dictionary::insert($dictionaryData);
                DB::commit();
                //create or update dictionary files
                $this->createLangFile();
                \Session::flash('message', 'Successfully Created Dictionary');
                \Session::flash('class', 'success');   
                return redirect()->route('dictionaryListing');
            } catch (\Exception $e) {
                // something went wrong
                DB::rollback();
                \Session::flash('message', 'Not Successfull ');
                \Session::flash('class', 'danger');
                return redirect()->route('dictionaryListing');   
                
            }
            
        }
        else{
            // redirect to view
            $data['page_title']='Dictionary';
            $data['link']='Dictionary';
            return view('system.addDictionary',$data);
        }
    }
    //edit dictionary
    public function editDictionary(Request $request,$id)
    {
        
        if($request->isMethod('post')){


            $request->validate([
            
                'variable' => 'required',
                'english' => 'required',
                'hebrew' => 'required'
            ]);
            //database transaction
            DB::beginTransaction();
            try {
                $dictionaryData=collect($request->all())->forget('_token')->toArray();
                $dictionary =Dictionary::where('id',$id)->update($dictionaryData);
                DB::commit();
                $this->createLangFile();//create or update dictionary files
                \Session::flash('message', 'Successfully Updated Dictionary');
                \Session::flash('class', 'success');   
                return redirect()->route('dictionaryListing');
            } catch (\Exception $e) {
                // something went wrong
                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Updated Dictionary');
                \Session::flash('class', 'danger');
                return redirect()->route('dictionaryListing');   
                
            }
            
        }
        else{
            // redirect to view
            $data['dictionary'] = Dictionary::find($id);
            $data['page_title']='Dictionary';
            $data['link']='Dictionary';
            return view('system.editDictionary',$data);
        }
    }
    // create and update language dictionary file
    public function createLangFile()
    {
        $dictionary = Dictionary::get();
        $arabic = [];
        $english = [];
        $hebrew = [];
        $russian = [];
        foreach($dictionary as $key=>$dictionary)
        {
            $arabic[$dictionary->variable]=$dictionary->arabic;
            $english[$dictionary->variable]=$dictionary->english;
            $hebrew[$dictionary->variable]=$dictionary->hebrew;
            $russian[$dictionary->variable]=$dictionary->russian;
        }
        //for arabic language
        if(!empty($arabic))
        {
            $fp = fopen(resource_path('lang/ar.json'), 'w');
            fwrite($fp, json_encode($arabic));
            fclose($fp);
        }
        //for english language
        if(!empty($english))
        {
            $fp = fopen(resource_path('lang/en.json'), 'w');
            fwrite($fp, json_encode($english));
            fclose($fp);
        }
        //for hebrew language
        if(!empty($hebrew))
        {
            $fp = fopen(resource_path('lang/hb.json'), 'w');
            fwrite($fp, json_encode($hebrew));
            fclose($fp);
        }
        //for russian language
        if(!empty($russian))
        {
            $fp = fopen(resource_path('lang/ru.json'), 'w');
            fwrite($fp, json_encode($russian));
            fclose($fp);
        }
        
    }
    //set locale  // echo "<pre>";
            // print_r($sections);die;
    public function setLocale($locale)
    {
        Cookie::forget('locale'.Auth::user()->id);
        Cookie::queue('locale'.Auth::user()->id, $locale, 43800);
        return redirect()->back();
    }
    
}
