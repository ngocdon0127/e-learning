<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Posts;

class PageController extends Controller
{
	public function index(){
		$post = Posts::orderBy('id', 'dsc')->take(3)->get();
		return view('mainpage')->with(compact('post'));
	}

	public function dic(){
		$data = Request::capture();

		// https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
		$response = \Unirest\Request::get(
			"https://glosbe.com/gapi/translate",
			null,
			array(
				'from' => 'eng',
				'dest' => 'eng',
				'format' => 'json',
				'phrase' => $data['word'],
				'pretty' => 'false',
				'tm' => 'true'
			)
		);
		$ms = json_decode($response->raw_body);
		// dd($ms);

		// Get Examples in $ms->examples. English in $ms->examples->first, Other Language in $ms->examples->second
		$examples = array();

		// Get English Meaning in $ms->meanings, other language in $ms->phrase
		$meanings = array();
		if (count($ms->examples) > 0){
			$i = 0;
			foreach ($ms->examples as $key => $value) {
				if (isset($value->first))
					$examples += array($key => $value->first);
				$i++;
				if ($i >= 5){
					break;
				}
			}
		}
		// dd($examples);	
		if (isset($ms->tuc)){
			if (count($ms->tuc) > 0)
			$ms = json_decode($response->raw_body)->tuc[0]->meanings;
			// dd($ms[0]->text);
			// dd($ms);
			$i = 0;
			foreach ($ms as $key => $value) {
				$meanings += array($key => $value->text);
				$i++;
				if ($i >= 5){
					break;
				}
			}
		}
		// dd($meanings);
		echo (json_encode(['meanings' => $meanings, 'examples' => $examples]));
		// dd(['examples' => $examples, 'meanings' => $meanings]);
	}
}
