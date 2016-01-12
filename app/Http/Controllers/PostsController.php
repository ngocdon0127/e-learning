<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Comments;
use App\Courses;
use App\Doexams;
use App\Hashtags;
use App\Http\Controllers\Auth\AuthController;
use App\Learning;
use App\Logins;
use App\Posts;
use App\Questions;
use App\Tags;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    var $imagePost = '/images/imagePost/';
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

    public function addPost(){
//        $courses = Courses::all();
//        $courses->toArray();
        if (!AuthController::checkPermission()){
            return redirect('auth/login');
        };
        $courses = array('1'=>1, '2'=>3);
        $t = array('hehe'=>$courses);
            return view('admin.addpost', $t);
    }

    public function savePost(Request $request){
        if (!AuthController::checkPermission()){
            return redirect('/');
        }
        $data = $request->all();

        $post = new Posts();
        $post->CourseID = $data['CourseID'];
        $post->FormatID = $data['FormatID'];
        $post->Title = $data['Title'];
        $post->Description = $data['Description'];

        switch ($data['FormatID']){
            case '1': // Plain Text
                $post->save();
                $post = Posts::orderBy('id', 'desc')->first();
                //Photo
                $file = $request->file('Photo');
//              $file = Request::file('Photo');
                $post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id  . "." . $file->getClientOriginalExtension();
                $file->move(base_path() . '/public/images/imagePost/', $post->Photo);


                // (intval(Posts::orderBy('created_at', 'desc')->first()->id) + 1)


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

        return redirect('/admin/course/'.$post->CourseID);
//        return $post;
    }

    public static function getYoutubeVideoID($rawLink){
        preg_match_all('/watch[?]v=([^&]+)/', $rawLink, $matches, PREG_PATTERN_ORDER);
        return $matches[1][0];
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
            )
                return redirect('/auth/login');
            $token = md5(rand(), false);
        }

        $post = Posts::findOrNew($postID)->toArray();
        if (count($post) < 1){
            return view('errors.404');
        }
        $post = Posts::findOrNew($postID);
        $post->visited++;
        $post->update();
        $post = $post->toArray();
        $courseID = $post['CourseID'];
         if (auth() && (auth()->user())){
            $userID = auth()->user()->getAuthIdentifier();
            $tmp = Learning::where('UserID', '=', $userID)->where('CourseID', '=', $courseID)->get()->toArray();
            if (count($tmp) < 1){
                $learning = new Learning();
                $learning->UserID = $userID;
                $learning->CourseID = $courseID;
                $learning->save();
                $course = Courses::find($courseID);
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
         }

        $photo = $post['Photo'];
        $questions = Questions::where('PostID', '=', $postID)->get()->toArray();
        $bundle = array();
        
        $bundleAnswer = array();
		$maxscore = 0;
        foreach ($questions as $q){
            $answer = Answers::where('QuestionID', '=', $q['id'])->get()->toArray();
            $bundle += array($q['id'] => $answer);
            $bundleAnswer += [$q['id'] => AnswersController::getAnswer($q['id'])];
			if (count($answer) > 0) $maxscore++;
        }
        $Comments = Comments::all()->toArray();
        $result = array(
            'Comments' => json_encode($Comments),
            'Title' => $post['Title'],
            'Description' => $post['Description'],
            'PostID' => $postID,
            'Format' => $post['FormatID'],
            'Questions' => $questions,
            'Photo' => $photo,
            'Video' => $post['Video'],
            'Bundle' => $bundle,
            'BundleAnswers' => $bundleAnswer,
            'MaxScore' => $maxscore,
            'Token' => $token
        );
        $nextPost = Posts::where('CourseID', '=', $post['CourseID'])->where('id', '>=', $post['id'])->get()->toArray();
        $result += ['NextPost' => (count($nextPost) > 1) ? $nextPost[1]['id'] : Posts::where('CourseID', '=', $post['CourseID'])->first()->toArray()['id']];
        $previousPost = Posts::where('CourseID', '=', $post['CourseID'])->where('id', '<', $post['id'])->get()->toArray();
        $result += ['PreviousPost' => (count($previousPost) > 0) ? $previousPost[count($previousPost) - 1]['id'] : Posts::where('CourseID', '=', $post['CourseID'])->orderBy('created_at', 'desc')->first()->toArray()['id']];
        $newpost = array_merge($nextPost, $previousPost);
        $result += ['newpost' => $newpost];
        // dd($newpost);
        // return view('viewpost')->with(compact(['result', 'newpost']));
        return view('viewpost', $result);
    }

    public function viewNewestPosts(){
//        $posts = Posts::take(5)->skip(0)->get()->toArray();
        $Posts = Posts::orderBy('id', 'desc')->paginate(5);
        $newpost = Posts::orderBy('visited', 'dsc')->take(5)->get();
        // dd($newpost);
        return view('userindex')->with(compact(['Posts', 'newpost']));
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

    public function uploadAudio(){
//        return view('soundcloud');
        $sc_client_id = "a44837441b00a082d5674ed6457f91a5";
        $sc_secret = "5c3305ecb0320334718eb70f5bc13a3c";
        $sc_user = "48408491";
        $sc_pass = "donscngoc271";
//      create client object and set access token
        $client = new Services_Soundcloud($sc_client_id, $sc_secret);
//      login
        $client->credentialsFlow($sc_user, $sc_pass);
    }



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
        $post->CourseID = $data['CourseID'];
        $post->FormatID = $data['FormatID'];
        $post->Title = $data['Title'];
        if ($post->FormatID == '2'){ // Format Quizz Video
            $post->Video = PostsController::getYoutubeVideoID($data['Video']);
        }
        $post->Description = $data['Description'];
        $post->update();

        if ($post->FormatID == '1'){ // Format Quizz Plain Text
            // if admin upload new photo
            if ($request->file('Photo') != null) {
                $post = Posts::find($id);

                $file = $request->file('Photo');
                //        $file = Request::file('Photo');
                $post->Photo = 'Post_' . $data['CourseID'] . '_' . $post->id . "." . $file->getClientOriginalExtension();
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
        return redirect('/course/' . $courseid);
    }
}
