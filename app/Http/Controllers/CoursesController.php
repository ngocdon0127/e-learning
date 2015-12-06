<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Posts;
use Illuminate\Http\Request;

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
//        return var_dump($r);
        return view('viewcourse', $r);
    }

    public function addCourse(){
        return view('admin.addcourse');
    }

    public function saveCourse(Request $request){
        $data = $request->all();
        $course = new Courses();
        $course->Title = $data['Title'];
        $course->Description = $data['Description'];
        $course->save();
        return redirect('/admin/addpost');
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
