<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Licenses;
use App\Paids;
use App\ConstsAndFuncs;

class PaidsController extends Controller
{
	public function buy(){
		return view('buy');
	}

	public function getActive(){
		if (auth() && auth()->user()){
			return view('active');
		}
		return redirect('/auth/login')->with('redirectPath', route('user.getactive'));
	}

	public function postActive(Request $request){
		$data = $request->all();
		$UserID = $data['UserID'];
		$user = User::find($UserID);
		if (count($user) < 1){
			return view('active')->with('result', 'User không tồn tại');
		}
		$key = $data['key'];
		$li = Licenses::where('key', 'LIKE', $key)->where('Sold', '=', 1)->where('Activated', '=', 0)->get()->last();
		if (count($li) < 1){
			return view('active')->with('result', 'Mã số không đúng hoặc đã được sử dụng.');
		}
		$li->Activated = 1;
		$li->update();
		$paid = new Paids();
		$paid->UserID = $UserID;
		$paid->LicenseID = $li->id;
		$paid->save();
		$user->vip++;

		if (ConstsAndFuncs::is_vip($UserID) == false){
			$oldExpire = new \DateTime();
		}
		else{
			// Go crazy with this. Cannot figure out why $user->expire_at returns a string while $user->created_at returns an \DateTime object.
			$oldExpire = new \DateTime($user->expire_at);
		}
		$duration = new \DateInterval('PT' . ($li->Duration) . 'H');
		$oldExpire->add($duration);
		$user->expire_at = $oldExpire;
		$user->update();
		$new_expire = $oldExpire;
		$result = 'Kích hoạt thành công. Thời hạn sử dụng VIP của bạn đến ' . ($new_expire->format("Y-m-d H:i:s"));
		return view('active')->with('result', $result);
	}
}
