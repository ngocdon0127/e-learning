@extends('layouts.main')
@section('head.title')
ADD QUESTION
@endsection
@section('head.css')
<style>
	.control-label{
		text-align: left !important;
	}
	textarea{
		height: 3em;
	}
</style>
@endsection
@section('body.content')
	<div class="container-fluid">
		<h1 class="col-md-offset-3 title">Thêm câu hỏi mới</h1>

		{!! Form::open(['name' => 'addQuestionForm', 'route' => ['admin.addquestion', $PostID], 'class'=>'form-horizontal', 'files' => true]) !!}

		<div class="form-group">
			{!! Form::label('Question','Question : ',['class' => 'control-label']) !!}
			{!! Form::text('Question','',['class'=>'form-control']) !!}
		</div>
		<div class="form-group" style="display: none">
			{!! Form::label('FormatID','FormatID : ',['class' => 'control-label']) !!}
			{!! Form::text('FormatID', $_GET['FormatID'], ['class'=>'form-control']) !!}
		</div>
		<div class="form-group" style="display: none;">
			{!! Form::label('ThumbnailID', 'Thumbnail : ',['class' => 'control-label']) !!}
			{!! Form::select('ThumbnailID', App\ConstsAndFuncs::$THUMBNAILS, '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white";', 'style' => 'display: none;']) !!}
		</div>
		<div class="form-group" id="divPhoto">
			{!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
			{!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
			{!! Form::text('Description','',['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Answer', 'Answer : ',['class' => 'control-label']) !!}
			{!! Form::text('Answer','',['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('', '',['class' => 'control-label']) !!}
			{!! Form::label('Error', '',['id' => 'error', 'class' => 'control-label', 'style' => 'display: none;']) !!}
		</div>
		<button class="btn btn-primary" onclick="submitForm()" type="button" id="btnAddQuestion">Thêm</button>
		<div class="col-sm-offset-3 col-sm-10">
		<script type="text/javascript">
			function ob(x){
				return document.getElementById(x);
			}

			function displayError(x){
				$('#error').fadeIn();
				ob('error').innerHTML = x;
			}
			function submitForm(){
				switch (ob('ThumbnailID').value){
					case '1':  // Photo
						var acceptedType = ['image/jpeg', 'image/png', 'image/gif'];
						//                        console.log('clicked');
						var photo = ob('Photo');
						if (photo.files.length <= 0){
							submitViaAJAX(null);
							return;
						}
						var type = photo.files[0].type;
						var check = false;
						for(i = 0; i < acceptedType.length; i++){
							if (type == acceptedType[i]){
								check = true;
								break;
							}
						}
						if (!check){
							displayError('Chỉ chọn file ảnh.');
						}
						else{
							if ('size' in photo.files[0]){
								console.log(photo.files[0].size);
							}
							else{
								console.log('ko co size');
							}
							if (photo.files[0].size > 5 * 1024 * 1024){
								console.log('size qua lon');
								ob('error').style.display = 'block';
								displayError('Chỉ chọn file có kích thước tối đa 5 MB.');
								return;
							}
							ob('error').style.display = 'none';
							submitViaAJAX(photo.files[0]);

						}
						break;
					case '2': // Video
						if (ob('Video').value.length > 0){
							var linkVideo = ob('Video').value;
							if ((linkVideo.indexOf('watch?v=') < 0) && (linkVideo.indexOf('youtu.be/') < 0)){
								displayError('Link video Youtube không đúng.');
								return;
							}
							$('#error').fadeOut();
							submitViaAJAX(null);
						}
						else{
							$('#error').fadeOut();
							submitViaAJAX(null);
						}
						break;
					}
			}

			function submitViaAJAX(p){
				// check if admin has chosen right answer or not
				ob('btnAddQuestion').disabled = true;
				var fd = new FormData();
				fd.append('Question', ob('Question').value);
				fd.append('ThumbnailID', '1');
				fd.append('Description', ob('Description').value);
				fd.append('Photo', p);
				fd.append('FormatID', '3');
				fd.append('Answer', ob('Answer').value);
				$.ajax({
					url: '/admin/addquestion/' + {!! $PostID !!},
					type: "POST",
					contentType: false,
					beforeSend: function (xhr) {
						var token = $('meta[name="_token"]').attr('content');

						if (token) {
							return xhr.setRequestHeader('X-CSRF-TOKEN', token);
						}
					},
					mimeType: 'multipart/form-data',
					data: fd,
					processData: false,
					success: function (data) {
						console.log(data);
						// return;
						var qID = data;
						window.location = '/question/' + qID;
						// console.log(qID);
						return;
					},
					error: function () {
						console.log("error!!!!");
					}
				}); //end of ajax
			}
		</script>
		</div>
			{!! Form::close() !!}
</div>



@endsection