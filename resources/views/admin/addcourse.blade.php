<?php
/**
 * Created by PhpStorm.
 * User: NgocDon
 * Date: 12/6/2015
 * Time: 6:24 PM
 */?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form trong Laravel 5</title>
</head>
<body>
<h1>Them Bai Viet Moi</h1>
    {!! Form::open(['url' => '/admin/addcourse']) !!}
    {!! Form::label('Title', 'Title: ') !!}
    {!! Form::text('Title') !!}
    {!! Form::label('Description', 'Description: ') !!}
    {!! Form::text('Description') !!}
    {!! Form::submit('Thêm') !!}
    {!! Form::close() !!}
</body>
</html>
