<?php
/**
 * Created by PhpStorm.
 * User: NgocDon
 * Date: 12/7/2015
 * Time: 1:09 AM
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
        <ul>
            @foreach ($allcourse as $course)
                <a href="/course/{{$course['id']}}">{{$course['Title']}}</a>
            @endforeach
            <a href="/admin/addcourse">Add Course</a>
        </ul>
    </div>
</div>
</body>
</html>
