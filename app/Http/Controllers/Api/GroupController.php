<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Group;
use App\GroupContact;
use App\MaxLimit;
use File;
use App\UserFavourite;
use App\KvitelContact;
use App\WorkingHoursUser;
use App\PushNotification;

class GroupController extends Controller {

    public function __construct() {

    }

    public function index(){
        $user = Auth::user();
        $groups = Group::select('groups.*')
        ->join('group_contacts','group_contacts.group_id','=','groups.id')->withCount(['group_members'])
        ->where(['group_contacts.user_id' => $user->id, 'can_see' => 1])
        ->get();
        return response()->json(['status' => 1, 'data' => $groups]);
    }

    public function create(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'all_contacts' => 'required',
            'name' => 'required'
        ]);
        $fields = array('all_contacts', 'name');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $max_limits = MaxLimit::find(1);
        if($max_limits['max_no_of_contacts'] <= count($input['all_contacts'])){
            return response()->json(['status' => 0, 'message' => "Your selected contacts for a group must be less ".$max_limits['max_no_of_contacts']]);
        }
        $notification_user_ids = [];
        $mergeArray = [];
        DB::beginTransaction();
        try{
            $groupCreate = new Group;
            $groupCreate->fill(['name' => $input['name'],'image' => $input['image'],'owner_id' => $user->id]);
            if($groupCreate->save()){
                $groupContacts[] = ['group_id' => $groupCreate->id, 'phone' => $user->country_code.$user->phone_no,'name' => $user->first_name." ".$user->last_name,'user_id' => $user->id,'avatar' => $user->avatar,'is_owner' => 1,'is_admin' => 1,'can_see' => 1, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                foreach ($input['all_contacts'] as $contact_key => $contact_value) {
                    if($contact_value['user_id'] != 0 && $contact_value['can_see'] == 1){
                        $notification_user_ids[] = $contact_value['user_id'];
                    }
                    $groupContacts[] = ['group_id' => $groupCreate->id, 'phone' => !empty($contact_value['phone_no'])?$contact_value['phone_no']:"",'name' => !empty($contact_value['name'])?$contact_value['name']:"",'user_id' => $contact_value['user_id'],'avatar' => (!empty($contact_value['avatar']))?$contact_value['avatar']:"",'is_owner' => 0,'is_admin' => $contact_value['is_admin'], 'can_see' => $contact_value['can_see'], 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                }
                GroupContact::insert($groupContacts);
            }

            $send_to = User::whereIn('id', $notification_user_ids)
            ->where('users.notification_token', '!=', "")
            ->pluck('users.notification_token')
            ->toArray();
            if(!empty($send_to)){
                $response = $this->send_notification("You added to a group",$user->first_name." ".$user->last_name ." has added you in ".$input['name'], $send_to, ['type' => 'group_added','group_id' => $groupCreate->id]);
                if (isset($response->id)) {
                    $mergeArray['onesignal_id'] = $response->id;
                    $notification_detail = $this->notification_detail($response->id);
                    if (isset($notification_detail->platform_delivery_stats->android->successful)) {
                        $mergeArray['android_received'] = $notification_detail->platform_delivery_stats->android->successful;
                    }
                    if (isset($notification_detail->platform_delivery_stats->ios->successful)) {
                        $mergeArray['iphone_received'] = $notification_detail->platform_delivery_stats->ios->successful;
                    }
                }
            }
            if(!empty($notification_user_ids)){
                $mergeArray['subtitle'] = $user->first_name." ".$user->last_name;
                $mergeArray['send_to'] = implode(',', $notification_user_ids);
                $mergeArray['title'] = "You added to a group";
                $mergeArray['text'] = $user->first_name." ".$user->last_name ." has added you in ".$input['name'];
                $mergeArray['send_from'] = $user->first_name." ".$user->last_name;
                $mergeArray['send_image'] = $user->avatar;
                $newData = new PushNotification();
                $newData->fill($mergeArray);
                $newData->save();
            }
            DB::commit();
            return response()->json(['status' => 1, 'message' => "Group Created Successfully"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }

    /* Upload Image */

    public function upload_image(Request $request) {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
        'image' => 'required',
        ]);
        $fields = array('image');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $path = public_path() . '/images/groups/';
        File::makeDirectory($path, $mode = 0777, true, true);
        $fileName = time() . '.' . $input['image']->getClientOriginalExtension();
        $input['image']->move(public_path('/images/groups/'), $fileName);
        return response()->json(['status' => 1, 'data' => $fileName]);
    }

    public function group_detail(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
        'group_id' => 'required',
        ]);
        $fields = array('group_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $group_detail = Group::with('group_members')->find($input['group_id']);
        if(!empty($group_detail->group_members)){
            if(!empty($input['current_time'])){
                $current_time = $input['current_time'];
            } else {
                $current_time = date("H:i");
            }

            if(!empty($input['current_day'])){
                $current_day = $input['current_day'];
            } else {
                $current_day = date('l');
            }
            foreach ($group_detail->group_members as $member_key => $member_value) {
                $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $member_value->id])->first();
                if ($alreadyFavourite) {
                    $group_detail->group_members[$member_key]->is_favourite = 1;
                } else {
                    $group_detail->group_members[$member_key]->is_favourite = 0;
                }
                $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $member_value->id])->first();
                if ($alreadyContact) {
                    $group_detail->group_members[$member_key]->is_friend = 1;
                } else {
                    $group_detail->group_members[$member_key]->is_friend = 0;
                }
                $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $member_value->id])
                ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                if($workingHours){
                    $group_detail->group_members[$member_key]->opening_status = "Open";
                } else {
                    $group_detail->group_members[$member_key]->opening_status = "Closed";
                }
            }
        }
        return response()->json(['status' => 1, 'data' => $group_detail]);
    }

    /* Remove itself from group */

    public function remove_me_from_group(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'group_id' => 'required'
        ]);
        $fields = array('group_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        DB::beginTransaction();
        try{
            $myStatusInGroup = GroupContact::where(['group_id' => $input['group_id'],'user_id' => $user->id])->first();
            if($myStatusInGroup){
                $myStatusInGroup->delete();
                $group_detail = Group::withCount(['group_members'])->find($input['group_id']);
                if($group_detail->group_members_count > 0){
                    $groupAdminStatus = GroupContact::where(['group_id' => $input['group_id'],'is_admin' => 1])->count();
                    if(!$groupAdminStatus){
                        $updateGroup = GroupContact::where(['group_id' => $input['group_id'],'can_see' => 1])->where('user_id','!=',0)->first();
                        if($updateGroup){
                            $updateGroup->fill(['is_admin' => 1]);
                            $updateGroup->save();
                        }
                    }
                } else {
                    $group_detail->delete();
                }
            }
            DB::commit();
            return response()->json(['status' => 1, 'message' => "You successfully remove from group"]);
        }  catch (\PDOException $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /* Delete Group */

    public function delete(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'group_id' => 'required'
        ]);
        $fields = array('group_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        DB::beginTransaction();
        try {
            $groupDetail = Group::find($input['group_id']);
            if($groupDetail){
                if($groupDetail->owner_id == $user->id){
                    GroupContact::where(['group_id' => $input['group_id']])->delete();
                    $groupDetail->delete();
                    DB::commit();
                } else {
                    return response()->json(['status' => 0, 'message' => "You are not authorized to delete this group"]);
                }
            }
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

    /* Delete another user from the group */

    public function delete_other_user(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'contact_id' => 'required'
        ]);
        $fields = array('group_id','contact_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $adminDetail = GroupContact::where(['group_id' => $input['group_id'],'user_id' => $user->id])->first();
        if($adminDetail){
            if($adminDetail->is_admin == 1){
                $otherDetail = GroupContact::find($input['contact_id']);
                if($otherDetail->is_owner == 1){
                    return response()->json(['status' => 0, 'message' => "You can't remove group owner from the group."]);
                }
                $otherDetail->delete();
                return response()->json(['status' => 1, 'message' => "Contact deleted successfully"]);
            } else {
                return response()->json(['status' => 0, 'message' => "You are not authorized to remove contact"]);
            }
        } else {
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }

    /* Delete another user from the group */

    public function change_can_see_permission(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'contact_id' => 'required',
            'can_see' => 'required'
        ]);
        $fields = array('group_id','contact_id','can_see');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $adminDetail = GroupContact::where(['group_id' => $input['group_id'],'user_id' => $user->id])->first();
        if($adminDetail){
            if($adminDetail->is_admin == 1){
                $otherDetail = GroupContact::find($input['contact_id']);
                if($otherDetail->is_owner == 1){
                    return response()->json(['status' => 0, 'message' => "You can't change permission of group owner."]);
                }
                $otherDetail->fill(['can_see' => $input['can_see']]);
                $otherDetail->save();
                return response()->json(['status' => 1, 'message' => "Permission changed successfully"]);
            } else {
                return response()->json(['status' => 0, 'message' => "You are not authorized to change permission"]);
            }
        } else {
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }

    public function add_to_multiple_groups(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'groups_id' => 'required',
            'phone_no' => 'required',
            'name' => 'required' ,
            'user_id' => 'required'
        ]);
        $fields = array('groups_id','phone_no','name','user_id');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $groupContacts = array();
        foreach (explode(',',$input['groups_id']) as $group_key => $group) {
            $groupContacts[] = ['group_id' => $group, 'phone' => !empty($input['phone_no'])?$input['phone_no']:"",'name' => !empty($input['name'])?$input['name']:"",'user_id' => $input['user_id'],'avatar' => (!empty($input['avatar']))?$input['avatar']:"",'is_owner' => 0,'is_admin' => 0, 'can_see' => 0, 'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
        }
        GroupContact::insert($groupContacts);
        return response()->json(['status' => 1, 'message' => "Contact added successfully to your selected group"]);
    }

    public function list_of_unjoined_groups(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        $fields = array('phone');
        $error_message = "";
        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (isset($validator->errors()->getMessages()[$field][0]) && !empty($validator->errors()->getMessages()[$field][0]) && empty($error_message)) {
                    $error_message = $validator->errors()->getMessages()[$field][0];
                    return response()->json(['status' => 0, 'message' => $error_message]);
                }
            }
        }
        $input = $request->all();
        $alreadyInGroup = GroupContact::where(['phone' => $input['phone']])->pluck('group_id')->toArray();
        $groups = Group::select('groups.*')
        ->join('group_contacts','group_contacts.group_id','=','groups.id')->withCount(['group_members'])
        ->where(['group_contacts.user_id' => $user->id, 'is_admin' => 1])
        ->whereNotIn('groups.id',$alreadyInGroup)
        ->get();
        return response()->json(['status' => 1, 'data' => $groups]);
    }

    public function send_notification($heading, $content, $include_player_ids, $data) {
        $contents = array(
            "en" => $content
        );
        $headings = array(
            "en" => $heading
        );
        $fields = array(
            'app_id' => ONESIGNALAPPID,
            'include_player_ids' => $include_player_ids,
            'data' => $data,
            'contents' => $contents,
            'headings' => $headings
        );

        $fields = json_encode($fields);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                'Authorization: Basic ' . ONESIGNALAUTHORIZATIONKEY));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response);
        } catch (Exception $e) {

        }
    }

    public function notification_detail($notification_id) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications/" . $notification_id . "?app_id=" . ONESIGNALAPPID);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                'Authorization: Basic ' . ONESIGNALAUTHORIZATIONKEY));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response);
        } catch (Exception $e) {

        }
    }

}
