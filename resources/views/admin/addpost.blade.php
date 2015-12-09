@extends('layouts.main')
@section('head.title')
ADD POST
@endsection
@section('body.content')
<div class="container">

        {!! Form::open(['url' => '/admin/addpost', 'class'=>'form-horizontal', 'files' => true]) !!}
            <div class="col-sm-offset-3">
                <h1>Thêm bài viết mới</h1>
            </div>
            <div class="form-group">
                {!! Form::label('CourseID', 'Course ID : ',['class' => 'col-md-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::select('CourseID', \App\Courses::getColumn('Title'),['class'=>'selectpicker']) !!}
                </div>
            </div>
   
             <div class="form-group">
                {!! Form::label('FormatID', 'Format ID : ',['class' => 'col-md-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('FormatID','',['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Question','Question : ',['class' => 'col-md-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('Question','',['class'=>'form-control']) !!}
                </div>
            </div>
             <div class="form-group">
                {!! Form::label('Photo', 'Photo : ',['class' => 'col-md-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::file('Photo','',['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Description', 'Description : ',['class' => 'col-md-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('Description','',['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-offset-3 col-sm-10">
                {!! Form::submit('Thêm',['class' => 'btn btn-default']) !!}
            </div>
        {!! Form::close() !!}
</div>

@endsection