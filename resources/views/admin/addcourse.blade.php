@extends('layouts.main')

@section('head.title')
ADD COURSE
@endsection

@section('body.content')
	<div class="container-fluid">
		<script type="text/javascript">
			function submitForm(){
				var obj = new XMLHttpRequest();
				obj.onreadystatechange = function(){
					if ((obj.readyState == 4 ) && obj.status == 200){
						if (obj.responseText == 'notExist'){
							document.addCourseForm.submit();
						}
						else {
							ob('question_title_err').innerHTML = 'Khóa học đã tồn tại. Vui lòng chọn tên khác.';
						}
					}
				}
				obj.open('GET', '/ajax/checkcoursetitle/' + ob('Title').value, true);
				obj.send();
			}

			function ob(x){
				return document.getElementById(x);
			}
		</script>
		<h1 class="title">Thêm khóa học mới</h1>
		{!! Form::open(['name' => 'addCourseForm', 'route' => ['admin.addcourse'],'role'=>'form']) !!}
			<div class="form-group">
				{!! Form::label('Hidden', 'Khóa học ẩn? ', ['class' => 'control-label']) !!}
				{!! Form::checkbox('Hidden', '') !!}
			</div>
			<div class="form-group">
				{!! Form::label('CategoryID', 'Category : ',['class' => 'control-label']) !!}
				{!! Form::select('CategoryID', \App\Categories::getColumn('Category'), ['class'=>'form-control', 'onclick' => 'this.style.background = "white"']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('Title', 'Title : ',['class' => 'control-label']) !!}
					{!! Form::text('Title','',['class'=>'form-control']) !!}
				<span id="question_title_err"></span>
			</div>
			<div class="form-group">
				{!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
					{!! Form::text('Description','',['class'=>'form-control']) !!}
			</div> 

			{!! Form::button('Thêm',['class'=>'btn btn-primary', 'onClick' => 'submitForm()']) !!}

		{!! Form::close() !!}
	</div>
@endsection
