@extends('layouts.master')
@section('head.title')
	Thêm khóa học
@endsection
@section('body.content')
<div class="container">
	<div class="col-sm-6 col-sm-offset-3">
		<h1>Thêm khóa học mới</h1>
	    {!! Form::open(['url' => '/admin/addcourse']) !!}
	    <div class="form-group">
	    {!! Form::label('Title', 'Title: ', ['class' => 'control-label'])!!}
	    {!! Form::text('Title') !!}
	    </div>
	    <div class="form-group">
	    {!! Form::label('Description', 'Description: ', ['class' => 'control-label']) !!}
	    {!! Form::text('Description') !!}
	    </div>
	    {!! Form::submit('Thêm', ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	</div>
</div>
@endsection
