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
use App\Player;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\Filesystem;

class PlayerController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function index(){
        $data['page_title'] = 'Player';
        $data['link'] = 'Players';
        $data['players'] = Player::get();

        return view('players.index', $data);
    }

    public function add(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new Player();
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            if (!empty($request->file('thumbnail'))) {
                $thumbnail_icon = $request->file('thumbnail');
                $thumbnail_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $thumbnail_icon->getClientOriginalExtension();
                $thumbnail_icondb = "https://".AWS_BUCKET.".s3.us-east-2.amazonaws.com/player_images/" . $thumbnail_iconFileName;
                $s3 = \Storage::disk('s3');
                $filePath = '/player_images/' . $thumbnail_iconFileName;
                $thumbnail_icon_image = $s3->put($filePath, file_get_contents($thumbnail_icon), 'public');
                $newDataField['thumbnail'] = $thumbnail_icondb;
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Player added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('playersListing');
            }
        }
        $data['page_title'] = 'Add player';
        $data['link'] = 'Players';

        return view('players.add', $data);
    }

    /* Edit Player */

    public function edit($id, Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = Player::find($id);
            $newDataField = collect($input)->forget(['_token', '_method'])->toArray();
            foreach ($newDataField as $newDataFieldKey => $newDataFieldValue) {
                $newDataField[$newDataFieldKey] = (!empty($newDataFieldValue) && !(is_null($newDataFieldValue))) ? $newDataFieldValue : "";
            }
            if (!empty($request->file('thumbnail'))) {
                $thumbnail_icon = $request->file('thumbnail');
                $thumbnail_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $thumbnail_icon->getClientOriginalExtension();
                $thumbnail_icondb = "https://".AWS_BUCKET.".s3.us-east-2.amazonaws.com/player_images/" . $thumbnail_iconFileName;
                $s3 = \Storage::disk('s3');
                $filePath = '/player_images/' . $thumbnail_iconFileName;
                $thumbnail_icon_image = $s3->put($filePath, file_get_contents($thumbnail_icon), 'public');
                $newDataField['thumbnail'] = $thumbnail_icondb;
            }
            $newData->fill($newDataField);
            if ($newData->save()) {
                \Session::flash('message', 'Player updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('playersListing');
            }
        }
        $data['page_title'] = 'Edit Player';
        $data['link'] = 'Players';
        $data['player'] = Player::find($id);

        return view('players.edit', $data);
    }

    /* Delete Show */

    public function delete($id) {
        if (Player::destroy($id)) {
            \Session::flash('message', 'Player Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Player Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

}
