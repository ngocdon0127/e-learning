@extends('layouts.main')

 @section('head.title')
 ADD COURSE
 @endsection

 @section('body.content')
<!--   <form action="<?php Asset('user/info');?>" method="post" >
	<input type="text" name="tit"/>
	<input type="text" name="des"/>
	<input type="submit">
</form> -->
 	<div class="col-sm-offset-3 col-xs-offset-3 col-sm-6 col-xs-6">
			<!-- <div class="col-sm-offset-3 col-xs-offset-3 col-sm-6"> -->
			<!-- <div> -->
			<h1 class="title">Thêm khóa học mới</h1>
					    {!! Form::open(['url' => '/admin/addcourse','role'=>'form']) !!}
				
					    <div class="form-group">
				            {!! Form::label('Title', 'Title : ',['class' => 'control-label']) !!}
				            <!-- <div class="col-sm-9 col-xs-9"> -->
				                {!! Form::text('Title','',['class'=>'form-control']) !!}
				            <!-- </div> -->
				        </div>
				        <div class="form-group">
				            {!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
				            <!-- <div class="col-sm-9 col-xs-9"> -->
				                {!! Form::text('Description','',['class'=>'form-control']) !!}
				            <!-- </div> -->
				        </div> 
				
					    	{!! Form::submit('Thêm',['class'=>'btn btn-info']) !!}
				
						 {!! Form::close() !!}
						 <!-- </div> -->
	</div>
 @endsection
