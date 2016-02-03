<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
	public static function getFilledQuestion($rawQuestion){
		$s = '[space]';
		$len = strlen($s);
		$q = $rawQuestion;
		$subP = array();
		$i = 0;
		while (strlen($q) > 0){
			$pos = strpos($q, $s);
			if ($pos){
				$subP = array_merge($subP, [substr($q, 0, $pos)]);
				$q = substr($q, $pos + $len);
			}
			else{
				$subP = array_merge($subP, [$q]);
				$q = "";
			}
		}
		return $subP;
	}
}
