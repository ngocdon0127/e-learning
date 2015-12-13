@extends('layouts.main')

 @section('head.title')
 ADD COURSE
 @endsection

 @section('body.content')
 	<div class="container-fluid">
 		<!-- <div class="col-md-offset-3 col-md-6"> -->
 					<!-- <div class="col-sm-offset-3 col-xs-offset-3 col-sm-6"> -->
 					<!-- <div> -->
					<script type="text/javascript">
						var oldTitle;
						function submitForm(){
							var obj = new XMLHttpRequest();
							obj.onreadystatechange = function(){
								if ((obj.readyState == 4 ) && obj.status == 200){
									if (obj.responseText == 'notExist'){
										document.editCourseForm.submit();
									}
									else {
										if (oldTitle == ob('Title').value){
											document.editCourseForm.submit();
										}
										else
											ob('question_title_err').innerHTML = 'Khóa học đã tồn tại. Vui lòng chọn tên khác.';
									}
								}
							}
							obj.open('GET', '/ajax/checkcoursetitle/' + ob('Title').value, true);
			//                ob.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
							obj.send();
						}

						function ob(x){
							return document.getElementById(x);
						}

		</script>
 					<h1 class="title">Sửa thông tin khóa học</h1>
 							    {!! Form::model($course, ['method' => 'PUT', 'name' => 'editCourseForm', 'route' => ['course.update', $course['id']], 'role'=>'form']) !!}
 						
 							    <div class="form-group">
 						            {!! Form::label('Title', 'Title : ',['class' => 'control-label']) !!}
 						            <!-- <div class="col-sm-9 col-xs-9"> -->
 						                {!! Form::text('Title', null, ['class'=>'form-control']) !!}
									<script type="text/javascript">
										oldTitle = ob('Title').value;
									</script>
									<span id="question_title_err"></span>
 						            <!-- </div> -->
 						        </div>
 						        <div class="form-group">
 						            {!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
 						            <!-- <div class="col-sm-9 col-xs-9"> -->
 						                {!! Form::text('Description', null, ['class'=>'form-control']) !!}
 						            <!-- </div> -->
 						        </div> 
 						
 							    	{!! Form::button('Cập nhật',['class'=>'btn btn-info', 'onClick' => 'submitForm()']) !!}
 						
 								 {!! Form::close() !!}
 								 <!-- </div> -->
 			<!-- </div> -->
 	</div>
 @endsection
