<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Cookie;
use Auth;
use \Firebase\JWT\JWT;
use Exception;

require_once resource_path('php-jwt-master/src/JWT.php');

class Managers extends Authenticatable
{
    use Notifiable;

    public $secret_token_key = "ksdhkERvdldf3433$##@dl3k4344fEek3j43$#thFfsk345f44334#Rxxx3fdkfkdjjo3f93djwi0icdiieckek";

    protected $table = 'managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded =[];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
    public function managerType()
    {
        return $this->belongsTo(ManagerTypes::class,'type_id','id');
    }
    public function getLocaleAttribute()
    {
        return Cookie::get('locale'.Auth::user()->id);
    }

    public function get_api_validation_token($user_id) {
        $key = $this->secret_token_key;
        $token = array(
            "iat" => time(),
            "exp" => strtotime("+30 days"),
            "user_id" => $user_id
        );

        return JWT::encode($token, $key);
    }

    function validate_api_token() {
        $jwt = "";
        // dd($_SERVER);
        if (isset($_SERVER['HTTP_AUTHORIZATION']) && !empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
            $jwt = $token[1];
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Must send auth token'));
            die;
        }

        $key = $this->secret_token_key;
        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));
            if (isset($decoded->user_id)) {
                return $decoded->user_id;
            }
        } catch (Exception $e) {
            // dd($e);
            echo json_encode(array('status' => 0, 'message' => $e->getMessage()));
            die;
        }
    }

    public function create_qb_session($data){
        $nonce = rand();
        $timestamp = time();
        $signature_string = "application_id=" . QB_APPLICATION_ID . "&auth_key=" . QB_AUTH_KEY . "&nonce=" . $nonce . "&timestamp=" . $timestamp . "&user[login]=" . $data['login'] . "&user[password]=" . $data['password'];

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
        // Close connection
        curl_close($curl);
        // Check errors
        if ($response) {
            return json_decode($response);
            echo $session_response->session->token;
        } else {
            return response()->json(['status' => 0, 'message' => "Something went wrong"]);
        }
    }

    public function create_qb_user($token, $data){
        $data = ['user'=>$data];

        // Build post body
        $post_body = json_encode($data);

        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'users.json'); // Full path is - https://api.quickblox.com/session.json
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
            return response()->json(['status' => 0, 'message' => $error]);
        }
        // Close connection
        curl_close($curl);
    }

    public function update_qb_user($token, $user_id, $data){
        $data = ['user'=>$data];

        // Build post body
        $post_body = json_encode($data);

        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'users/'.$user_id.'.json'); // Full path is - https://api.quickblox.com/session.json
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
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
            return response()->json(['status' => 0, 'message' => $error]);
        }
        // Close connection
        curl_close($curl);
    }

    function random_strings($length_of_string){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public function retreive_api_user_by_login($token,$email){
        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'users/by_login.json?login='.$email); // Full path is - https://api.quickblox.com/session.json
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
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
            return response()->json(['status' => 0, 'message' => $error]);
        }
        // Close connection
        curl_close($curl);
    }

    public function delete_qb_user($token,$user_id){
        // Configure cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . 'users/'.$user_id.'.json'); // Full path is - https://api.quickblox.com/session.json
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
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
            return response()->json(['status' => 0, 'message' => $error]);
        }
        // Close connection
        curl_close($curl);
    }

}
