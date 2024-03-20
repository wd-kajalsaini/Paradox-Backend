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
use App\Team;
use App\Player;
use App\TeamPlayer;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Contracts\Filesystem\Filesystem;

class TeamController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sectionAuth');
    }

    public function index(){
        $data['page_title'] = 'Team';
        $data['link'] = 'Teams';
        $data['teams'] = Team::withCount('players')->get();
        return view('teams.index', $data);
    }

    public function add(Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = new Team();
            $newDataField = ['title' => $input['title']];
            if (!empty($request->file('thumbnail'))) {
                $team_icon = $request->file('thumbnail');
                $team_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $team_icon->getClientOriginalExtension();
                $team_icondb = "https://".AWS_BUCKET.".s3.us-east-2.amazonaws.com/team_logo/" . $team_iconFileName;
                $s3 = \Storage::disk('s3');
                $filePath = '/team_logo/' . $team_iconFileName;
                $team_icon_image = $s3->put($filePath, file_get_contents($team_icon), 'public');
                $newDataField['logo'] = $team_icondb;
            }
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                $team_player = [];
                foreach($input['players'] as $player){
                    $team_player[] = ['team_id' => $newData->id, 'player_id' => $player, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                TeamPlayer::insert($team_player);
                DB::commit();

                \Session::flash('message', 'Team added successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('teamsListing');
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Add team';
        $data['link'] = 'Teams';
        $data['players'] = Player::get();

        return view('teams.add', $data);
    }

    /* Edit Player */

    public function edit($id, Request $request){
        if ($request->isMethod('post')) {
            $input = $request->all();
            $newData = Team::find($id);
            $newDataField = ['title' => $input['title']];
            if (!empty($request->file('thumbnail'))) {
                $team_icon = $request->file('thumbnail');
                $team_iconFileName = str_replace(" ", "", str_replace(".", "", microtime())) . '.' . $team_icon->getClientOriginalExtension();
                $team_icondb = "https://".AWS_BUCKET.".s3.us-east-2.amazonaws.com/team_logo/" . $team_iconFileName;
                $s3 = \Storage::disk('s3');
                $filePath = '/team_logo/' . $team_iconFileName;
                $team_icon_image = $s3->put($filePath, file_get_contents($team_icon), 'public');
                $newDataField['logo'] = $team_icondb;
            }
            $newData->fill($newDataField);
            try{
                DB::beginTransaction();
                $newData->save();
                $team_player = [];
                TeamPlayer::where(['team_id' => $newData->id])->delete();
                foreach($input['players'] as $player){
                    $team_player[] = ['team_id' => $newData->id, 'player_id' => $player, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                }
                TeamPlayer::insert($team_player);
                DB::commit();

                \Session::flash('message', 'Team updated successfully!');
                \Session::flash('class', 'success');
                return redirect()->route('teamsListing');
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['status' => 0, 'message' => "Something went wrong"]);
            }
        }
        $data['page_title'] = 'Edit team';
        $data['link'] = 'Teams';
        $data['players'] = Player::get();
        $data['team'] = Team::with('players')->find($id)->toArray();
        $data['selectedPlayers'] = array_column($data['team']['players'],'id');
        return view('teams.edit', $data);
    }

    /* Delete Show */

    public function delete($id) {
        if (Team::destroy($id)) {
            \Session::flash('message', 'Team Deleted Successfully!');
            \Session::flash('class', 'success');
            return response()->json(['status' => 1, 'message' => "Team Deleted Successfully"]);
        } else {
            return response()->json(['status' => 0, 'message' => "Something went Wrong"]);
        }
    }

}
