<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;
use PhpSpec\Exception\Exception;

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
