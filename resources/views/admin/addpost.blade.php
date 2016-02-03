@extends('layouts.main')
@section('head.title')
	ADD POST
@endsection
@section('body.content')
			<div class="container-fluid"> 
				<h1 class="title">Thêm bài viết mới</h1>
				{!! Form::open(['name' => 'addPostForm', 'url' => '/admin/addpost', 'role'=>'form', 'files' => true]) !!}
				<div class="form-group">
					{!! Form::label('CourseID', 'Course ID : ',['class' => 'control-label']) !!}
					{!! Form::select('CourseID', \App\Courses::getColumn('Title'), '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white"']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('FormatID', 'Format : ',['class' => 'control-label']) !!}
					{!! Form::select('FormatID', \App\Formats::getColumn('FormatTitle'), '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white"']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('ThumbnailID', 'Thumbnail : ',['class' => 'control-label']) !!}
					{!! Form::select('ThumbnailID',\App\Thumbnails::getColumn('Title'), '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white";', 'onchange' => 'configForm()']) !!}
				</div>
				<div class="form-group" id="divPhoto">
					{!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
					{!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif','type'=>'file','class'=>'file']) !!}
				</div>
				<div id="divVideo">
					{!! Form::label('Video', 'Link Youtube : ',['class' => 'control-label']) !!}
					{!! Form::text('Video', '', ['class'=>'form-control', 'placeholder'=>'Paste link youtube hoặc Đăng nhập để upload video mới.']) !!}
					<span id="signinButton" class="pre-sign-in">
						<!-- IMPORTANT: Replace the value of the <code>data-clientid</code>
								 attribute in the following tag with your project's client ID. -->
						<span
							class="g-signin"
							data-callback="signinCallback"
							data-clientid="872662012321-2a300brmje1lhj09chjpcjn29pb6h2mt.apps.googleusercontent.com"
							data-cookiepolicy="single_host_origin"
							data-scope="https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube">
						</span>
					</span>

					<div class="post-sign-in">
						<div>
							<img id="channel-thumbnail" style="display: none;">
							<label for="channel-name" class="control-label">Channel: </label>
							<span id="channel-name" class="form-control"></span>
						</div>

						<div>
							<label for="titleOfVideo" class="control-label">Title for this video:</label>
							<input id="titleOfVideo" class="form-control" type="text" placeholder="Nhập tiêu đề video">
						</div>
						<div>
							<label for="descriptionOfVideo" class="control-label">Description for this video:</label>
							<textarea id="descriptionOfVideo" class="form-control"></textarea>
						</div>
						<div style="display: none;">
							<label for="privacy-status">Privacy Status:</label>
							<select id="privacy-status">
								<option>public</option>
								<option>unlisted</option>
								<option>private</option>
							</select>
						</div>

						<div>
							<input input type="file" id="file" class="button" accept="video/*">
							<button id="button">Upload Video</button>
						</div>
						<div class="during-upload">
							<p><span id="percent-transferred"></span>% done <br />(<span id="bytes-transferred"></span>/<span id="total-bytes"></span> MB)</p>
							<progress id="upload-progress" max="1" value="0"></progress>
						</div>

						<div class="post-upload">
							<p>Uploaded video with id <span id="video-id"></span>. Polling for status...</p>
							<ul id="post-upload-status"></ul>
							<div id="player"></div>
						</div>
					</div>

					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
					<script src="//apis.google.com/js/client:plusone.js"></script>
					<script src="/js/cors_upload.js"></script>
					<script src="/js/upload_video.js"></script>
				</div>
				<div class="form-group">
					{!! Form::label('Title','Title : ',['class' => 'control-label']) !!}
					{!! Form::text('Title','',['class'=>'form-control']) !!}
				</div>
				 <div class="form-group">
					{!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
					{!! Form::text('Description','',['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('Hashtag', 'Hashtag : (mỗi tag cách nhau 1 dấu cách.) (ex: #grammar #PresentSimple)',['class' => 'control-label']) !!}
					{!! Form::text('Hashtag','',['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('', '',['class' => 'control-label']) !!}
					{!! Form::label('Error', '',['id' => 'error', 'class' => 'control-label', 'style' => 'display: none;']) !!}
				</div>
				<script type="text/javascript">
					function ob(x){
						return document.getElementById(x);
					}

					function configForm(){
						switch (ob('ThumbnailID').value){
							case '1':
								ob('divPhoto').style.display = 'block';
								ob('divVideo').style.display = 'none';
								break;
							case '2':
								ob('divPhoto').style.display = 'none';
								ob('divVideo').style.display = 'block';
								break;
							default:
								console.log('dmm');
						}
					}

					configForm();

					function displayError(x){
						ob('error').style.display = 'block';
						ob('error').innerHTML = x;
					}
					function submitForm(){
						var courseob = ob('CourseID');
						if (courseob.value <= 0){
							courseob.style.background = '#ff5050';
							return;
						}
						var formatob = ob('ThumbnailID');
						if (formatob.value <= 0){
							formatob.style.background = '#ff5050';
							return;
						}

						switch (formatob.value){
							case '1': // Plain Text
								var acceptedType = ['image/jpeg', 'image/png', 'image/gif'];
								var photo = ob('Photo');
								if (photo.files.length <= 0){
									displayError('Chưa chọn file');
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
								document.addPostForm.submit();
								}
								break;
							case '2': // Video
								if (ob('Video').value.length < 1){
									displayError('Chưa nhập link video.');
									return;
								}
								else{
									ob('error').style.display = 'none';
									var linkVideo = ob('Video').value;
									if ((linkVideo.indexOf('watch?v=') < 0) && (linkVideo.indexOf('youtu.be/') < 0)){
										displayError('Link video Youtube không đúng.');
										return;
									}
									$('#error').fadeIn();
									document.addPostForm.submit();

								}
								break;
							default:
								console.log('dmm');
						}
			 
					}
				</script>
				{!! Form::button('Thêm',['class' => 'btn btn-primary', 'onClick' => 'submitForm()']) !!}
			{!! Form::close() !!}
	</div>

@endsection