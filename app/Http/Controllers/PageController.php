<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Posts;

class PageController extends Controller
{
    public function index(){
        $post = Posts::orderBy('id', 'dsc')->take(3)->get();
        return view('mainpage')->with(compact('post'));
    }
}
