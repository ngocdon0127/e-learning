<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Courses;
use App\Http\Controllers\Auth\AuthController;
use App\Posts;
use App\Questions;
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
        if (!AuthController::checkPermission()){
            return redirect('auth/login');
        };
        $courses = array('1'=>1, '2'=>3);
        $t = array('hehe'=>$courses);
            return view('admin.addpost', $t);
    }

    public function savePost(Request $request){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = $request->all();
        $post = new Posts();
        $post->CourseID = $data['CourseID'];
        $post->FormatID = $data['FormatID'];
        $post->Title = $data['Title'];
        $post->Description = $data['Description'];
        $post->save();

        $post = Posts::orderBy('id', 'desc')->first();

        //Photo
        $file = $request->file('Photo');
//        $file = Request::file('Photo');
        $post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id  . "." . $file->getClientOriginalExtension();
        $file->move(base_path() . '/public/images/imagePost/', $post->Photo);


        // (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


        $post->update();
        return redirect('/course/'.$post->CourseID);
//        return $post;
    }

    public function viewPost($postID){
        $post = Posts::findOrNew($postID)->toArray();
        $photo = $post['Photo'];
        $questions = Questions::where('PostID', '=', $postID)->get()->toArray();
        $bundle = array();
        $bundleAnswer = array();
        foreach ($questions as $q){
            $answer = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
            $bundle += array($q['id'] => $answer);
            $bundleAnswer += [$q['id'] => AnswersController::getAnswer($q['id'])];
        }
        $result = array('Title' => $post['Title'], 'PostID' => $postID, 'Questions' => $questions, 'Photo' => $photo, 'Bundle' => $bundle, 'BundleAnswers' => $bundleAnswer, 'MaxScore' => count($questions));
        return view('viewpost', $result);
//        return var_dump($bundleAnswer);
    }

    public function viewNewestPosts(){
//        $posts = Posts::take(5)->skip(0)->get()->toArray();
        $posts = Posts::orderBy('id', 'desc')->paginate(5);
        return view('userindex')->with('Posts', $posts);
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
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $Post = Posts::find($id);
        return view('admin.editpost', compact('Post'));
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
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = $request->all();
        $post = Posts::find($id);
        $post->CourseID = $data['CourseID'];
        $post->FormatID = $data['FormatID'];
        $post->Title = $data['Title'];
        $post->Description = $data['Description'];
        $post->update();

        // if admin upload new photo
        if ($request->file('Photo') != null) {
            $post = Posts::find($id);

            $file = $request->file('Photo');
            //        $file = Request::file('Photo');
            $post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id . "." . $file->getClientOriginalExtension();
            $file->move(base_path() . '/public/images/imagePost/', $post->Photo);


            // (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


            $post->update();
        }
        return redirect('/course/'.$post->CourseID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $post = Posts::find($id);
        $questions = Questions::where('PostID', '=', $id)->get()->toArray();
        foreach ($questions as $question) {
            Questions::destroy($question['id']);
        }
        $courseid = $post['CourseID'];
        $post->delete();
        return redirect('/course/' . $courseid);
    }
}
