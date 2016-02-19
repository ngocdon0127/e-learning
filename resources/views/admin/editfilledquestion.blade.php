@extends('layouts.main')
@section('head.title')
EDIT QUESTION
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
		<h1 class="col-md-offset-3 title">Chỉnh sửa câu hỏi</h1>

		{!! Form::model($Question, ['name' => 'editQuestionForm', 'method' => 'POST', 'route' => ['question.update', $Question['id']], 'class'=>'form-horizontal', 'role' => 'form', 'files' => true]) !!}
			
		<div class="form-group">
			{!! Form::label('ThumbnailID', 'Thumbnail : ',['class' => 'control-label']) !!}
			{!! Form::select('ThumbnailID', App\ConstsAndFuncs::$THUMBNAILS, '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white";', 'onchange' => 'configForm()']) !!}
		</div>
		<div class="form-group" id="divPhoto">
			{!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
			{!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif']) !!}
		</div>
		<div class="form-group" id="divVideo">
			{!! Form::label('Video', 'Link Youtube : ',['class' => 'control-label']) !!}
			{!! Form::text('Video', null, ['class'=>'form-control', 'placeholder'=>'Paste link youtube hoặc Đăng nhập để upload video mới.']) !!}
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
			{!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
			{!! Form::text('Description', null,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Question','Question : ',['class' => 'control-label']) !!}
			<textarea id="Question" name="Question" class="form-control"></textarea>
			<script>
			ob('Question').innerHTML = ob('Question').value = {!! json_encode($Question['Question']) !!};
				function getNumOfSpaces(){
					var nos = 0;
					nos = 0;
					var te = ob('Question');
					var len = te.value.length;
					var i = 0;
					while (i < len){
						var r = te.value.indexOf('[space]', i);
						if (r < 0){
							break;
						}
						nos++;
						i = r + 7;
					}
					console.log(nos);
					return nos;
				}
				function addSpace() {
					var te = ob('Question');
					var beforeText = te.value.substring(0, te.selectionStart);
					var afterText = te.value.substring(te.selectionEnd);
					te.value = te.innerHTML = beforeText + ' [space] ' + afterText;
					te.focus();
					add();
					updateID();
				}
			</script>
			<input type="button" class="btn btn-primary" value="Thêm chỗ trống" onclick="addSpace()" />
		</div>
	
		<div class="form-group">
			{!! Form::label('', '',['class' => 'control-label']) !!}
			{!! Form::label('Error', '',['id' => 'error', 'class' => 'control-label', 'style' => 'display: none;']) !!}
		</div>
		<div class="col-sm-offset-3 col-sm-10">
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

			ob('ThumbnailID').value = {{$Question['ThumbnailID']}};
			configForm();
			ob('Video').value = "https://www.youtube.com/watch?v=" + "{{ $Question['Video'] }}";

			function displayError(x){
				$('#error').fadeIn();
				ob('error').innerHTML = x;
			}
			function submitForm(){
				switch (ob('ThumbnailID').value){
					case '1':  // Photo
						var acceptedType = ['image/jpeg', 'image/png', 'image/gif'];
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
				updateID();
				prepareAnswer();
				if (count != getNumOfSpaces()){
					alert('Số khoảng trắng và số dòng đáp án chưa bằng nhau');
					return;
				}
				ob('btnAddQuestion').disabled = true;
				var fd = new FormData();
				fd.append('Question', ob('Question').value);
				fd.append('ThumbnailID', ob('ThumbnailID').value);
				fd.append('Description', ob('Description').value);
				fd.append('Video', ob('Video').value);
				fd.append('Photo', p);
				console.log(document.editQuestionForm.action);
				$.ajax({
					url: "/admin/editquestion/{{$Question['id']}}",
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
							var qID = data;
							if (count < 1){
									window.location = '/question/' + qID;
									return;
							}
							submitFormSpaces();
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
<div class="container-fluid">
		{!! Form::open(['name' => 'editSpaceForm', 'route' => ['admin.editspace', $Question['id']],'class'=>'form-group']) !!}
		<div class="form-group">
			{!! Form::label('Detail', 'Các đáp án cho từng ô trống, cách nhau bởi dấu chấm phẩy, đáp án đúng viết đầu tiên, đáp án sai viết sau: ',['class'=>'control-label']) !!}
			<script type="text/javascript">
				var count = 0;
				var minAnswer = getNumOfSpaces({!! json_encode($Question['Question']) !!});

				function ob(x){
					return document.getElementById(x);
				}

				function xoa(x){
					if (count <= 1){
						return;
					}
					ob('answers').removeChild(ob(x));
					updateID();
					count--;
				}

				function updateID(){
					var answers = ob('answers');
					var childrens = answers.children;
					if (childrens == null){
							return;
					}
					ob('count').value = count = childrens.length - 1;
					// childrens[0] is <script> element
					// childrens[1->n] are <div> element
					for(var i = 1; i < childrens.length; i++){
						var div = childrens[i];
						div.id = 'divanswer' + i;

						// children[0] is textarea hold answer detail
						div.children[0].id = 'answer' + i;
						div.children[0].setAttribute('name', div.children[0].id);

						// children[2] is a reserved textarea
						div.children[2].id = 'ta_answer' + i;
//                            div.children[2].setAttribute('name', div.children[0].id);

						div.setAttribute('class','div_i');
						div.children[0].setAttribute('class','col-sm-12');

						// children[1] is a button which allow to delete answer i.
						div.children[1].setAttribute('class','children btn btn-danger');
						div.children[1].setAttribute('onclick', 'xoa("divanswer' + i + '")');

						// children[3] is a button allow to underline text
						// div.children[3].setAttribute('onclick', 'addTag("u", "' + i + '")');
						console.log('finish update ' + i);
					}
				}

				function addTag(tag, id){
					var tagOpen = "[u]";
					var tagClose = "[/u]";
					var textarea = ob('answer' + id);
					var oldText = textarea.value;
					var start = textarea.selectionStart;
					var end = textarea.selectionEnd;
					if (start == end){
						return;
					}
					var before = oldText.substring(0, start);
					var after = oldText.substring(end, oldText.length);
					var content = oldText.substring(start, end);
					console.log(content);
					if ((content.indexOf(tagOpen) != -1) && (content.indexOf(tagClose) != -1)){
						console.log('giet no');
						content = content.replace(tagOpen, "");
						content = content.replace(tagClose, "");
						textarea.value = before + content + after;
						textarea.setSelectionRange(start, start + content.length);
						textarea.focus();
					}
					else {
						var newText = before + tagOpen + content + tagClose + after;
						textarea.value = newText;
						textarea.setSelectionRange(start, end + tagClose.length + tagClose.length - 1);
						textarea.focus();
					}
				}

				function markAnswer(x){
					var pos = x.substring(x.indexOf('radio') + 5);
					resultQuestion = pos;
					ob('result').value = resultQuestion;
				}

				function add(){
					var curNOS = getNumOfSpaces();
					if (count >= curNOS){
						count = curNOS;
						return;
					}
					var e = document.createElement('textarea');
					e.id = 'specialID';
					e.setAttribute('class', 'col-sm-12');
					var divElement = document.createElement('div');
					divElement.id = "divanswer" + count;
					ob('answers').appendChild(divElement);
					divElement.appendChild(e);
					var btnDel = document.createElement('input');
					btnDel.value = 'Xóa';
					btnDel.type = 'button';
					btnDel.setAttribute('onClick','xoa("' + divElement.id + '")');
					divElement.appendChild(btnDel);
					var hiddenTextarea = document.createElement('textarea');
					hiddenTextarea.style.display = 'none';
					divElement.appendChild(hiddenTextarea);
					var uButton = document.createElement('input');
					// uButton.type = 'button';
					// uButton.setAttribute('value', 'Gạch chân');
					// uButton.setAttribute('class','btn btn-primary');
					// divElement.appendChild(uButton);
					count++;
				}

				function prepareAnswer(){
					for(var i = 1; i <= count; i++){
						var ra = ob('answer' + i).value.trim();
						if (ra.charAt(ra.length - 1) != ';')
							ra += ';';
						ob('ta_answer' + i).innerHTML = ob('ta_answer' + i).value = ra;
						ob('answer' + i).innerHTML = ob('answer' + i).value = ra;
					}
				}

				function submitFormSpaces(){
					updateID();
					prepareAnswer();
					document.editSpaceForm.submit();
				}
			</script>
			<div class="" id="div_answer">
				<input type="text" id="count" name="numAnswer" style="display: none;"/>
				<div id="answers">
					<script type="text/javascript">
						for(var i = 0; i < minAnswer; i++){
							add();
						}
						updateID();
						var index = 1;
						var ra = {!! json_encode($rawAnswers) !!};
						for (var i = 0; i < ra.length; i++) {
							ob('answer' + (i + 1)).value = ob('answer' + (i + 1)).innerHTML = ra[i];
						};
					</script>
				</div>
				<input type="button" value="+" onclick="add(); updateID()">
			</div>
			</div>
			{!! Form::close() !!}
	</div>
	<button class="btn btn-primary" onclick="submitForm()" type="button" id="btnAddQuestion">Cập nhật</button>
</div>

@endsection