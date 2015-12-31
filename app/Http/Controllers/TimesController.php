<?php

namespace App\Http\Controllers;

use App\Courses;
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
        if ($diff < TimesController::$timeToExit ){
            $user = User::find($UserID);
            $user->TotalHoursOnline += $diff / 3600.0;
            $user->update();
        }

        // And delete the record
        $record->delete();
        return;




//        $record = Useronlines::where('UserID', '=', $UserID)->get();
//        if (count($record->toArray()) < 1){
//            // The first time this user log in.
//            $useronline = new Useronlines();
//            $useronline->UserID = $UserID;
//            $useronline->save();
//            return;
//        }
//
//        // If user is already logged in.
//        $record = $record->first();
//        $record->TotalPage++;
//        $oldDateTime = $record->updated_at->getTimestamp();
//        $record->update();
//        $newDateTime = $record->updated_at->getTimestamp();
//        $diff = $newDateTime - $oldDateTime;
//        if ($diff < TimesController::$timeToExit ){
//            $user = User::find($UserID);
//            $user->TotalHoursOnline += $diff / 3600.0;
//            $user->update();
//        }
//        return;
    }

    public function incTimePlay(Request $request){
        $data = $request->all();
        $UserID = $data['UserID'];
        $PostID = $data['PostID'];
        
    }
}
