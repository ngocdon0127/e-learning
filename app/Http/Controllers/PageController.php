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

	public function bing(){

		// With Bing API, $body in Unirest must be a string, mustn't use array.

		// $response = \Unirest\Request::post(
		// 	'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13',
		// 	array(
		// 		'Content-Type' => 'application/x-www-form-urlencoded'
		// 	),
		// 	'client_id=' . urlencode('evangelsenglish') .
		// 	'&client_secret=' . urlencode('WCmJXOxBdATRAXsmrlTb0Cuq1zhjM+e+f5Faw4QQcZQ=') .
		// 	'&scope=' . "http://api.microsofttranslator.com" .
		// 	'&grant_type=' . 'client_credentials'
		// );
		// dd(json_decode(($response->raw_body)));

		// Using Curl
		$ClientID="evangelsenglish";
		$ClientSecret="WCmJXOxBdATRAXsmrlTb0Cuq1zhjM+e+f5Faw4QQcZQ=";

		$ClientSecret = urlencode ($ClientSecret);
		$ClientID = urlencode($ClientID);

		// Get a 10-minute access token for Microsoft Translator API.
		$url = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13";
		$postParams = "grant_type=client_credentials&client_id=$ClientID&client_secret=$ClientSecret&scope=http://api.microsofttranslator.com";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
		$rsp = curl_exec($ch);
		// if (!curl_close($ch))
			// dd(json_decode($rsp)->access_token);
		curl_close($ch);

		// $ch = curl_init("http://api.microsofttranslator.com/v2/Http.svc/Translate?text=festival&from=en&to=en");
		// curl_setopt($ch, , value)
		$data = Request::capture();
		$response = \Unirest\Request::get(
			"http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" . $data['text'] . "&from=en&to=vi",
			['Authorization' => 'Bearer ' . json_decode($rsp)->access_token],
			null
		);
		dd($response);
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
