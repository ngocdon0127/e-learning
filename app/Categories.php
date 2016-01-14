<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
    public static function getColumn($column){
        $array = Categories::all();
        $result = array();
        foreach ($array as $item) {
            $result += array($item['id'] => $item[$column]);
        }
        if (count($result) > 0)
            return $result;
        else
            return array('-1' => 'Chưa có Category nào được tạo. Liên hệ Webmaster');
    }
}
