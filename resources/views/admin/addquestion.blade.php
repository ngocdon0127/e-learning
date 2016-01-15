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
<!-- <div class="col-md-offset-3 col-md-6"> -->
		<h1 class="col-md-offset-3 title">Thêm câu hỏi mới</h1>

		{!! Form::open(['name' => 'addQuestionForm', 'url' => '/admin/addquestion/' . $PostID, 'class'=>'form-horizontal', 'files' => true]) !!}
			

		<div class="form-group">
			{!! Form::label('Question','Question : ',['class' => 'control-label']) !!}
			{!! Form::text('Question','',['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('FormatID', 'Format ID : ',['class' => 'control-label']) !!}
			{!! Form::select('FormatID',\App\Formats::getColumn('Title'), '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white";', 'onchange' => 'configForm()']) !!}
		</div>
		<div class="form-group" id="divPhoto">
			{!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
			{!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif']) !!}
		</div>
		<div class="form-group" id="divVideo">
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
			{!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
			{!! Form::text('Description','',['class'=>'form-control']) !!}
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
				switch (ob('FormatID').value){
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
				$('#error').fadeIn();
				ob('error').innerHTML = x;
			}
			function submitForm(){
				switch (ob('FormatID').value){
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
							//                            console.log('not ok');
							displayError('Chỉ chọn file ảnh.');
						}
						else{
								//                            console.log('ok');
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
	//                        ob('error').innerHTML = photo.value;
			}

			function submitViaAJAX(p){
				// check if admin has chosen right answer or not
				updateID();
				for(var i = 1; i <= count; i++){
					ob('ta_answer' + i).innerHTML = ob('answer' + i).innerHTML = ob('answer' + i).value;
				}
					console.log(resultQuestion + ' : ' + count);
				if ((resultQuestion < 0) && (count > 0)){
					alert('Lại lanh chanh đốt cháy giai đoạn   >.< ');
					return;
				}
				ob('btnAddQuestion').disabled = true;
				var fd = new FormData();
				fd.append('Question', ob('Question').value);
				fd.append('FormatID', ob('FormatID').value);
				fd.append('Description', ob('Description').value);
				fd.append('Video', ob('Video').value);
				fd.append('Photo', p);
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
							var qID = data;
							if (count < 1){
									window.location = '/question/' + qID;
									return;
							}
							var action = document.addAnswerForm.action;
							document.addAnswerForm.action = action + '/' + qID;
							console.log(document.addAnswerForm.action);
							ob('QuestionID').value = data;
							submitFormAnswers();
					},
					error: function () {
							console.log("error!!!!");
					}
				}); //end of ajax
			}
		</script>
		</div>
					<!-- end script -->
	
			{!! Form::close() !!}
				<!-- end form -->
		<!-- </div> -->
</div>
		<div class="container-fluid">
				<!-- <div class="col-sm-9"> -->
						{!! Form::open(['name' => 'addAnswerForm', 'url' => '/admin/addanswer/','class'=>'control-label']) !!}
							<!--        {!! Form::label('Detail', 'Câu trả lời: ') !!}
						{!! Form::text('Detail') !!} -->
						
						<div class="form-group">
								{!! Form::label('Detail', 'Câu trả lời: ',['class'=>'control-label']) !!}
										<script type="text/javascript">
										var count = -1;
										var minAnswer = 4;
										if (minAnswer == 0){
											minAnswer = 4;
										}
										var resultQuestion = -1;

										function ob(x){
												return document.getElementById(x);
										}

										function xoa(x){
												ob('answers').removeChild(ob(x));
//                        count--;
//                        ob('count').value = count;
												var o = x.substring(x.indexOf('divanswer') + 'disanswer'.length);
												updateID();
//                        ob('count').id = 'hehe';
										}

										function updateID(){
												var answers = ob('answers');
												var childrens = answers.children;
												if (childrens == null){
														return;
												}
												ob('count').value = count = childrens.length - 1;
												resultQuestion = -1;
												// childrens[0] is <script> element
												// childrens[1->n] are <div> element
												for(var i = 1; i < childrens.length; i++){
														var div = childrens[i];
														div.id = 'divanswer' + i;

														// children[0] is textarea hold answer detail
														div.children[0].id = 'answer' + i;
														div.children[0].setAttribute('name', div.children[0].id);

														// children[3] is a reserved textarea
														div.children[3].id = 'ta_answer' + i;
//                            div.children[3].setAttribute('name', div.children[0].id);

														// children[1] is a radio button
														var radio = div.children[1];
														radio.id = 'radio' + i;
														if (radio.checked){
																resultQuestion = i;
														}
														div.setAttribute('class','div_i');
														div.children[0].setAttribute('class','col-sm-12');
														radio.setAttribute('class','checked');
														radio.setAttribute('type','radio');
														div.children[2].setAttribute('class','children btn btn-danger');
//                            radio.setAttribute('onclick', 'markAnswer("' + radio.id + '")');
//                            if (i > minAnswer - 1)

														// children[2] is a button which allow to delete answer i.
														div.children[2].setAttribute('onclick', 'xoa("divanswer' + i + '")');
														div.children[4].setAttribute('onclick', 'addTag("u", "' + i + '")');
														console.log('finish update ' + i);
												}
//                        console.log(resultQuestion);
												ob('result').value = resultQuestion;

										}

										function addTag(tag, id){
												var tagOpen = "[u]";
												var tagClose = "[/u]";
												var textarea = ob('answer' + id);
												var oldText = textarea.value;
//                        console.log(oldText);
												var start = textarea.selectionStart;
//                        console.log('start ' + start);
												var end = textarea.selectionEnd;
//                        console.log('end' + end);
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
//                        console.log('add ');
//                        count++;
//                        ob('count').value = count;
												var e = document.createElement('textarea');
//                        e.type = 'text';
//                        e.name = 'answer' + count;
												e.id = 'specialID';
//                        e.setAttribute('contenteditable', 'true');
//                        e.innerHTML = 'preText';
												e.setAttribute('class', 'col-sm-12');
												var divElement = document.createElement('div');
												divElement.id = "divanswer" + count;
												ob('answers').appendChild(divElement);
												divElement.appendChild(e);
												var radio = document.createElement('input');
												radio.type = 'checkbox';
												radio.name = 'radio_answer';
												divElement.appendChild(radio);
												var btnDel = document.createElement('input');
												btnDel.value = 'Xóa';
												btnDel.type = 'button';
												btnDel.setAttribute('onClick','xoa("' + divElement.id + '")');
												divElement.appendChild(btnDel);
												var hiddenTextarea = document.createElement('textarea');
												hiddenTextarea.style.display = 'none';
												divElement.appendChild(hiddenTextarea);
												var uButton = document.createElement('input');
												uButton.type = 'button';
												uButton.setAttribute('value', 'Gạch chân');
												uButton.setAttribute('class','btn btn-primary');
												divElement.appendChild(uButton);
//                        bkLib.onDomLoaded(function() {
////                            console.log('bklig ');
//                            var nicInstancs = new nicEditor().panelInstance('specialID');
//                        }); // convert text area with id area1 to rich text editor.
//                        updateID();
										}

										function submitFormAnswers(){
												updateID();
												for(var i = 1; i <= count; i++){
														ob('ta_answer' + i).innerHTML = ob('answer' + i).innerHTML = ob('answer' + i).value;
												}
//                        console.log(count);
//                        console.log(resultQuestion);
												if (resultQuestion > -1){
														document.addAnswerForm.submit();
																		}
												else{
													alert('Chưa chọn đáp án đúng của câu hỏi.');
												}
										}
//                 </script>
								<div class="" id="div_answer">
										<input type="text" id="count" name="numAnswer" style="display: none;"/>
										<input type="text" id="result" name="resultQuestion" style="display: none;" />
										<div id="answers">
												<script type="text/javascript">
														for(var i = 0; i < minAnswer; i++){
																			// console.log(i);
																add();
														}
														updateID();
														//{!! $index = 1 !!}
														var index = 1;
														
												</script>
										</div>
										<input type="button" value="+" onclick="add(); updateID()">
								</div>
						</div>


										<!-- <div class="col-sm-10"> -->
								<input type="text" value="" style="display: none" name="QuestionID" id="QuestionID"/>
						{!! Form::close() !!}
				</div>

				<button class="btn btn-primary" onclick="submitForm()" type="button" id="btnAddQuestion">Thêm</button>
		</div>
<!-- end container -->

@endsection