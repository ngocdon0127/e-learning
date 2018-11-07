<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Posts;
use App\User;
use App\ConstsAndFuncs;
use App\Questions;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{

    public function adminViewCourse($courseid){
        $course = Courses::find($courseid);
        if (!$course){
            return view('errors.404');
        }
//        $result = array('Title' => $course['Title']);
        $course = $course->toArray();
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

    public function viewCourse($courseID){
        $course = Courses::find($courseID);
        if (!$course){
            return view('errors.404');
        }
        if (auth() && auth()->user() && (User::find(auth()->user()->getAuthIdentifier())['admin'] >= ConstsAndFuncs::PERM_ADMIN)){
            $posts = Posts::where('CourseID', '=', $courseID)->orderBy('id', 'asc')->paginate(5);
            $newpost = Posts::orderBy('id', 'dsc')->take(5)->get()->toArray();
            return view('userindex')->with(['Posts' => $posts, 'newpost' => $newpost, 'paginateBaseLink' => '/course/' . $courseID]);
        }
        else{
            if ($course['Hidden'] == 1){
                return view('errors.404');
            }
            $posts = Posts::where('CourseID', '=', $courseID)->where('Hidden', '=', 0)->orderBy('id', 'asc')->paginate(5);
            $newpost = Posts::orderBy('id', 'dsc')->where('Hidden', '=', 0)->take(5)->get()->toArray();
            return view('userindex')->with(['Posts' => $posts, 'newpost' => $newpost, 'paginateBaseLink' => '/course/' . $courseID]);
        }
    }

    public function addCourse(){
        if (!AuthController::checkPermission()){
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
        if (array_key_exists('Hidden', $data) && ($data['Hidden'] == 'on'))
            $course->Hidden = 1;
        else
            $course->Hidden = 0;
        $course->Title = $data['Title'];
        $course->CategoryID = $data['CategoryID'];
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
        if (!$course){
            return redirect('/');
        }
        if (array_key_exists('Hidden', $data) && ($data['Hidden'] == 'on'))
            $course->Hidden = 1;
        else
            $course->Hidden = 0;
        $course->CategoryID = $data['CategoryID'];
        $course->Title = $data['Title'];
        $course->Description = $data['Description'];
        $course->update();

        return redirect(route('admin.viewcourse', $course->id));
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
        return redirect(route('admin'));
    }
}
