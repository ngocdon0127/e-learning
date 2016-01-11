<?php

namespace App\Http\Controllers;

use App\Hashtags;
use App\Tags;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public static function tag($rawHashtag, $postID){
        preg_match_all('/#([a-zA-Z0-9]*)/', strtoupper($rawHashtag), $matches, PREG_PATTERN_ORDER);
        $arrayOfHT = $matches[1];
        foreach ($arrayOfHT as $aht){
            $hashtag = Hashtags::where('Hashtag', 'LIKE', $aht)->get()->first();
            if (count($hashtag) < 1){
                $hashtag = new Hashtags();
                $hashtag->Hashtag = $aht;
                $hashtag->save();
            }
            $hashtag = Hashtags::where('Hashtag', 'LIKE', $aht)->get()->first();
            $tag = new Tags();
            $tag->HashtagID = $hashtag->id;
            $tag->PostID = $postID;
            $tag->save();
        }
    }

    public static function removeTag($postID){
        Tags::where('PostID', '=', $postID)->delete();
    }
}
