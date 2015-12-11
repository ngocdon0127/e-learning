<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Posts;
use App\Questions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswersController extends Controller
{

    public function getFile($fileName){
        return '/js/' . $fileName;
    }

    public static function getAnswer($QuestionID){
        $answers = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        foreach($answers as $a){
            if ($a['Logical'] == 1){
                return $a['id'];
            }
        }
        return -1;
    }

    public function checkAnswer($QuestionID, $AnswerID){
        $answer = Answers::findOrNew($AnswerID)->toArray();
        $result = '<response><logical>' . $answer['Logical'] . '</logical><answer>';
        $answers = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        $answerid = '';
        foreach($answers as $a){
            if ($a['Logical'] == 1){
                $answerid = $a['id'];
                break;
            }
        }
        $result .= $answerid . '</answer></response>';
        return $result;
    }

    public function addAnswer($QuestionID){
        $post = Questions::findOrNew($QuestionID)->toArray();
        $photo = $post['Photo'];
        $answers = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        $result = array('QuestionID' => $QuestionID, 'Answers' => $answers, 'Photo' => $photo);
        return view('admin.addanswer')->with(["QuestionID" => $QuestionID, 'Photo' => $photo, 'Answers' => $answers]);
    }

    public function saveAnswer(Request $request){
        $data = $request->all();

        $count = $data['numAnswer'];
        $result = $data['resultQuestion'];
        for($i = 0; $i < $count; $i++){
            $answer = new Answers();
            $answer->QuestionID = $data['QuestionID'];
            $answer->Detail = $data['answer' . ($i + 1)];
            if ($result != ($i + 1)){
                $answer->Logical = 0;
            }
            else{
                $answer->Logical = 1;
            }
            $answer->toArray();
            $answer->save();
        }

        return redirect('/question/'.$answer->QuestionID);
    }

    public function add_answer($QuestionID, $Logical, $Detail){
        $answer = new Answers();
        $answer->QuestionID = $QuestionID;
        $answer->Logical = $Logical;
        $answer->Detail = $Detail;
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
