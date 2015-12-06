<?php
/**
 * Created by PhpStorm.
 * User: NgocDon
 * Date: 12/7/2015
 * Time: 1:56 AM
 */?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form trong Laravel 5</title>
</head>
<body>
<ul>
    @foreach(\App\Answers::where('PostID', '=', $PostID)->get()->toArray() as $answer)
        <li>{{$answer['Detail']}}
        @if ($answer['Logical'] != 0)
            <span>Đúng</span>
        @endif
        </li>
    @endforeach
</ul>
<h1>Thêm câu trả lời mới</h1>
{!! Form::open(['url' => '/admin/addanswer/'.'{{PostID}}']) !!}
{!! Form::label('Detail', 'Câu trả lời: ') !!}
{!! Form::text('Detail') !!}
{!! Form::checkbox('Logical') !!}
<input type="text" value="{{$PostID}}" style="display: none" readonly name="PostID" />
{!! Form::submit('Thêm') !!}
{!! Form::close() !!}
</body>
</html>
