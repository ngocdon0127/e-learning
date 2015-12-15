<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Posts;
use App\Questions;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{

    public function viewCourse($courseid){
        $course = Courses::findOrNew($courseid)->toArray();
//        $result = array('Title' => $course['Title']);
        $posts = Posts::where('CourseID', '=', $courseid)->get()->toArray();
        $numQuestions = [];
        foreach($posts as $p){
            $numQuestions += [($p['id']) => count(Questions::where('PostID', '=', $p['id'])->get()->toArray())];
        }
        $r = array('posts' => $posts);
        $r += array('Title' => $course['Title']);
        $r += array('NumQuestions' => $numQuestions);
        $r += array('CourseID' => $courseid);
//        return var_dump($r);
//        dd($r);
        return view('viewcourse', $r);
    }

    public function addCourse(){
        if (!AuthController::checkPermission()){
//            RedirectIfAuthenticated::$backPath = 'add/course';
//            AuthController::$redirectPath = '/admin/adcourse';
            return redirect('auth/login');
        };
        return view('admin.addcourse');
    }

    public static function viewAllCourses(){
        $allcourse = Courses::all()->toArray();
        return view('admin.index')->with("allcourse", $allcourse);
    }

    public function saveCourse(Request $request){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = $request->all();
        $course = new Courses();
        $course->Title = $data['Title'];
        $course->Description = $data['Description'];
        $course->save();
        return redirect('/admin/addpost');
    }

    public function checkCourseTitle($Title){
        $course = Courses::where('Title', '=', $Title)->get()->toArray();
        if (count($course) > 0){
            return 'exist';
        }
        return 'notExist';
    }

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
        $course = Courses::find($id);
        return view('admin.editcourse', compact('course'));
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
        $course = Courses::find($id);

        $course->Title = $data['Title'];
        $course->Description = $data['Description'];
        $course->update();

        return redirect('/course/' . $course->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($id)
    {
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $course = Courses::find($id);
        $posts = Posts::where('CourseID', '=', $id)->get()->toArray();
//        dd($posts);
        foreach ($posts as $post) {
            PostsController::destroy($post['id']);
//            dd($post['id']);
        }
        $course->delete();
        return redirect('/admin');
    }
}
