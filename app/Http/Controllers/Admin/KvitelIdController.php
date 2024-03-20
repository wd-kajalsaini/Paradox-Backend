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
use App\KvitelIdRestriction;
use ReverseRegex\Lexer;
use ReverseRegex\Random\SimpleRandom;
use ReverseRegex\Parser;
use ReverseRegex\Generator\Scope;

# load composer
require "vendor/autoload.php";

class KvitelIdController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth', ['except' => ['app_content_field_ajax']]);
    }

    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $data_array = ["start_with_zero" => "", "five_digit_sequence_between" => "", "same_number_repeated_four_times_or_more" => "", "starting_with_five_digit_or_more_ascending" => "", "starting_with_five_digit_or_more_descending" => "", "four_different_digits" => "", "five_digit_sequence_between_input" => 5, "same_number_repeated_four_times_or_more_input" => 4, "starting_with_five_digit_or_more_ascending_input" => 5, "starting_with_five_digit_or_more_descending_input" => 5, "four_different_digits_input" => 4];
            $input_data = collect($request->all())->forget(['_token', '_method'])->toArray();
            if (!empty($input_data)) {
                foreach ($input_data as $data_key => $data_value) {
                    if (!empty($data_value)) {
                        $data_array[$data_key] = $data_value;
                    }
                }
            }
            $insert_array = KvitelIdRestriction::find(1);
            $insert_array->fill($data_array);
            if ($insert_array->update()) {
                \Session::flash('message', 'Restrictions updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('kvitelIdRestrictionsListing');
            }
        }

        $data['page_title'] = 'Extension Management';
        $data['link'] = 'Kvitel_Id_Restrictions';
        $data['restrictions'] = KvitelIdRestriction::first();

        return view('app_content.kvitel_id_restriction', $data);
    }

    public function index2() {
        $lexer = new Lexer('[a-z]{10}');
        $gen = new SimpleRandom(rand());
        $result = '';

        $parser = new Parser($lexer, new Scope(), new Scope());
        $parser->parse()->getResult()->generate($result, $gen);

        echo $result;
    }

}
