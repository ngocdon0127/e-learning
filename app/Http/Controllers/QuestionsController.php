<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Http\Controllers\Auth\AuthController;
use App\Questions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{
    protected static $imageQuestionPath = '/public/images/imageQuestion/';

    public function viewQuestion($QuestionID){
        $question = Questions::findOrNew($QuestionID)->toArray();
        $photo = $question['Photo'];
        $answer = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        $result = array('Question' => $question['Question'], 'Description' => $question['Description'], 'QuestionID' => $QuestionID, 'Answers' => $answer, 'Photo' => $photo);
        return view('viewquestion', $result);
    }

    public function addQuestion($PostID){
        if (!AuthController::checkPermission()){
            return redirect('auth/login');
        };
        return view('admin.addquestion')->with(['PostID' => $PostID]);
    }

    public function saveQuestion($PostID){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
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
        return redirect('/answer/' . $question->id . '/edit');
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
        $Question = Questions::find($id);
        return view('admin.editquestion', compact('Question'));
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
        $question = Questions::find($id);
        $question->Question = $data['Question'];
        $question->Description = $data['Description'];
        $question->update();

        // if admin upload new photo
        if ($request->file('Photo') != null) {
            $question = Questions::find($id);

            $file = $request->file('Photo');
            //        $file = Request::file('Photo');
            $question->Photo = 'Question_' . $question['PostID'] . '_' . $question->id . "." . $file->getClientOriginalExtension();
            $file->move(base_path() . '/public/images/imageQuestion/', $question->Photo);


            // (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


            $question->update();
        }
        return redirect('/question/'.$question->id);
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
        $question = Questions::find($id);
        @unlink(public_path('images/imageQuestion/' . $question['Photo']));
        $answers = Answers::where('QuestionID', '=', $id)->get()->toArray();
        foreach ($answers as $answer) {
            Answers::destroy($answer['id']);
        }
        $postid = $question['PostID'];
        $question->delete();
        return redirect('/post/' . $postid);
    }
}
