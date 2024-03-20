<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use DB;
use App\KvitelIdRestriction;
use Auth;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    public $issue = 0;
    public $random_kvitel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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

    public function getFullNameAttribute() {
        return $this->first_name . " " . $this->last_name;
    }

    /* Generate random kvitel Id */

    public function generate_kvitel($extension) {
        $this->generating_kvitel();

        $checkExist = User::where(['kvitel_extension' => $extension, 'kvitel_id' => $this->random_kvitel])->first();
        if (empty($checkExist)) {
            return $this->random_kvitel;
        }
        $this->generate_kvitel($extension);
    }

    /* Check Restrictions for kvitel Id */

    public function generating_kvitel() {
        $this->issue = 0;
        $restrictions = KvitelIdRestriction::first();
        $this->random_kvitel = rand($restrictions->number_range_start, $restrictions->number_range_end);

        if (!empty($restrictions->start_with_zero)) {
            if (!preg_match("/^((?!(0))[0-9]*)$/", $this->random_kvitel)) {
                $this->issue++;
            }
        }

//        if (!empty($restrictions->repeat_number_four_times_in_succession)) {
//            if (preg_match("/([0-9])\1{" . (($restrictions->repeat_number_four_times_in_succession_input) - 1) . ",}/", $this->random_kvitel)) {
//                $this->issue++;
//            }
//        }

        if (!empty($restrictions->five_digit_sequence_between)) {
            $five_digit_sequence_between = $this->ascending_descending_array($restrictions->five_digit_sequence_between_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($this->random_kvitel, $sequence) !== false) {
//                    if (strpos($this->random_kvitel, $sequence) != 0 && (strpos($this->random_kvitel, $sequence) + strlen($sequence) != strlen($this->random_kvitel))) {
                    $this->issue++;
//                    }
                }
            }
        }

        if (!empty($restrictions->starting_with_five_digit_or_more_ascending)) {
            $five_digit_sequence_between = $this->ascending_array($restrictions->starting_with_five_digit_or_more_ascending_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($this->random_kvitel, $sequence) !== false && strpos($this->random_kvitel, $sequence) == 0) {
                    $this->issue++;
                }
            }
        }

        if (!empty($restrictions->starting_with_five_digit_or_more_descending)) {
            $five_digit_sequence_between = $this->descending_array($restrictions->starting_with_five_digit_or_more_descending_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($this->random_kvitel, $sequence) !== false && strpos($this->random_kvitel, $sequence) == 0) {
                    $this->issue++;
                }
            }
        }

        if (!empty($restrictions->four_different_digits)) {
            $sequence_between = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $four_different_digits_count = 0;
            foreach ($sequence_between as $sequence) {
                if (strpos($this->random_kvitel, $sequence) !== false) {
                    $four_different_digits_count++;
                }
            }
            if ($four_different_digits_count < $restrictions->four_different_digits_input) {
                $this->issue++;
            }
        }

        if (!empty($restrictions->same_number_repeated_four_times_or_more)) {
            $sequence_between = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            foreach ($sequence_between as $sequence) {
                if (substr_count($this->random_kvitel, $sequence) >= $restrictions->same_number_repeated_four_times_or_more_input) {
                    $this->issue++;
                }
            }
        }

        if ($this->issue == 0) {
            return true;
        }
        $this->generating_kvitel();
    }

    /* Validate Kvitel Id before purchase */

    public function validate_kvitel($extension, $kvitel_id) {
        $restrictions = KvitelIdRestriction::first();
        if (!empty($restrictions->start_with_zero)) {
            if (!preg_match("/^((?!(0))[0-9]*)$/", $kvitel_id)) {
                return response()->json(['status' => 0, 'message' => "The number cannot start with 0."]);
            }
        }

//        if (!empty($restrictions->repeat_number_four_times_in_succession)) {
//            if (preg_match("/([0-9])\1{" . (($restrictions->repeat_number_four_times_in_succession_input) - 1) . ",}/", $kvitel_id)) {
//                return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
//            }
//        }

        if (!empty($restrictions->five_digit_sequence_between)) {
            $five_digit_sequence_between = $this->ascending_descending_array($restrictions->five_digit_sequence_between_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($kvitel_id, $sequence) !== false) {
//                    if (strpos($kvitel_id, $sequence) != 0 && (strpos($kvitel_id, $sequence) + strlen($sequence) != strlen($kvitel_id))) {
                    return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
//                    }
                }
            }
        }

        if (!empty($restrictions->starting_with_five_digit_or_more_ascending)) {
            $five_digit_sequence_between = $this->ascending_array($restrictions->starting_with_five_digit_or_more_ascending_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($kvitel_id, $sequence) !== false && strpos($kvitel_id, $sequence) == 0) {
                    return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
                }
            }
        }

        if (!empty($restrictions->starting_with_five_digit_or_more_descending)) {
            $five_digit_sequence_between = $this->descending_array($restrictions->starting_with_five_digit_or_more_descending_input);
            foreach ($five_digit_sequence_between as $sequence) {
                if (strpos($kvitel_id, $sequence) !== false && strpos($kvitel_id, $sequence) == 0) {
                    return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
                }
            }
        }

        if (!empty($restrictions->four_different_digits)) {
            $sequence_between = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            $four_different_digits_count = 0;
            foreach ($sequence_between as $sequence) {
                if (strpos($kvitel_id, $sequence) !== false) {
                    $four_different_digits_count++;
                }
            }
            if ($four_different_digits_count < $restrictions->four_different_digits_input) {
                return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
            }
        }

        if (!empty($restrictions->same_number_repeated_four_times_or_more)) {
            $sequence_between = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            foreach ($sequence_between as $sequence) {
                if (substr_count($kvitel_id, $sequence) >= $restrictions->same_number_repeated_four_times_or_more_input) {
                    return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
                }
            }
        }
        $checkExist = User::where(['kvitel_extension' => $extension, 'kvitel_id' => $kvitel_id])->first();
        if (empty($checkExist)) {
            return response()->json(['status' => 1, 'message' => "Congratulations, you have personalized the KVITEL ID"]);
        } else {
            return response()->json(['status' => 0, 'message' => "This ID is taken, please try again."]);
        }
    }

    static public function generatePasswordToken($email) {
        $token = str_shuffle(md5($email));
        return $token;
    }

    public function general() {
        return $this->hasOne('App\GeneralUser', 'user_id', 'id');
    }

    public function social() {
        return $this->hasOne('App\SocialUser', 'user_id', 'id');
    }

    public function address_users() {
        return $this->hasMany('App\AddressUser', 'user_id', 'id');
    }

    function ascending_descending_array($length) {
        $new_array = [];

        for ($i = 0; $i <= 9; $i++) {
            $k = $i;
            $number = "";
            for ($j = 1; $j <= $length; $j++) {
                $number = $number . $k;
                if ($k == 9) {
                    $k = 0;
                } else {
                    $k++;
                }
            }
            $new_array[] = $number;
        }
        for ($i = 9; $i >= 0; $i--) {
            $k = $i;
            $number = "";
            for ($j = 1; $j <= $length; $j++) {
                $number = $number . $k;
                if ($k == 0) {
                    $k = 9;
                } else {
                    $k--;
                }
            }
            $new_array[] = $number;
        }
        return $new_array;
    }

    function ascending_array($length) {
        $new_array = [];

        for ($i = 0; $i <= 9; $i++) {
            $k = $i;
            $number = "";
            for ($j = 1; $j <= $length; $j++) {
                $number = $number . $k;
                if ($k == 9) {
                    $k = 0;
                } else {
                    $k++;
                }
            }
            $new_array[] = $number;
        }
        return $new_array;
    }

    function descending_array($length) {
        $new_array = [];

        for ($i = 9; $i >= 0; $i--) {
            $k = $i;
            $number = "";
            for ($j = 1; $j <= $length; $j++) {
                $number = $number . $k;
                if ($k == 0) {
                    $k = 9;
                } else {
                    $k--;
                }
            }
            $new_array[] = $number;
        }
        return $new_array;
    }

    public function contact_detail() {
        return $this->belongsToMany('App\Contact', 'kvitel_contacts', 'user_id', 'contact_id');
    }
    
    public function favourites(){
        return $this->belongsToMany('App\Favourite', 'user_favourites', 'user_id', 'favourite_id');
    }

}
