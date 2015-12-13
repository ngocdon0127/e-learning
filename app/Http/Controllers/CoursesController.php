<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{

    public function viewCourse($courseid){
        $course = Courses::findOrNew($courseid)->toArray();
//        $result = array('Title' => $course['Title']);
        $posts = Posts::all()->toArray();
        $result = array();
        foreach ($posts as $post) {
            if ($post['CourseID'] == $courseid)
                $result += array($post['id'] => $post);
        }
        $r = array('posts' => $result);
        $r += array('Title' => $course['Title']);
        $r += array('CountPost' => count($result));
        $r += array('CourseID' => $courseid);
//        return var_dump($r);
        return view('viewcourse', $r);
    }

    public function addCourse(){
        if (!AuthController::checkPermission()){
//            RedirectIfAuthenticated::$backPath = 'add/course';
            AuthController::$redirectPath = '/admin/adcourse';
            return redirect('auth/login');
        };
        return view('admin.addcourse');
    }

    public static function viewAllCourses(){
        $allcourse = Courses::all()->toArray();
        return view('admin.index')->with("allcourse", $allcourse);
    }

    public function saveCourse(Request $request){
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
    public function destroy($id)
    {
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $course = Courses::find($id);
        $posts = Posts::where('CourseID', '=', $id)->get()->toArray();
        foreach ($posts as $post) {
            Posts::destroy($post['id']);
        }
        $course->delete();
        return redirect('/admin');
    }
}
