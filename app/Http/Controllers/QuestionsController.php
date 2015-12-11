<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Http\Controllers\Auth\AuthController;
use App\Questions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionsController extends Controller
{

    public function viewQuestion($QuestionID){
        $question = Questions::findOrNew($QuestionID)->toArray();
        $photo = $question['Photo'];
        $answer = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        $result = array('QuestionID' => $QuestionID, 'Answers' => $answer, 'Photo' => $photo);
        return view('viewquestion', $result);
    }

    public function addQuestion($PostID){
        if (!AuthController::checkPermission()){
            return redirect('auth/login');
        };
        return view('admin.addquestion')->with(['PostID' => $PostID]);
    }

    public function saveQuestion($PostID){
        $data = Request::capture();
        $question = new Questions();
        $question->PostID = $PostID;
        $question->Question = $data['Question'];
        $question->Description = $data['Description'];
        $question->save();


        $question = Questions::orderBy('id', 'desc')->first();

        //Photo
        $file = Request::capture()->file('Photo');
//        $file = Request::file('Photo');
        $question->Photo = 'Question_' . $PostID . '_' . $question->id  . "." . $file->getClientOriginalExtension();
        $file->move(base_path() . '/public/images/imageQuestion/', $question->Photo);


        // (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


        $question->update();
        return redirect('/admin/addanswer/'.$question->id);
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
