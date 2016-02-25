<?php

namespace App\Http\Controllers;


use App\Answers;
use App\Comments;
use App\Courses;
use App\Learnings;
use App\Http\Controllers\Auth\AuthController;
use App\Posts;
use App\Questions;
use App\User;
use App\Doexams;
use App\ConstsAndFuncs;
use App\Tags;
use App\Hashtags;
use App\Spaces;
use App\Subquestions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

	public function viewNewestPosts(){
		if (auth() && auth()->user() && (User::find(auth()->user()->getAuthIdentifier())['admin'] >= ConstsAndFuncs::PERM_ADMIN)){
			$Posts = Posts::orderBy('id', 'desc')->paginate(5);
			$newpost = Posts::orderBy('visited', 'dsc')->take(5)->get();
			$paginateBaseLink = '/';
			return view('userindex')->with(compact(['Posts', 'newpost', 'paginateBaseLink']));
		}
		else{
			$hidden_course_ids = array();
			$courses = Courses::where('Hidden', '=', 1)->get()->toArray();
			foreach ($courses as $value) {
				$hidden_course_ids = array_merge($hidden_course_ids, [$value['id']]);
			}
			$Posts = Posts::whereNotIn('CourseID', $hidden_course_ids)->where('Hidden', '=', 0)->orderBy('id', 'desc')->paginate(5);
			$newpost = Posts::whereNotIn('CourseID', $hidden_course_ids)->where('Hidden', '=', 0)->orderBy('visited', 'dsc')->take(5)->get();
			$paginateBaseLink = '/';
			return view('userindex')->with(compact(['Posts', 'newpost', 'paginateBaseLink']));
		}
	}

	public function viewPost($postID){

		if (!auth() || !(auth()->user())){
			$browser = get_browser(null, true);

			// Allow crawler && Facebook Bot view post without logging in.
			if (
				($browser['crawler'] != 1) &&
				(stripos($_SERVER["HTTP_USER_AGENT"], 'facebook') === false) &&
				(stripos($_SERVER["HTTP_USER_AGENT"], 'face') === false) &&
				(stripos($_SERVER["HTTP_USER_AGENT"], 'google') === false)
			){
				$redirectPath = '/post/' . $postID;
				return redirect('/auth/login')->with('redirectPath', $redirectPath);
			}
			$token = md5(rand(), false);
			$DisplayedQuestions = ConstsAndFuncs::$FreeQuestionsForCrawler;
		}

		$post = Posts::find($postID);
		if (count($post) < 1){
			return view('errors.404');
		}
		$courseID = $post['CourseID'];
		$course = Courses::find($courseID);
		$post->visited++;
		$post->update();
		$post = $post->toArray();
		if (auth() && (auth()->user())){
			$userID = auth()->user()->getAuthIdentifier();
			if (User::find($userID)['admin'] < ConstsAndFuncs::PERM_ADMIN){
				if (($course['Hidden'] == 1) || ($post['Hidden'] == 1))
					return view('errors.404');
			}
			$tmp = Learnings::where('UserID', '=', $userID)->where('CourseID', '=', $courseID)->get()->toArray();
			if (count($tmp) < 1){
				$learnings = new Learnings();
				$learnings->UserID = $userID;
				$learnings->CourseID = $courseID;
				$learnings->save();
				$course->NoOfUsers++;
				$course->update();
			}

			// Insert a new record into DoExams Table to mark the time user start answering questions in post.
			$exam = new Doexams();
			$exam->UserID = $userID;
			$exam->PostID = $postID;
			$token = md5($userID . rand(), false) . md5($postID . rand(), false);
			$exam->token = $token;
			$exam->save();

			// Check if user is vip or not
			$user = User::find(auth()->user()->getAuthIdentifier());
			if ($user['vip'] == 0){
				$DisplayedQuestions = $post['NoOfFreeQuestions'];
			}
			else{
				$DisplayedQuestions = ((new \DateTime($user['expire_at'])) >= (new \DateTime())) ? -1 : $post['NoOfFreeQuestions'];
			}

			if ($user['admin'] >= ConstsAndFuncs::PERM_ADMIN){
				$DisplayedQuestions = -1;
			}
			// If web hasn't provide some VIP package
			// every user will be able to see full post
			if (ConstsAndFuncs::IS_PAID == 0){
				$DisplayedQuestions = -1;
			}
		}

		$photo = $post['Photo'];
		if ($DisplayedQuestions > 0)
			$questions = Questions::where('PostID', '=', $postID)->take($DisplayedQuestions)->get()->toArray();
		else
			$questions = Questions::where('PostID', '=', $postID)->get()->toArray();
		$AnswersFor1 = array();
		$TrueAnswersFor1 = array();
		$AnswersFor2 = array();
		$Spaces = array();
		$SetOfSpaceIDs = array();
		$Subquestions = array();
		$AnswersFor5 = array();
		$QuestionFor5IDs = array();
		$AnswersFor6 = array();
		$DragDropIDs = array();
		$CompleteAnswersFor6 = array();
		$AnswersFor3 = array();
		$AnswersFor4 = array();
		$FillCharacterIDs = array();
		$ArrangedIDs = array();
		$maxscore = 0;
		foreach ($questions as $q){
			switch ($q['FormatID']){
				case 1:		// Trắc nghiệm
					$answers = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
					foreach ($answers as $a) {
						if ($a['Logical'] == 1){
							$TrueAnswersFor1 += [$q['id'] => $a['id']];
							break;
						}
					}
					$info = [$q['id'] => $answers];
					if (count($answers) > 0)
						$maxscore++;
					$AnswersFor1 += $info;
					continue;
				case 2:		// Điền từ
					$spaces = Spaces::where('QuestionID', '=', $q['id'])->get()->toArray();
					$Spaces += [$q['id'] => $spaces];
					foreach ($spaces as $s) {
						$SetOfSpaceIDs = array_merge($SetOfSpaceIDs, [$s['id']]);
						$a = Answers::where('SpaceID', '=', $s['id'])->get()->toArray();
						shuffle($a);
						$AnswersFor2 += [$s['id'] => $a];
					}
					$maxscore += count($spaces);
					continue;
				case 3:
					$answer = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
					$AnswersFor3 += [$q['id'] => $answer[0]];
					$ArrangedIDs = array_merge($ArrangedIDs, [$q['id']]);
					$maxscore++;
					continue;
				case 4:
					$answer = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
					$AnswersFor4 += [$q['id'] => $answer[0]];
					$FillCharacterIDs = array_merge($FillCharacterIDs, [$q['id']]);
					$maxscore++;
					continue;
				case 5:		// Nối
					$subquestions = Subquestions::where('QuestionID', '=', $q['id'])->get()->toArray();
					$answer = array();
					foreach ($subquestions as $s) {
						$a = Answers::where('SubQuestionID', '=', $s['id'])->get()->toArray();
						$answer += [$s['id'] => $a[0]];
					}
					$AnswersFor5 += [$q['id'] => $answer];
					$maxscore += count($subquestions);
					$Subquestions += [$q['id'] => $subquestions];
					$QuestionFor5IDs = array_merge($QuestionFor5IDs, [$q['id']]);
					continue;
				case 6:		// Kéo thả
					$DragDropIDs = array_merge($DragDropIDs, [$q['id']]);
					$answers = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
					$AnswersFor6 += [$q['id'] => $answers];
					$s = '';
					foreach ($answers as $a) {
						$s .= $a['Detail'] . ' ';
					}
					$CompleteAnswersFor6 += [$q['id'] => $s];
					// $CompleteAnswersFor6 = array_merge($CompleteAnswersFor6, [$s]);
					$maxscore++;
					continue;
			}
		}
		$Comments = Comments::all()->toArray();
		$result = array(
			'Comments' => json_encode($Comments),
			'Questions' => $questions,
			'Post' => $post,
			'MaxScore' => $maxscore,
			'NumOfQuestions' => count($questions = Questions::where('PostID', '=', $postID)->get()->toArray()),
			'Token' => $token,
			'DisplayedQuestions' => $DisplayedQuestions
		);
		if (auth() && auth()->user() && User::find(auth()->user()->getAuthIdentifier())['admin'] >= ConstsAndFuncs::PERM_ADMIN){
			$nextPost = Posts::where('CourseID', '=', $post['CourseID'])
				->where('id', '>=', $post['id'])
				->get()->toArray();
			$previousPost = Posts::where('CourseID', '=', $post['CourseID'])
				->where('id', '<', $post['id'])
				->get()->toArray();
			$result += ['NextPost' => (count($nextPost) > 1) ? 
			$nextPost[1]['id'] : 
			Posts::where('CourseID', '=', $post['CourseID'])
				->first()->toArray()['id']];
			$result += ['PreviousPost' => (count($previousPost) > 0) ? 
			$previousPost[count($previousPost) - 1]['id'] : 
			Posts::where('CourseID', '=', $post['CourseID'])
				->orderBy('created_at', 'desc')
				->first()->toArray()['id']];
		}
		else {
			$nextPost = Posts::where('CourseID', '=', $post['CourseID'])
				->where('id', '>=', $post['id'])
				->where('Hidden', '=', 0)
				->get()->toArray();
			$previousPost = Posts::where('CourseID', '=', $post['CourseID'])
				->where('id', '<', $post['id'])
				->where('Hidden', '=', 0)
				->get()->toArray();
			$result += ['NextPost' => (count($nextPost) > 1) ? 
				$nextPost[1]['id'] : 
				Posts::where('CourseID', '=', $post['CourseID'])
					->where('Hidden', '=', 0)
					->first()->toArray()['id']];
			$result += ['PreviousPost' => (count($previousPost) > 0) ? 
				$previousPost[count($previousPost) - 1]['id'] : 
				Posts::where('CourseID', '=', $post['CourseID'])
					->where('Hidden', '=', 0)
					->orderBy('created_at', 'desc')
					->first()->toArray()['id']];
		}

		$newpost = array_merge($nextPost, $previousPost);
		$result += ['newpost' => $newpost];
		// dd($newpost);
		return view('viewpost')->with($result)->with(compact([
			'result', 
			'newpost', 
			// Answers for Format Trắc nghiệm
			'AnswersFor1',
			'TrueAnswersFor1',
			// Answers for Format Sắp xếp
			'AnswersFor3',
			'ArrangedIDs',
			// Spaces + Answers for Format Điền từ
			'Spaces', 
			'AnswersFor2',
			'SetOfSpaceIDs',
			// Answers for Format Điền chữ cái
			'AnswersFor4',
			'FillCharacterIDs',
			// Subquestion + Answers for Format Nối
			'subquestions',
			'AnswersFor5',
			'Subquestions',
			'QuestionFor5IDs',
			// Answers for Format Kéo thả
			'AnswersFor6',
			'DragDropIDs',
			'CompleteAnswersFor6',
		]));
	}

    public function addPost(){
//        $courses = Courses::all();
//        $courses->toArray();
		if (!AuthController::checkPermission()){
			return redirect('/auth/login');
		}
		return view('admin.addpost');
	}

	public function savePost(Request $request){
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$data = $request->all();

		$post = new Posts();
		if (array_key_exists('Hidden', $data) && ($data['Hidden'] == 'on'))
			$post->Hidden = 1;
		else
			$post->Hidden = 0;
		$post->CourseID = $data['CourseID'];
		$post->ThumbnailID = $data['ThumbnailID'];
		$post->Title = $data['Title'];
		$post->Description = $data['Description'];
		$post->NoOfFreeQuestions = $data['NoOfFreeQuestions'];

		switch ($data['ThumbnailID']){
			case '1': // Plain Text
				$post->save();
				$post = Posts::orderBy('id', 'desc')->first();
				//Photo
				$file = $request->file('Photo');
//              $file = Request::file('Photo');
				$post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id . "_-Evangels-English-www.evangelsenglish.com_" . "." . $file->getClientOriginalExtension();
				$file->move(base_path() . '/public/images/imagePost/', $post->Photo);
				$post->update();
				break;
			case '2': // Video
				$linkVideo = $data['Video'];
				$post->Video = PostsController::getYoutubeVideoID($linkVideo);
				$post->save();
				break;
		}
		$course = Courses::find($post->CourseID);
		$course->NoOfPosts++;
		$course->update();

		// Save Hashtag
		$rawHT = $data['Hashtag'];
		TagsController::tag($rawHT, $post->id);

		return redirect(route('admin.viewcourse', $post->CourseID));
	}

	public static function getYoutubeVideoID($rawLink){
		preg_match_all('/watch[?]v=([^&]+)/', $rawLink, $matches, PREG_PATTERN_ORDER);
		if ((count($matches) > 1) && (count($matches[1]) > 0)){
			return $matches[1][0];
		}
		preg_match_all('/youtu.be\/([^?&]+)/', $rawLink, $matches, PREG_PATTERN_ORDER);
		if ((count($matches) > 1) && (count($matches[1]) > 0)){
			return $matches[1][0];
		}
		return null;
	}

	public function edit($id)
	{
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$Post = Posts::find($id);
		$ahtk = Tags::where('PostID', '=', $id)->get()->toArray();
		$Hashtag = '';
		foreach ($ahtk as $k){
			$ht = Hashtags::find($k['HashtagID'])['Hashtag'];
			if (strlen($ht) > 0)
			$Hashtag .= '#' . $ht . ' ';
		}
		return view('admin.editpost', compact('Post') + array('Hashtag' => $Hashtag));
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
		$post = Posts::find($id);
		if (count($post) < 1){
			return redirect('/');
		}
		if (array_key_exists('Hidden', $data) && ($data['Hidden'] == 'on'))
			$post->Hidden = 1;
		else
			$post->Hidden = 0;
		$post->CourseID = $data['CourseID'];
		$post->ThumbnailID = $data['ThumbnailID'];
		$post->NoOfFreeQuestions = $data['NoOfFreeQuestions'];
		$post->Title = $data['Title'];
		if ($post->ThumbnailID == '2'){ // Thumbnail Quizz Video
			$post->Video = PostsController::getYoutubeVideoID($data['Video']);
		}
		$post->Description = $data['Description'];
		$post->update();

		if ($post->ThumbnailID == '1'){ // Thumbnail Quizz Plain Text
			// if admin upload new photo
			if ($request->file('Photo') != null) {
				$post = Posts::find($id);

				$file = $request->file('Photo');
				//        $file = Request::file('Photo');
				$post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id . "_-Evangels-English-www.evangelsenglish.com_" . "." . $file->getClientOriginalExtension();
				$file->move(base_path() . '/public/images/imagePost/', $post->Photo);


				// (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


				$post->update();
			}
		}

		// Update tags
		TagsController::removeTag($post->id);
		TagsController::tag($data['Hashtag'], $post->id);

		return redirect(route('user.viewpost', $post->id));
	}


	public function searchPostsByHashtag(Request $request){
		$data = $request->all();
		preg_match_all('/\b([a-zA-Z0-9]+)\b/', strtoupper($data['HashtagSearch']), $matches, PREG_PATTERN_ORDER);
		$hashtags = $matches[1];
		$posts = Posts::all()->toArray();
		$rank = array();
		foreach ($hashtags as $ht){
			foreach ($posts as $key => $post){
				if (!array_key_exists($key, $rank)){
					$rank += array($key => 0);
				}
				$postHashtag = Tags::where('PostID', '=', $post['id'])->get()->toArray();
				foreach ($postHashtag as $pht){
					if (stripos(Hashtags::find($pht['HashtagID'])->Hashtag, $ht) !== false){
						$rank[$key]++;
					}
				}

			}
		}

		foreach ($rank as $key => $value){
			if ($value < 1){
				unset($rank[$key]);
			}
		}
		arsort($rank);
		$result = array();
		$posts = Posts::all();
		foreach ($rank as $key => $value) {
			$result += array($key => $posts[$key]);
		}
		preg_match_all('/\b([a-zA-Z0-9]+)\b/', $data['HashtagSearch'], $matches, PREG_PATTERN_ORDER);
		$hashtags = $matches[1];
		$Hashtags = '';
		foreach ($hashtags as $ht){
			$Hashtags .= $ht . ' ';
		}
		return view('search')->with(['Posts' => $result, 'Hashtags' => $Hashtags]);
	}

	public static function destroy($id)
	{
		if (!AuthController::checkPermission()){
			return redirect('/');
		}
		$post = Posts::find($id);
		@unlink(public_path('images/imagePost/' . $post['Photo']));
		$questions = Questions::where('PostID', '=', $id)->get()->toArray();
		foreach ($questions as $question) {
			QuestionsController::destroy($question['id']);
		}
		$courseid = $post['CourseID'];
		$post->delete();
		$course = Courses::find($post->CourseID);
		$course->NoOfPosts--;
		$course->update();
		return redirect(route('admin.viewcourse', $courseid));
	}
}
