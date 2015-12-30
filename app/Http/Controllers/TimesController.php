<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Posts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimesController extends Controller
{
    //
    public function incTimeOnline(Request $request){
//        echo 'data';
        $data = $request->all();
        $UserID = $data['UserID'];
        $user = User::find($UserID);
        $user->TotalHoursOnline += 0.05;
        $user->update();
    }

    public function incTimePlay(Request $request){
        $data = $request->all();
        $UserID = $data['UserID'];
        $PostID = $data['PostID'];
        
    }
}
