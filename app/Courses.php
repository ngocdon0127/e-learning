<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    //
    public static function getColumn($column){
        $array = Courses::all();
        $result = array();
        foreach ($array as $item) {
            $result += array($item['id'] => $item[$column]);
        }
        return $result;
//        $array = array('ID'=>1, 'ID1'=>3, '2'=>5);
//        return $array;
    }
}
