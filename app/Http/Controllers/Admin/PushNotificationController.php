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
use App\Inbox;
use App\PushNotification;

class PushNotificationController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    /* Listing of push notifications by admin panel */

    public function index() {
        $data['page_title'] = 'Push Notification';
        $data['link'] = 'Push_Notification';
        $data['notification_data'] = PushNotification::where(['subtitle' => 'Paradox'])->get();

        return view('push_notification.index', $data);
    }

    /* Add product */

    public function add(Request $request) {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new PushNotification();
            $mergeArray = ['subtitle' => 'Paradox'];
            if (in_array('subscribed_users', $input['whom_send'])) {
                $mergeArray['send_to'] = $send_to = "subscribed_users";
            } else {
                $mergeArray['send_to'] = implode(',', $input['whom_send']);
                $send_to = User::whereIn('id', $input['whom_send'])
                        ->where('users.notification_token', '!=', "")
                        ->pluck('users.notification_token')
                        ->toArray();
            }

            $response = $this->send_notification($input['title'], $input['text'], $send_to, ['type' => 'web_notification']);
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
            $newDataField = collect($input)->merge($mergeArray)->forget(['_token', '_method', 'whom_send'])->toArray();
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Notification send successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('pushNotificationListing');
            }
        }
        $data['page_title'] = 'Push Notification';
        $data['link'] = 'Push_Notification';
        $data['users'] = User::where(['is_verified' => 1])->get();
        return view('push_notification.add', $data);
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
            'data' => $data,
            'contents' => $contents,
            'headings' => $headings
        );
        if ($include_player_ids == 'subscribed_users') {
            $fields['included_segments'] = ['All'];
        } else {
            $fields['include_player_ids'] = $include_player_ids;
        }


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

    public function resend(Request $request,$notification_id){
        $previous_notification = PushNotification::find($notification_id);
        if($previous_notification){
            $newData = new PushNotification();
            $newDataField = ['subtitle' => 'Paradox'];
            $newDataField['title'] = $previous_notification->title;
            $newDataField['text'] = $previous_notification->text;
            $newDataField['send_to'] = $send_to = "subscribed_users";

            $response = $this->send_notification($previous_notification->title, $previous_notification->text, $send_to, ['type' => 'web_notification']);
            if (isset($response->id)) {
                $newDataField['onesignal_id'] = $response->id;
                $notification_detail = $this->notification_detail($response->id);
                if (isset($notification_detail->platform_delivery_stats->android->successful)) {
                    $newDataField['android_received'] = $notification_detail->platform_delivery_stats->android->successful;
                }
                if (isset($notification_detail->platform_delivery_stats->ios->successful)) {
                    $newDataField['iphone_received'] = $notification_detail->platform_delivery_stats->ios->successful;
                }
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Notification resend successfully!');
                \Session::flash('class', 'success');
                return response()->json(['status' => 1, 'message' => "Notification resend successfully"]);
            }
        } else {
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }
}
