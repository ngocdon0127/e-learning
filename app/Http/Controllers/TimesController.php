<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Logins;
use App\Posts;
use App\User;
use App\Useronlines;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimesController extends Controller
{
	//

	public static $timeToExit = 7200;

	public function incTimeOnline(Request $request){
//        echo 'data';
		$data = $request->all();
		$UserID = $data['UserID'];
		if (!auth() || (auth()->user()->id != $UserID)){
			return;
		}
		$unload = $data['unload'];

		// If the page is loaded
		if ($unload == 0){
			Useronlines::where('UserID', '=', $UserID)->delete();
			$useronline = new Useronlines();
			$useronline->UserID = $UserID;
			$useronline->save();
			$user = User::find($UserID);
			if (count($user->toArray()) < 1)
				return;
			$user->TotalPages++;
			$user->update();
			return;
		}

		// If the page is about to be unloaded
		// <=>
		// User is navigating to another page or another site or exit.
		$record = Useronlines::where('UserID', '=', $UserID)->get();
		if (count($record->toArray()) < 1){
			// something wrong
			return;
		}
		// Increase Time Online of User
		$record = $record->first();
		$record->TotalPage++;
		$oldDateTime = $record->updated_at->getTimestamp();
		$record->update();
		$newDateTime = $record->updated_at->getTimestamp();
		$diff = $newDateTime - $oldDateTime;
		if (($diff < TimesController::$timeToExit ) && ($diff > 0)){
			$user = User::find($UserID);
			$user->TotalHoursOnline += $diff / 3600.0;
			$user->update();
		}

		// And delete the record
		$record->delete();
		return;

	}

	public function getUserIP(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function trackIP(Request $request){
		echo 'start saving ip';
		$data = $request->all();
		$UserID = array_key_exists('UserID', $data) ? $data['UserID'] : -1;
		$uri = array_key_exists('uri', $data) ? $data['uri'] : '';
		if ($UserID != -1){
			// Prevent user edit userID in Javascript source.
			if (!auth() || (auth()->user()->id != $UserID)){
				return;
			}
		}
		$ip = $this->getUserIP();
		$browser = get_browser(null, true);
		$record = Logins::where('UserID', '=', $UserID)->where('ip', 'LIKE', $ip)->where('Browser', 'LIKE', $browser['browser'])->where('Platform', 'LIKE', $browser['platform'])->get();
		if (count($record->toArray()) < 1){
			$login = new Logins();
			$login->UserID = $UserID;
			$login->ip = $ip;
			$login->Crawler = $browser['crawler'];
			$login->Browser = $browser['browser'];
			$login->BrowserFullName = $browser['browser_name_pattern'];
			$login->Platform = $browser['platform'];
			$login->UserAgent = $_SERVER['HTTP_USER_AGENT'];
			$login->Device = $browser['device_type'];
			$login->Pointing = $browser['device_pointing_method'];
			$login->LastURI = $uri;
			$login->save();
			echo "\n ip saved";
		}
		else{
			$record = $record->first();
			$record->Accesses++;
			$record->LastURI = $uri;
			$record->update();
			echo "\n ip updated";
		}
	}

	public function incTimePlay(Request $request){
		$data = $request->all();
		$UserID = $data['UserID'];
		$PostID = $data['PostID'];
		
	}

	public function br(){
//        echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";

		$browser = get_browser(null, true);
		dd($browser);
	}
}
