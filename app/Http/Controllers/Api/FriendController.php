<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\KvitelContact;
use App\UserFavourite;
use App\WorkingHoursUser;

class FriendController extends Controller {

    public function __construct() {

    }

    /* Search via kvitel ID */

    public function searchViaKvitelId(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
                    'extension' => 'required',
                    'kvitel_id' => 'required',
        ]);
        $fields = array('extension', 'kvitel_id');
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
        $userDetails = User::select("id", "kvitel_extension", "kvitel_id", "first_name", "last_name", "avatar", "country_code", "phone_no")
                ->where(['kvitel_extension' => $input['extension'], 'is_register' => 1])
                ->where('kvitel_id', 'like', $input['kvitel_id'] . '%')
                ->where('id', '!=', $user->id)
                ->get();
        if ($userDetails) {
            foreach ($userDetails as $detail_key => $userDetail) {
                $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $userDetail->id])->first();
                if ($alreadyContact) {
                    $userDetails[$detail_key]->is_friend = 1;
                } else {
                    $userDetails[$detail_key]->is_friend = 0;
                }
            }
        }
        return response()->json(['status' => 1, 'data' => $userDetails]);
    }

    /* Search via first name, last name, phone number, kvitel ID number */

    public function free_search(Request $request) {
        $user = Auth::user();
        $input = $request->all();
        if (!empty($input['keyword'])) {
            $userDetails = User::select("id", "kvitel_extension", "kvitel_id", "first_name", "last_name", "avatar", "country_code", "phone_no")
                    ->where(['is_register' => 1])
                    ->where('id', '!=', $user->id)
                    ->where(function($query)use($input) {
                        $query->where('kvitel_id', 'like', '%' . $input['keyword'] . '%');
                        $query->orWhereRaw('LOWER(`first_name`) LIKE ? ', ['%' . trim(strtolower($input['keyword'])) . '%']);
                        $query->orWhereRaw('LOWER(`last_name`) LIKE ? ', ['%' . trim(strtolower($input['keyword'])) . '%']);
                        $query->orWhereRaw('LOWER(`phone_no`) LIKE ? ', ['%' . trim(strtolower($input['keyword'])) . '%']);
                    })
                    ->get();
            if ($userDetails) {
                foreach ($userDetails as $detail_key => $userDetail) {
                    $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $userDetail->id])->first();
                    if ($alreadyContact) {
                        $userDetails[$detail_key]->is_friend = 1;
                    } else {
                        $userDetails[$detail_key]->is_friend = 0;
                    }
                }
            }
            return response()->json(['status' => 1, 'data' => $userDetails]);
        } else {
            return response()->json(['status' => 1, 'data' => []]);
        }
    }

    public function searchQrCode(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
                    'kvitel_id' => 'required',
        ]);
        $fields = array('kvitel_id');
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
        $kvitel_id = explode('-', $input['kvitel_id']);
        $contact = User::where(['kvitel_extension' => $kvitel_id[0], 'kvitel_id' => $kvitel_id[1]])->first();
        if ($contact) {
            if($user->id == $contact->id){
                return response()->json(['status' => 0, 'message' => "You can't add your own contact to your contact list"]);
            } else {
                $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $contact->id])->first();
                if (!$alreadyContact) {
                    KvitelContact::insert(['user_id' => $user->id, 'contact_id' => $contact->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }
                return response()->json(['status' => 1, 'message' => "Contact successfully added to your list"]);
            }
        } else {
            return response()->json(['status' => 0, 'message' => "Invalid Search"]);
        }
    }

    public function addContact(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
                    'contact_id' => 'required'
        ]);
        $fields = array('contact_id');
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
        $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $input['contact_id']])->first();
        if(!isset($input['is_friend']) || $input['is_friend'] == 1){
            if (!$alreadyContact) {
                KvitelContact::insert(['user_id' => $user->id, 'contact_id' => $input['contact_id'], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            return response()->json(['status' => 1, 'message' => "Contact successfully added to your list"]);
        } elseif(isset($input['is_friend']) && $input['is_friend'] == 0){
            if($alreadyContact){
                $alreadyContact->delete();
            }
            return response()->json(['status' => 1, 'message' => "Contact removed successfully from your list"]);
        }
    }

   /* List of all my kvitel contacts */

    public function allContacts(Request $request) {
        $user = Auth::user();
        $input = $request->all();
        $contacts = User::where(['id' => $user->id])->first()->contact_detail()->select("users.id", "users.kvitel_extension", "kvitel_id", "first_name", "last_name", "avatar", "country_code", "phone_no", "user_type")->get();
        if ($contacts) {
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

            foreach ($contacts as $contact_key => $contact_value) {
                $contacts[$contact_key]->is_friend = 1;

                $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $contact_value->id])->first();
                if ($alreadyFavourite) {
                    $contacts[$contact_key]->is_favourite = 1;
                } else {
                    $contacts[$contact_key]->is_favourite = 0;
                }


                $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $user->id])
                ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                if($workingHours){
                    $contacts[$contact_key]->opening_status = "Open";
                } else {
                    $contacts[$contact_key]->opening_status = "Closed";
                }
            }
        }
        return response()->json(['status' => 1, 'data' => $contacts]);
    }

    /* Overall contacts including groups and my kvitel contacts */

    public function overAllContacts(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
                    'all_contacts' => 'required'
        ]);
        $fields = array('all_contacts');
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
        $allContacts = [];
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
        foreach ($input['all_contacts'] as $contact_key => $contact_value) {
            $contact = ltrim(str_replace('-', '', $contact_value['phone_no']));
            $contact = str_replace('(', '', $contact);
            $contact = str_replace(')', '', $contact);
            $contact = str_replace(' ', '', $contact);
            $checkContact = User::whereRaw("'" . $contact . "' LIKE CONCAT('%', phone_no, '%')")
                            ->where(['is_register' => 1])->first();
            if ($checkContact) {
                $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $checkContact->id])->first();
                if (!$alreadyContact) {
                    KvitelContact::insert(['user_id' => $user->id, 'contact_id' => $checkContact->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                }
                $contact_value['id'] = $checkContact->id;
                $contact_value['is_friend'] = 1;
                $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $checkContact->id])->first();
                if ($alreadyFavourite) {
                    $contact_value['is_favourite'] = 1;
                } else {
                    $contact_value['is_favourite'] = 0;
                }
                $contact_value['avatar'] = $checkContact->avatar;
                $contact_value['user_type'] = $checkContact->user_type;
                $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $user->id])
                ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                if($workingHours){
                    $contact_value['opening_status'] = "Open";
                } else {
                    $contact_value['opening_status'] = "Closed";
                }
                $allContacts[] = $contact_value;
            }
        }
        return response()->json(['status' => 1, 'data' => $allContacts]);
    }

    /* Overall contacts including groups and my kvitel contacts */

    public function overAllMultipleContacts(Request $request) {
        $user = Auth::user();
        $input = $request->all();
        $allContacts = [];
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
        $all_kvitel_friends = [];
        foreach ($input['all_contacts'] as $contact_key => $contact_value) {
            $find_kvitel_contact = 0;
            foreach($contact_value['phone_no'] as $phone_key => $phone_value){
                if($find_kvitel_contact == 0){
                    $contact = ltrim(str_replace('-', '', $phone_value));
                    $contact = str_replace('(', '', $contact);
                    $contact = str_replace(')', '', $contact);
                    $contact = str_replace(' ', '', $contact);
                    $checkContact = User::whereRaw("'" . $contact . "' LIKE CONCAT('%', phone_no, '%')")
                    ->where(['is_register' => 1])->first();
                    if ($checkContact) {
                        $find_kvitel_contact++;
                        $alreadyContact = KvitelContact::where(['user_id' => $user->id, 'contact_id' => $checkContact->id])->first();
                        if (!$alreadyContact) {
                            $kvitelContact = new KvitelContact;
                            $kvitelContact->fill(['user_id' => $user->id, 'contact_id' => $checkContact->id]);
                            $kvitelContact->save();
                            $all_kvitel_friends[] = $kvitelContact->id;
                        } else {
                            $all_kvitel_friends[] = $alreadyContact->id;
                        }
                        $contact_value['name'] = $checkContact->first_name." ".$checkContact->last_name;
                        $contact_value['kvitel_index'] = $phone_key;
                        $contact_value['id'] = $checkContact->id;
                        $contact_value['is_friend'] = 1;
                        $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $checkContact->id])->first();
                        if ($alreadyFavourite) {
                            $contact_value['is_favourite'] = 1;
                        } else {
                            $contact_value['is_favourite'] = 0;
                        }
                        $contact_value['avatar'] = $checkContact->avatar;
                        $contact_value['user_type'] = $checkContact->user_type;
                        $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $user->id])
                        ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                        if($workingHours){
                            $contact_value['opening_status'] = "Open";
                        } else {
                            $contact_value['opening_status'] = "Closed";
                        }
                        $allContacts[] = $contact_value;
                    }
                }
            }
        }
        $contacts = User::select(DB::raw("users.id,CONCAT(first_name,' ',last_name) AS name, avatar, CONCAT(country_code,phone_no) AS phone_no, user_type, 0 as kvitel_index"))
        ->join("kvitel_contacts","kvitel_contacts.contact_id","=","users.id")
        ->where(["kvitel_contacts.user_id" => $user->id])
        ->whereNotIn("kvitel_contacts.id",$all_kvitel_friends)
        ->get();
        if ($contacts) {
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

            foreach ($contacts as $contact_key => $contact_value) {
                $contact_value['phone_no'] = explode(',',$contact_value->phone_no);
                $contact_value->is_friend = 1;

                $alreadyFavourite = UserFavourite::where(['user_id' => $user->id, 'favourite_id' => $contact_value->id])->first();
                if ($alreadyFavourite) {
                    $contact_value->is_favourite = 1;
                } else {
                    $contact_value->is_favourite = 0;
                }

                $workingHours = WorkingHoursUser::where(['day' => $current_day,'user_id' => $user->id])
                ->whereRaw("from_time <= '" . $current_time . "' && until_time >= '" . $current_time . "'")->first();
                if($workingHours){
                    $contact_value->opening_status = "Open";
                } else {
                    $contact_value->opening_status = "Closed";
                }
                $allContacts[] = $contact_value;
            }
        }

        return response()->json(['status' => 1, 'data' => $allContacts]);
    }

}
