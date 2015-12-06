@extends('layouts.master')
@section('head.title')
    Them bai viet moi
@endsection
@section('body.content')
<<div class="container">
    <<div class="col-sm-6 col-sm-offset-3">
        <h1>Thêm bài viết mới</h1>
        {!! Form::open(['url' => '/admin/addpost']) !!}
            <div class="form-group">
            {!! Form::label('FormatID', 'FormatID: ') !!}
            {!! Form::text('FormatID') !!}
            {!! Form::select('CourseID', \App\Courses::getColumn('Title')) !!}
             {{--  {!! Form::select('CourseTitle', array(1=>1, 3=>4)) !!};--}}
            </div>
            <div class="form-group">
            {!! Form::label('Question', 'Question: ') !!}
            {!! Form::text('Question') !!}
            </div>
            <div class="form-group">
            {!! Form::label('Photo', 'Photo: ') !!}
            {!! Form::text('Photo') !!}
            </div>
            <div class="form-group">
            {!! Form::label('Description', 'Description: ') !!}
            {!! Form::text('Description') !!}
            </div>
            {!! Form::submit('Thêm', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
