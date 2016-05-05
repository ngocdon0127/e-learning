<?php

namespace App;
use App\User;

/**
* 
*/
class ConstsAndFuncs
{
	// Constants

	// user will have admin privilege when field 'admin' in table 'users' is equal or greater than this value
	const PERM_ADMIN = 1000;

	// user will have subadmin privilege when field 'admin' in table 'users' is equal or greater than this value
	const PERM_SUBADMIN = 990;

	// Website is free if this value is set to 0
	const IS_PAID = 1;


	public static $THUMBNAILS = [1 => 'Photo', 2 => 'Video'];

	// All the question formats
	public static $FORMATS = [
		1 => 'Trắc nghiệm',
		2 => 'Điền từ',
		3 => 'Sắp xếp',
		4 => 'Điền chữ cái',
		5 => 'Nối',
		6 => 'Kéo thả',
	];

	// number of questions in each post that crawler can see
	public static $FreeQuestionsForCrawler = 5;

	// Functions

	// return the value of field 'admin' in table users of user with corresponding id
	public static function permission_of($UserID){
		$user = User::find($USerID);
		if (count($user) < 1){
			return 0;
		}
		return $user['admin'];
	}

	// check if user is still VIP or not
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