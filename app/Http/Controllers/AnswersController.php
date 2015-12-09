<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswersController extends Controller
{

    public function addAnswer($postID){
        $post = Posts::findOrNew($postID)->toArray();
        $photo = $post['Photo'];
        $answers = Answers::where('PostID', '=', $postID)->get()->toArray();
        $result = array('PostID' => $postID, 'Answers' => $answers, 'Photo' => $photo);
        return view('admin.addanswer')->with(["PostID" => $postID, 'Photo' => $photo, 'Answers' => $answers]);
    }

    public function saveAnswer(Request $request){
        $data = $request->all();
        $answer = new Answers();
        $answer->PostID = $data['PostID'];
        if (array_key_exists('Logical', $data))
            $answer->Logical = $data['Logical'];
        $answer->Detail = $data['Detail'];
        $answer->toArray();
        $answer->save();
        return redirect('/post/'.$answer->PostID);
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
