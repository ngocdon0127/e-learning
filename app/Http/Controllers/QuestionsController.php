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
use App\Http\Controllers\PostsController;

class QuestionsController extends Controller
{
	protected static $imageQuestionPath = '/public/images/imageQuestion/';

	public function viewQuestion($QuestionID){
		$Question = Questions::find($QuestionID);
		if (count($Question) < 1){
			return view('errors.404');
		}
		$Question = $Question->toArray();
		$Answers = Answers::where('QuestionID', '=', $QuestionID)->get()->toArray();
		return view('viewquestion')->with(compact('Question', 'Answers'));
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
		$question->FormatID = $data['FormatID'];
		$question->Question = $data['Question'];
		$question->Description = $data['Description'];
		switch ($data['FormatID']){
			case '1': // Photo
				$question->save();
				$question = Questions::orderBy('id', 'desc')->first();

				//Photo
				$file = Request::capture()->file('Photo');
//              $file = Request::file('Photo');
				if ($file != null){
					$question->Photo = 'Question_' . $PostID . '_' . $question->id  . "." . $file->getClientOriginalExtension();
					$file->move(base_path() . '/public/images/imageQuestion/', $question->Photo);
				}

				// (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


				$question->update();
				break;
			case '2': // Video
				$linkVideo = $data['Video'];
				$question->Video = PostsController::getYoutubeVideoID($linkVideo);
				$question->save();
				break;
		}
		echo $question->id;
		return;
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
		$question->FormatID = $data['FormatID'];
		$question->Description = $data['Description'];
		$question->update();

		switch ($data['FormatID']){
			case '1': // Photo
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
				break;
			case '2':
				$question->Video = PostsController::getYoutubeVideoID($data['Video']);
				$question->update();
		}
		return redirect(route('user.viewquestion', $question->id));
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
		return redirect(route('user.viewpost', $postid));
	}
}
