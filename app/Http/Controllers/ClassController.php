<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes;
use App\StudentsList;
use App\User;
use App\Http\Requests\ClassFormRequest;
use App\Http\Requests\MemberFormRequest;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all();
        // dd($classes);
        return view('/subadmin/listclass')->with(compact('classes'));
    }

   public function viewclass($id){

    $stdList = StudentsList::join('users', 'studentslist.UserID','=','users.id')->join('classes', 'studentslist.ClassID', '=','classes.id')->where('ClassID','=',$id)->groupby('studentslist.UserID')->get();
    $count = $stdList->count();
    // dd($stdList);
    return view('/subadmin/liststudents')->with(compact(['stdList', 'id','count']));
   }

   public function addclass(){
    return view('/subadmin/addclass');
   }

   public function saveclass(ClassFormRequest $request){

    $name = $request->input('name');
    $address = $request->input('address');

    Classes::create([
        'classname'          => $name,
        'classaddress'       => $address,
        'subAdminID'    =>  auth()->user()->id
        ]);
    return redirect()->route('subadmin.view');
   }

   public function addmembers($id){
    return view('/subadmin/addmembers')->with(compact('id'));
   }

   public function savemembers(MemberFormRequest $request, $classID){
        $email = $request->input('email');
        // dd($classID);
        // dd($email);
        $member = User::where('email','=', $email)->get();
        // dd($member);
        if ($member->count()) {
            $find = StudentsList::where('UserID','=',$member[0]->id)->where('ClassID','=',$classID)->count();
            if ($find) {
                return redirect(route('subadmin.addmembers'))->with('error', 'User vừa nhập đã là thành viên của lớp');
            }
            else {
                StudentsList::create([
                'ClassID'   => $classID,
                'UserID'    => $member[0]->id
                ]);
                return redirect(route('subadmin.addmembers'))->with('error','Thêm thành công');
            }
        } else { 
          //echo 'User vừa nhập không tồn tại';
          return redirect(route('subadmin.addmembers'))->with('error', 'User vừa nhập không tồn tại!');
        }
   }

   public function deleteclass($id){
        Classes::where('id','=',$id)->delete();
        StudentsList::where('ClassID','=',$id)->delete();
        return redirect()->route('subadmin.view');
   }
}
