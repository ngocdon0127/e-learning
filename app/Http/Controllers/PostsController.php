<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Courses;
use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    var $imagePost = '/images/imagePost/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addPost(){
//        $courses = Courses::all();
//        $courses->toArray();
        $courses = array('1'=>1, '2'=>3);
        $t = array('hehe'=>$courses);
            return view('admin.addpost', $t);
    }

    public function savePost(Request $request){
        $data = $request->all();
        $post = new Posts();
        $post->CourseID = $data['CourseID'];
        $post->FormatID = $data['FormatID'];
        $post->Question = $data['Question'];

        //Photo
        $file = $request->file('Photo');
//        $file = Request::file('Photo');
        $post->Photo = $data['CourseID'] . '_' . (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1) . "." . $file->getClientOriginalExtension();
        $file->move(base_path() . '/public/images/imagePost/', $post->Photo);

        $post->Description = $data['Description'];
        $post->save();
        return redirect('/course/'.$post->CourseID);
//        return $post;
    }

    public function viewPost($postID){
        $post = Posts::findOrNew($postID)->toArray();
        $photo = $post['Photo'];
        $answers = Answers::where('PostID', '=', $postID)->get()->toArray();
        $result = array('PostID' => $postID, 'Answers' => $answers, 'Photo' => $photo);
        return view('viewpost', $result);
//        return var_dump($result);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
