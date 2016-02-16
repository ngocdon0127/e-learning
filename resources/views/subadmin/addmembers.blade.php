@extends('layouts.main')

 @section('head.title')
 ADD MEMBERS
 @endsection

 @section('body.content')
	{!!Form::open([
		'route'		=> ['subadmin.savemembers', $id],
		'method'	=> 'POST',
		'role'		=> 'form'
		])
	!!}
	<h2 class = "title">Thêm thành viên: </h2>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@if(Session::get('error') != NULL)
	<p class="alert alert-danger"> {{Session::get('error')}}</p>
	@endif
	{!!Form::label('email', 'Email User: ')!!}
	{!!Form::text('email','',['class'	=> 'form-control', 'id'	=> 'email', 'placeholder'	=> 'Nhập vào địa chỉ email', 'type'	=> 'email'])	!!}

	
	<button type="submit" class="btn btn-info">Add</button>
	<a class="btn btn-info" href="{{route('subadmin.viewclass',$id)}}">Quay lại</a>
	{!!Form::close()!!}
 @endsection
