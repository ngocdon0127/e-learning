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
 	<div class="container">
 		<div class="col-md-offset-3">
			<h1>Thêm khóa học mới</h1>
		</div>
	    {!! Form::open(['url' => '/admin/addcourse','class'=>'form-horizontal']) !!}

	    <div class="form-group">
            {!! Form::label('Title', 'Title : ',['class' => 'col-md-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('Title','',['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('Description', 'Description : ',['class' => 'col-md-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('Description','',['class'=>'form-control']) !!}
            </div>
        </div>

	    <div class="col-sm-offset-3 col-sm-10">
	    	{!! Form::submit('Thêm',['class'=>'btn btn-default']) !!}
	    </div>

		 {!! Form::close() !!}
	</div>
 @endsection
