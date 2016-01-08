<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Http\Controllers\Auth\AuthController;
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
        if (!AuthController::checkPermission()){
            return redirect('auth/login');
        };
        $question = Questions::findOrNew($QuestionID)->toArray();
        $photo = $question['Photo'];
        $answers = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
        $result = array('QuestionID' => $QuestionID, 'Answers' => $answers, 'Photo' => $photo);
        return view('admin.addanswer')->with(["QuestionID" => $QuestionID, 'Photo' => $photo, 'Answers' => $answers]);
    }

    public function saveAnswer(Request $request){
//        dd($request);
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = $request->all();

        $count = $data['numAnswer'];
        $result = $data['resultQuestion'];
        for($i = 0; $i < $count; $i++){
            $answer = new Answers();
            $answer->QuestionID = $data['QuestionID'];
            $answer->Detail = $this->c2s_convert($data['answer' . ($i + 1)]);
            if ($result != ($i + 1)){
                $answer->Logical = 0;
            }
            else{
                $answer->Logical = 1;
            }
//            $answer->toArray();
            $answer->save();
        }

        return redirect('/question/'.$answer->QuestionID);
    }

    public function add_answer($QuestionID, $Logical, $Detail){
        if (!AuthController::checkPermission()) {
            return redirect('/');
        }
        $answer = new Answers();
        $answer->QuestionID = $QuestionID;
        $answer->Logical = $Logical;
        $answer->Detail = $Detail;
        $answer->save();
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
    public function edit($QuestionID)
    {
        if (!AuthController::checkPermission()) {
            return redirect('/');
        }
        $Answers = Answers::where('QuestionID', '=', $QuestionID)->get();
        foreach ($Answers as $answer){
            $answer['Detail'] = $this->s2c_convert($answer['Detail']);
        }
        $question = Questions::find($QuestionID)->toArray();

        $photo = $question['Photo'];
        return view('admin.editanswer')->with(['PostID' => $question['PostID'], "QuestionID" => $QuestionID, 'Answers' => $Answers, 'Photo' => $photo]);
    }

    private static $clientTag = ['[u]', '[/u]'];
    public static $serverTag = ['<u>', '</u>'];

    public static function c2s_convert($s){
        for($i = 0; $i < count(AnswersController::$clientTag); $i++){
            $s = str_replace(AnswersController::$clientTag[$i], AnswersController::$serverTag[$i], $s);
        }
        return $s;
    }

    public static function s2c_convert($s){
        for($i = 0; $i < count(AnswersController::$clientTag); $i++){
            $s = str_replace(AnswersController::$serverTag[$i], AnswersController::$clientTag[$i], $s);
        }
        return $s;
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
        if (!AuthController::checkPermission()) {
            return redirect('/');
        }

        $data = $request->all();
        $newCount = $data['numAnswer'];
        $setOfOldAnswers = Answers::where('QuestionID', '=', $id)->get()->toArray();
        $oldCount = count($setOfOldAnswers);
//        dd($setOfOldAnswers);
        $result = $data['resultQuestion'];

        // update answers

        // overwrite min($newCount, $oldCount) record
        $needToOverwrite = ($newCount < $oldCount) ? $newCount : $oldCount;
        for($i = 0; $i < $needToOverwrite; $i++){
            $answer = Answers::find($setOfOldAnswers[$i]['id']);
//            dd($answer);
//            $answer->QuestionID = $data['QuestionID'];
            $detail = $data['answer' . ($i + 1)];

            $answer->Detail = $this->c2s_convert($detail);
            if ($result != ($i + 1)){
                $answer->Logical = 0;
            }
            else{
                $answer->Logical = 1;
            }

//            dd($answer);
            $answer->update();
        }

        // if $newCount < $oldCount => delete redudant record
        for($i = $newCount; $i < $oldCount; $i++){
            $answer = Answers::find($setOfOldAnswers[$i]['id']);
            $answer->delete();
        }

        // if $newCount > $oldCount => insert new record
        for($i = $oldCount; $i < $newCount; $i++){
            $this->add_answer($id, $result != ($i + 1) ? 0 : 1, $this->c2s_convert($data['answer' . ($i + 1)]));
        }

        return redirect('answer/' . $id . '/edit');
//        return redirect('question/' . $id);
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
        $answer = Answers::find($id);
        $answer->delete();
    }
}
