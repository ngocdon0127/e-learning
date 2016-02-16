<?php

namespace App;
use App\User;

class ConstsAndFuncs
{
	public static $FreeQuestionsForCrawler = 5;
	public static function is_vip($user_id){
		$user = User::find($user_id);
		if (count($user) < 1){
			return false;
		}
		if ($user->vip < 1){
			return false;
		}
		// Go crazy with this. Cannot figure out why $user->expire_at returns a string while $user->created_at returns an \DateTime object.
		$oldExpire = new \DateTime($user->expire_at);
		$now = new \DateTime();
		if (($now->getTimestamp() - $oldExpire->getTimestamp()) > 0){
			// VIP was expired before.
			return false;
		}
		return true;
	}
}
