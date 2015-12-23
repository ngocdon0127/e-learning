<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formats extends Model
{
    //
    public static function getColumn($column){
        $array = Formats::all();
        $result = array();
        foreach ($array as $item) {
            $result += array($item['id'] => $item[$column]);
        }
        if (count($result) > 0)
            return $result;
        else
            return array('-1' => 'Chưa có Format nào được tạo. Liên hệ Webmaster');
//        $array = array('ID'=>1, 'ID1'=>3, '2'=>5);
//        return $array;
    }
}
