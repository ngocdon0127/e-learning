@extends('layouts.main')

 @section('head.title')
 ADD CLASS
 @endsection

 @section('body.content')
	<h2 class="title">Thêm lớp học mới</h2>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Something were wrong:</strong></br>
			<ul>
				@foreach($errors->all() as $error)	 
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	{!! Form::open([
		'method' => 'POST',
		'route' => 'subadmin.saveclass',
		'role'=>'form'
		])
	!!}

	{!!Form::label('name', 'Class name:')!!}
	{!!Form::text('name','',['class'=>'form-control', 'id' => 'name', 'placeholder' => 'Nhập tên lớp học']) !!}

	{!!Form::label('address', 'Address class:')!!}
	{!!Form::text('address','',['class'=>'form-control', 'id' => 'address', 'placeholder' => 'Nhập địa chỉ của lớp học']) !!}
	
	<button type="submit" class="btn btn-primary">Save class</button>
	{!! Form::close() !!}
 @endsection
