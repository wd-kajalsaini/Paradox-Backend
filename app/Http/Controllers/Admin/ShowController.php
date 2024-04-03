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
use App\Show;
use App\Team;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\SubscribedShow;
use App\ShowQuestion;
use App\SectionShowLink;
use App\ShowBanner;
use Exception;

class ShowController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['validate_team_players','make_show_live','subscribed_users','subscriber_notification','questions','question_add','question_edit','delete_question']]);
    }

    public function index(){
        $data['page_title'] = 'Show';
        $data['link'] = 'Shows';
        $data['shows'] = Show::withCount(['subscribed_users','show_questions'])->get();
        return view('shows.index', $data);
    }

    public function add(Request $request){

        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try{



            $input = $request->all();
            $newData = new Show();
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }

            $team1Data = Team::with('players')->find($input['team_1_id'])->toArray();
            $team2Data = Team::with('players')->find($input['team_2_id'])->toArray();
            $newDataField['team_1_data'] = json_encode($team1Data);
            $newDataField['team_2_data'] = json_encode($team2Data);
            if (!empty($request->file('banner'))) {
                $banner_icon = $request->file('banner');

                $banner_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $banner_icon->getClientOriginalExtension();
                $banner_icondb = "https://paradox1.s3.ap-south-1.amazonaws.com/users.csv/banner_images/" . $banner_iconFileName;
                $s3 = \Storage::disk('s3');

                $filePath = '/banner_images/' . $banner_iconFileName;

                $banner_icon_image = $s3->put($filePath, file_get_contents($banner_icon), 'public');

                $newDataField['banner'] = $banner_icondb;

            }
            $newData->fill($newDataField);

            $newData->save();
            DB::commit();
            \Session::flash('message', 'Show added successfully!');
            \Session::flash('class', 'success');
            // return redirect()->route('showsListing');
            return response()->json(['status' => 1, 'message' => "Show added successfully!"]);
        } catch(Exception $e){
            dd($e->getMessage());
            DB::rollback();

        }

        }
        $data['page_title'] = 'Add Show';
        $data['link'] = 'Shows';
        $data['teams'] = Team::select('id','title','logo')->get();
        return view('shows.add', $data);
    }

    /* Edit show */

    public function edit($id, Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = Show::find($id);
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            $team1Data = Team::with('players')->find($input['team_1_id'])->toArray();
            $team2Data = Team::with('players')->find($input['team_2_id'])->toArray();
            $newDataField['team_1_data'] = json_encode($team1Data);
            $newDataField['team_2_data'] = json_encode($team2Data);
            if (!empty($request->file('banner'))) {
                $banner_icon = $request->file('banner');
                $banner_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $banner_icon->getClientOriginalExtension();
                $banner_icondb = "https://paradox1.s3.ap-south-1.amazonaws.com/banner_images/" . $banner_iconFileName;
                $s3 = \Storage::disk('s3');
                $filePath = '/banner_images/' . $banner_iconFileName;
                $banner_icon_image = $s3->put($filePath, file_get_contents($banner_icon), 'public');
                $newDataField['banner'] = $banner_icondb;
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Show updated successfully!');
                \Session::flash('class', 'success');
                // return redirect()->route('showsListing');
                return response()->json(['status' => 1, 'message' => "Show updated successfully!!"]);
            }
        }
        $data['page_title'] = 'Edit Show';
        $data['link'] = 'Shows';
        $data['teams'] = Team::select('id','title','logo')->get();
        $data['show'] = Show::find($id);

        return view('shows.edit', $data);
    }

    /* Delete Show */

    public function delete($id) {
        DB::beginTransaction();
        try{
            Show::destroy($id);
            SectionShowLink::where(['show_id' => $id])->delete();
            ShowBanner::where(['show_id' => $id])->delete();
            DB::commit();
            \Session::flash('message', 'Show Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Show Deleted Successfully"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }

    /* validate team players */

    public function validate_team_players(Request $request){
        $input = $request->all();
        $team_1 = Team::with('players')->find($input['dropdown_1_value'])->toArray();
        $team_1_players = array_column($team_1['players'],'id');
        $team_2 = Team::with('players')->find($input['dropdown_2_value'])->toArray();
        $team_2_players = array_column($team_2['players'],'id');
        $common = array_intersect($team_1_players,$team_2_players);
        if(!empty($common)){
            return response()->json(['status' => 0, 'message' => "Both team must contain different player from another team"]);
        }
    }

    public function subscribed_users($id){
        $data['page_title'] = 'Subscribed Users';
        $data['link'] = 'Shows';
        $data['subscribers'] = Show::with('subscribers')->where(['shows.id' => $id])->first();
        $data['id'] = $id;
        return view('shows.subscribers', $data);
    }

    public function subscriber_notification($id, Request $request){
        $input = $request->all();
        $send_to = User::join('subscribed_shows','users.id','=','subscribed_shows.user_id')
        ->where('users.notification_token', '!=', "")
        ->pluck('users.notification_token')
        ->toArray();
        if(!empty($send_to)){
            $response = $this->send_notification($input['title'],$input['description'],$send_to,['type' => 'show_subscriber','show_id' => $id]);
        }
        return response()->json(['status' => 1, 'message' => "Notification successfully send to subscribers"]);
    }

    public function send_notification($heading = "", $content = "", $include_player_ids, $data) {
        $contents = array(
            "en" => $content
        );
        $headings = array(
            "en" => $heading
        );
        $fields = array(
            'app_id' => ONESIGNALAPPID,
            'data' => $data,
            'contents' => $contents
        );
        if(!empty($heading)){
            $fields['headings'] = $headings;
        }
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

    public function questions($id){
        $data['page_title'] = 'Show Questions';
        $data['link'] = 'Shows';
        $data['show'] = Show::find($id);
        $data['show_questions'] = $data['show']->show_questions()->get();
        $data['id'] = $id;
        return view('shows.questions', $data);
    }

    public function question_add($id, Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new ShowQuestion();

            $newDataField = ['title' => $input['title'], 'duration' => $input['duration'], 'show_id' => $id];
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                DB::commit();
                \Session::flash('message', 'Question added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('showQuestions',$id);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Show Questions';
        $data['link'] = 'Shows';
        $data['show'] = Show::find($id);
        $data['id'] = $id;
        return view('shows.question_add', $data);
    }

    public function question_edit($show_id, $id,Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = ShowQuestion::find($show_id);

            $newDataField = ['title' => $input['title'], 'duration' => $input['duration']];
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                DB::commit();
                \Session::flash('message', 'Question updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('showQuestions',$show_id);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Show Questions';
        $data['link'] = 'Shows';
        $data['show'] = Show::find($show_id);
        $data['show_question'] = ShowQuestion::find($id);
        $data['id'] = $id;
        return view('shows.question_edit', $data);
    }

    /* Delete Section */

    public function delete_question($id) {
        if (ShowQuestion::destroy($id)) {
            \Session::flash('message', 'Question Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Question Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

    public function make_show_live($id) {
        $user = Auth::user();
        if(empty($user->quickblox_login)){
            $adminDetail = Managers::find(1);
            // $admin_session = $this->create_session(['login' => $adminDetail->quickblox_login,'password' => ($adminDetail->quickblox_password)]);
            // dd($admin_session);

            $password = $this->random_strings(8);

            // $password = 'Admin@123';
            $data = [
                'email' => $user->email,
                'login' => $user->email,
                'password' => $password,
                'full_name' => $user->first_name . ' ' . $user->last_name
            ];

            $createUser = $this->create_user($data);
            $user->fill(['quickblox_login' => $user->email,'quickblox_password' => base64_encode($password)]);
            $user->save();
          //  $session = $this->create_session(['login' => $user->email,'password' => $password]);
        } else {
           // $session = $this->create_session(['login' => $user->quickblox_login,'password' => base64_decode($user->quickblox_password)]);
        }

        $show = Show::find($id);
        $roomData = [
            'type' =>1,
            'name' => $show->title
        ];
       $roomdetail = $this->create_room($roomData);
        $show->fill(['live_at' => Date("Y-m-d H:i:s"),'chat_room_id' => $roomdetail->_id]);
        $show->save();
        return response()->json(['status' => 1, 'message' => "Show Lived Now"]);
    }

    public function create_session($data){
        $nonce = rand();
        $timestamp = time();
        $signature_string = "application_id=" . QB_APPLICATION_ID . "&auth_key=" . QB_AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamp . "&user[login]=" . $data['login'] . "&user[password]=" . $data['password'];
        // echo "<pre>";
        // print_r(hash_hmac('sha1', "application_id=102994&auth_key=ak_nAHpcXum6AEpwMw&nonce=723027416&timestamp=1712133208&user[login]=developer@worksdelight.org&user[password]=paradox@123", QB_AUTH_SECRET));die;
        $signature = hash_hmac('sha1', $signature_string, QB_AUTH_SECRET);

        $post_body = http_build_query(array(
            'application_id' => QB_APPLICATION_ID,
            'auth_key' => QB_AUTH_KEY,
            'timestamp' => $timestamp,
            'nonce' => $nonce,
            'signature' => $signature,
            'user[login]' => $data['login'],
            'user[password]' => $data['password']
        ));

        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION);
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Receive server response
        // Execute request and read response
        $response = curl_exec($curl);
        // Check errors
        if ($response === false) {
            $error_message = curl_error($curl);
            $error_code = curl_errno($curl);
            //  // Output the error message and error code
            // echo "cURL error: $error_message (Error code: $error_code)";die;
            // // Close connection
            // curl_close($curl);
            return response()->json(['status' => 0, 'message' =>$error_message.' - Error Code'.$error_code]);
            // echo $session_response->session->token;
        } else {
            // Close connection
            dd(json_decode($response));
            curl_close($curl);
            return response()->json(['status' => 1, 'message' => "Success",'data' => json_decode($response)]);
        }
    }

    // public function create_user($token, $data){
    //     $data = ['user'=>$data];

    //     // Build post body
    //     $post_body = json_encode($data);

    //     // Configure cURL
    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'users.json'); // Full path is - https://api.quickblox.com/session.json
    //     curl_setopt($curl, CURLOPT_POST, true); // Use POST
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json',
    //         'QuickBlox-REST-API-Version: 0.1.0',
    //         'QB-Token: '.$token
    //     ));
    //     // Execute request and read response
    //     $response = curl_exec($curl);
    //     $responseJSON = json_decode($response);
    //     // Check errors
    //     if ($responseJSON) {
    //         return $responseJSON;
    //     } else {
    //         $error = curl_error($curl). '(' .curl_errno($curl). ')';
    //         return response()->json(['status' => 0, 'message' => $error]);
    //     }
    //     // Close connection
    //     curl_close($curl);
    // }
    public function create_user($data){


        $curl = curl_init();
        $json_data = json_encode([
            "user" => $data
        ]);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.quickblox.com/users.json',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $json_data, // Set the JSON-encoded data

          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: ApiKey m3U3x_1bSSIBUAyTxka2DAwQy8GZhCoUGp9ZQer8_Iw'
          ),
        ));

        $response = curl_exec($curl);
        $responseJSON = json_decode($response);
        // Check errors
        if ($responseJSON) {
            return $responseJSON;
        } else {
            $error = curl_error($curl). '(' .curl_errno($curl). ')';
            return response()->json(['status' => 0, 'message' => $error]);
        }
        curl_close($curl);
        // echo $response;

    }

    function random_strings($length_of_string){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

   /* function create_room($token, $data)
    {

        // Build post body
        $post_body = json_encode($data);

        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'chat/Dialog.json');
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'QuickBlox-REST-API-Version: 0.1.0',
            'QB-Token: '.$token
        ));
        // Execute request and read response
        $response = curl_exec($curl);
        $responseJSON = json_decode($response);
        // Check errors
        if ($responseJSON) {
            return $responseJSON;
        } else {
            $error = curl_error($curl). '(' .curl_errno($curl). ')';
            return response()->json(

            );
        }
        // Close connection
        curl_close($curl);
    }*/
    function create_room($data)
    {
        // Build post body
        $post_body = json_encode($data);

        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'chat/Dialog.json');
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'QuickBlox-REST-API-Version: 0.1.0',
            'Authorization: ApiKey m3U3x_1bSSIBUAyTxka2DAwQy8GZhCoUGp9ZQer8_Iw'
         ));
        // Execute request and read responses
        $response = curl_exec($curl);
        $responseJSON = json_decode($response);
        // Check errors
        if ($responseJSON) {
            return $responseJSON;
        } else {
            $error = curl_error($curl). '(' .curl_errno($curl). ')';
            return response()->json(['status' => 0, 'message' => $error]);
        }
        // Close connection
        curl_close($curl);
    }

}
