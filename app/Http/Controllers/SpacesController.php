<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Spaces;
use App\Answers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnswersController;
use Illuminate\Support\Facades\DB;

class SpacesController extends Controller
{
	public function saveSpace($QuestionID)
	{
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$data = Request::capture();
		$count = $data['numAnswer'];
		for($i = 0; $i < $count; $i++){
			$rawAnswer = trim(AnswersController::c2s_convert($data['answer' . ($i + 1)]));
			preg_match_all('/([^;]+);/', $rawAnswer, $matches, PREG_PATTERN_ORDER);
			$arrayOfAnswer = $matches[1];
			$SpaceID = DB::table('spaces')->insertGetId([
				'QuestionID' => $QuestionID,
				'created_at' => new \DateTime(),
				'updated_at' => new \DateTime()
			]);
			$true = true;
			foreach ($arrayOfAnswer as $value) {
			$a = new Answers();
			$a->Logical = $true;
			$a->SpaceID = $SpaceID;
			$a->Detail = trim($value);
			$a->save();
			$true = false;
			}
		}

		return redirect(route('user.viewquestion', $QuestionID));
	}

	public function update($QuestionID){
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$data = Request::capture();
		$count = $data['numAnswer'];

		// delete all old spaces with corresponding answers
		$oldSpaces = Spaces::where('QuestionID', '=', $QuestionID)->get()->toArray();
		foreach ($oldSpaces as $value) {
			SpacesController::destroy($value['id']);
		}
		for($i = 0; $i < $count; $i++){
			$rawAnswer = trim(AnswersController::c2s_convert($data['answer' . ($i + 1)]));
			preg_match_all('/([^;]+);/', $rawAnswer, $matches, PREG_PATTERN_ORDER);
			$arrayOfAnswer = $matches[1];
			$SpaceID = DB::table('spaces')->insertGetId([
				'QuestionID' => $QuestionID,
				'created_at' => new \DateTime(),
				'updated_at' => new \DateTime()
			]);
			$true = true;
			foreach ($arrayOfAnswer as $value) {
				$a = new Answers();
				$a->Logical = $true;
				$a->SpaceID = $SpaceID;
				$a->Detail = trim($value);
				$a->save();
				$true = false;
			}
		}
		return redirect(route('user.viewquestion', $QuestionID));
	}

	public static function destroy($SpaceID){
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$space = Spaces::find($SpaceID);
		$answers = Answers::where('SpaceID', '=', $SpaceID)->get()->toArray();
		foreach ($answers as $answer) {
			Answers::destroy($answer['id']);
		}
		$space->delete();
		return;
	}
}
