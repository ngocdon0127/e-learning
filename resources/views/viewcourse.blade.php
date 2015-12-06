<?php
/**
 * Created by PhpStorm.
 * User: NgocDon
 * Date: 12/6/2015
 * Time: 7:41 PM
 */?>

        <!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>

    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{$Title}}</div>
        <ul>
            @foreach ($posts as $key => $value)
                <li><a href="/post/{{$value['id']}}">{{$value['Question']}}</a></li>
            @endforeach
        </ul>
        <a href="/admin/addpost">Thêm câu hỏi</a>
    </div>
</div>
</body>
</html>

