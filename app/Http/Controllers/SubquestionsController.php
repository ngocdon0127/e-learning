<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Subquestions;
use App\Questions;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SubquestionsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\DB;

class SubquestionsController extends Controller
{
    public function saveSubQuestion($QuestionID){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = Request::capture()->all();
        $count = $data['numAnswer'];
        for ($i=0; $i < $count; $i++) { 
            $subQ = $data['answer' . ($i + 1)];
            $SubQuestionID = DB::table('subquestions')->insertGetId([
                'QuestionID' => $QuestionID,
                'Question'   => $subQ,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $answer = new Answers();
            $answer->SubQuestionID = $SubQuestionID;
            $answer->Detail = $data['ta_answer' . ($i + 1)];
            $answer->Logical = 1;
            $answer->save();
        }
        return redirect(route('user.viewquestion', $QuestionID));
    }

    public function update($QuestionID){
        $question = Questions::find($QuestionID);
        $old_subquestions = Subquestions::where('QuestionID', '=', $QuestionID)->get()->toArray();
        foreach ($old_subquestions as $value) {
            SubquestionsController::destroy($value['id']);
        }
        $data = Request::capture()->all();
        $count = $data['numAnswer'];
        for ($i=0; $i < $count; $i++) { 
            $subQ = $data['answer' . ($i + 1)];
            $SubQuestionID = DB::table('subquestions')->insertGetId([
                'QuestionID' => $QuestionID,
                'Question'   => $subQ,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $answer = new Answers();
            $answer->SubQuestionID = $SubQuestionID;
            $answer->Detail = $data['ta_answer' . ($i + 1)];
            $answer->Logical = 1;
            $answer->save();
        }
        return redirect(route('user.viewquestion', $QuestionID));
    }

    public static function destroy($id){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $s = Subquestions::find($id);
        if (count($s) < 1){
            return redirect('/');
        }
        $answers = Answers::where('SubQuestionID', '=', $id)->delete();
        $s->delete();
    }
}
