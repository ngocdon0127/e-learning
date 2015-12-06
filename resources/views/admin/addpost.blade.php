<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form trong Laravel 5</title>
</head>
<body>
    <h1>Them Bai Viet Moi</h1>
    {!! Form::open(['url' => '/admin/addpost']) !!}
        {!! Form::select('CourseID', \App\Courses::getColumn('Title')) !!}
{{--        {!! Form::select('CourseTitle', array(1=>1, 3=>4)) !!};--}}
        {!! Form::label('FormatID', 'FormatID: ') !!}
        {!! Form::text('FormatID') !!}
        {!! Form::label('Question', 'Question: ') !!}
        {!! Form::text('Question') !!}
        {!! Form::label('Photo', 'Photo: ') !!}
        {!! Form::text('Photo') !!}
        {!! Form::label('Description', 'Description: ') !!}
        {!! Form::text('Description') !!}
        {!! Form::submit('Thêm') !!}
    {!! Form::close() !!}
</body>
</html>