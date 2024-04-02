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
class ManagersController extends Controller
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
    //manager and managerType listing
    public function managers()
    {

        $data['managers']=Managers::where('type','!=','Super Manager')->with('managerType')->get();
        $data['managerTypes']=ManagerTypes::where('name','!=','Super Manager')->get();
        $data['page_title']='system';
        $data['link']='Managers';
        return view('system/manager',$data);
    }
    //add manager
    public function addManager(Request $request)
    {

        if($request->isMethod('post'))
        {

            $request->validate([

                'manager_type' => 'required',
                'status' => 'required',
                'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-7])(?=.*?[#?!@$%^&*-_]).{6,}$/',
                'confirm_password' => 'required|same:password',
                'first_name' => 'required|min:3',
                'last_name' => 'required|min:2',
                'phone' => 'required',
                'email' => 'required|email|unique:managers',
                //'image' => 'required'

            ],
            [
                'password.regex'=>'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.',
                'confirm_password.same' => 'Confirm Password  should match the Password'
            ]);
            $managerType = ManagerTypes::where('id',$request->manager_type)->first();
            $managerData = collect($request->all())->forget(['_token','manager_type','confirm_password'])->put('type_id',$request->manager_type)->put('password',Hash::make($request->password))->put('type',$managerType->name)->toArray();
            if ($request->hasFile('image')) {
                $image  = $request->file('image');
                $fileName   = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName,File::get($image));
                $managerData['image']=$fileName;


            }
            else
            {
                $managerData['image']="";
            }
            $managerData['role'] =$managerType ->name;
            $manager = new Managers();
            $manager->fill($managerData);

            if($manager->save())
            {
                \Session::flash('message', 'Successfully Create Manager ');
                \Session::flash('class', 'success');
                return redirect()->route('managersListing');

            }
            else{


                \Session::flash('message', 'Unsuccesssfully Create Manager');
                \Session::flash('class', 'danger');
                return redirect()->route('managersListing');
            }
        }
        else
        {
            $data['managersTypes']=ManagerTypes::where('name','!=','Super Manager')->get();
            $data['page_title']='system';
            $data['link']='Managers';
            return view('system/addManager',$data);
        }

    }
    // add managerType
    public function addManagerType(Request $request)
    {
        if($request->isMethod('post'))
        {
            $request->validate([

                'name' => 'required'
            ]);
            DB::beginTransaction();
            try {

                $managerType =new ManagerTypes();
                $managerType->fill(['name'=>$request->name]);
                $managerType->save();
                $permissions=[];
                $subPermissions=[];

                foreach($request->sectionId as $key=>$sectionId)
                {

                    if(is_array($sectionId))
                    {
                        $parentSection = Sections::where(['id'=>$key])->first();//get parent id


                        $parentPerm = $request->permission[$key];

                        if($parentSection->parent_id!="main")
                        {
                            if($request->permission[$parentSection->parent_id]==2)
                            {

                                $parentPerm = $request->permission[$key];
                            }
                            else
                            {

                                $parentPerm = $request->permission[$parentSection->parent_id];
                            }

                        }

                        $permissions[$key]['section_id']=$key;
                        $permissions[$key]['manager_type_id']=$managerType->id;
                        $permissions[$key]['permission']= $parentPerm;
                        $subPermissions[$key] = $this->createSubPermissions($parentPerm,$sectionId,$managerType->id,$request->permission);


                    }
                    else
                    {
                        $permissions[$key]['section_id']=$sectionId;
                        $permissions[$key]['manager_type_id']=$managerType->id;
                        $permissions[$key]['permission']=$request->permission[$key];
                    }


            }

            $per = $permissions;
            foreach($subPermissions as $subPermission)
            {


                $per = array_merge($subPermission,$per);

            }
            $permission = Permissions::insert($per);
            DB::commit();
            \Session::flash('message', 'Successfully Created Manager Type');
            \Session::flash('addManagerType', '  ');
            \Session::flash('class', 'success');
            return redirect()->route('managersListing');
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Created Manager Type');
                \Session::flash('addManagerType', '  ');
                \Session::flash('class', 'danger');
                return redirect()->route('managersListing');
                // something went wrong
            }
        }
        else
        {
            $sections = Sections::where(['parent_id'=>'main'])->with('subSections')->get()->toArray();
            // foreach ($sections as $key => $section)
            // {
            //     $sections[$key]->subSections = Sections::where(['parent_id'=>$section->id])->get();
            //     foreach($sections[$key]->subSections as $k=>$subSections)
            //     {
            //         $sections[$key]->subSections[$k]->sSubSections = Sections::where(['parent_id'=>$subSections->id])->get();
            //     }
            // }
            // echo "<pre>";
            // print_r($sections);
            // die;
            $data['hSections'] = $sections;
            $data['page_title']='system';
            $data['link']='Managers';
            return view('system/addManagerType',$data);
        }

    }
    //edit managerType
    public function editManagerType(Request $request,$id)
    {
        if($request->isMethod('post'))
        {
            $request->validate([

                'name' => 'required|min:5'
            ]);

            DB::beginTransaction();
            try {
            $managerType =ManagerTypes::find($id);
            $managerType->fill(['name'=>$request->name]);
            $managerType->save();


            $permissions=[];
            $subPermissions=[];
            foreach($request->sectionId as $key=>$sectionId)
            {
                if(is_array($sectionId))
                {

                    $parentSection = Sections::where(['id'=>$key])->first();//get parent id
                    $parentPerm = $request->permission[$key];
                    if($parentSection->parent_id!="main")
                    {
                        if($request->permission[$parentSection->parent_id]==2)
                        {

                            $parentPerm = $request->permission[$key];
                        }
                        else
                        {

                            $parentPerm = $request->permission[$parentSection->parent_id];
                        }

                    }
                    $permissions[$key]['section_id']=$key;
                    $permissions[$key]['manager_type_id']=$managerType->id;
                    $permissions[$key]['permission']= $parentPerm;
                    $subPermissions[$key] = $this->createSubPermissions($parentPerm,$sectionId,$managerType->id,$request->permission);
                }
                else
                {
                    $permissions[$key]['section_id']=$sectionId;
                    $permissions[$key]['manager_type_id']=$managerType->id;
                    $permissions[$key]['permission']=$request->permission[$key];
                }

            }

            $per = $permissions;
            foreach($subPermissions as $subPermission)
            {

                $per = array_merge($subPermission,$per);

            }

            foreach($per as $key=>$permission)
            {
                $permission = Permissions::updateOrCreate(['manager_type_id'=>$id,'section_id'=>$permission['section_id']],['permission'=>$permission['permission'],'section_id'=>$permission['section_id']]);
            }

            DB::commit();
            \Session::flash('message', 'Successfully Updated Manager Type');
            \Session::flash('class', 'success');
            \Session::flash('addManagerType', '  ');
            return redirect()->route('managersListing');
            } catch (\Exception $e) {
                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Updated Manager Type');
                \Session::flash('class', 'danger');
                \Session::flash('addManagerType', '  ');
                return redirect()->route('managersListing');
                // something went wrong
            }
        }
        else
        {
            // $sections = Sections::where(['parent_id'=>'main'])->with('subSections')->with(['permission'=>function($query)use($id){
            //     $query->where('manager_type_id',$id);
            // }])->get()->toArray();
            $sections = Sections::where(['parent_id'=>'main'])->with(['permission'=>function($query)use($id){
                            $query->where('manager_type_id',$id);
                             }])->get()->toArray();
            foreach($sections as $key => $section)
            {
                $sections[$key]['sub_sections'] = Sections::where(['parent_id'=>$section['id']])->with(['permission'=>function($query)use($id){
                                                    $query->where('manager_type_id',$id);
                                                }])->get()->toArray();
                foreach($sections[$key]['sub_sections'] as $k=>$subSections)
                {
                    $sections[$key]['sub_sections'][$k]['sub_sections'] = Sections::where(['parent_id'=>$subSections['id']])->with(['permission'=>function($query)use($id){
                                                                            $query->where('manager_type_id',$id);
                                                                        }])->get()->toArray();
                }
            }

            $data['manager'] = ManagerTypes::where('id',$id)->first();
            $data['hSections'] = $sections;
            $data['page_title']='system';
            $data['link']='Managers';

            return view('system/editManagerType',$data);
        }


    }
    public function createSubPermissions($parentPerm,$sectionIds,$managerId,$spermissions) //create Subsections permissions
    {
        $permissions=[];


            foreach($sectionIds as $key=>$sectionId)
            {


                    if($parentPerm == 2)
                    {
                        $chlidPerm = $spermissions[$key];
                    }
                    else
                    {
                        $chlidPerm = 0;
                    }
                    $permissions[$key]['section_id']=$sectionId;
                    $permissions[$key]['manager_type_id']=$managerId;
                    $permissions[$key]['permission']=$chlidPerm;



            }

        return $permissions;
    }
    public function deleteManagerType($id)
    {

        DB::beginTransaction();
        try {

            DB::commit();
            \Session::flash('message', 'Successfully Updated Manager Type');
            \Session::flash('class', 'success');
            return redirect()->route('managersListing');
        } catch (\Exception $e) {
            DB::rollback();
            \Session::flash('message', 'Unsuccessfully Updated Manager Type');
            \Session::flash('class', 'danger');
            return redirect()->route('managersListing');
            // something went wrong
        }
    }

    public function editManager(Request $request,$id) //edit manager
    {
        if($request->all())
        {

            $manager =Managers::find($id);
            if($manager->role!=="Admin")
            {
                $request->validate([

                    'manager_type' => 'required',
                    'status' => 'required',
                    //'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-7])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    //'confirm_password' => 'required|same:password',
                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:2',
                    'phone' => 'required',
                    'email' => 'required|email|unique:managers,email,'.$id,


                ]);
                $managerType = ManagerTypes::where('id',$request->manager_type)->first();
                $managerData = collect($request->all())->forget(['_token','password','confirm_password','manager_type'])->put('type_id',$request->manager_type)->put('type',$managerType->name)->toArray();
            }
            else{
                $request->validate([

                    'first_name' => 'required|min:3',
                    'last_name' => 'required|min:2',
                    'phone' => 'required',
                    'email' => 'required|email|unique:managers,email,'.$id,


                ]);
                $managerData = collect($request->all())->forget(['_token','password','confirm_password','manager_type'])->toArray();
            }

            if($request->password)
            {
                $request->validate([

                    'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-7])(?=.*?[#?!@$%^&*-_]).{6,}$/',
                    'confirm_password' => 'required|same:password'


                ]);

                $managerData['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('image')) {

                $image  = $request->file('image');
                $fileName   = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put($fileName,File::get($image));
                $managerData['image']=$fileName;

            }
            $manager =Managers::find($id);
            $manager->fill($managerData);
            if($manager->save())
            {
                \Session::flash('message', 'Successfully Update Manager ');
                \Session::flash('class', 'success');
                return redirect()->route('managersListing');
            }
            else{

                DB::rollback();
                \Session::flash('message', 'Unsuccessfully Update Manager');
                \Session::flash('class', 'danger');
                return redirect()->route('managersListing');
            }
        }
        else
        {
            $data['managersTypes']=ManagerTypes::where('name','!=','Super Manager')->get();
            $data['manager'] = $data['managers']=Managers::where('id',$id)->with('managerType')->first();
            $data['page_title']='system';
            $data['link']='Managers';
            return view('system/editManager',$data);
        }
    }

}
