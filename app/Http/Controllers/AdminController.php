<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index(){
        if (!AuthController::checkPermission()){
            return redirect('/auth/login');
        }
        return CoursesController::viewAllCourses();
    }
}
