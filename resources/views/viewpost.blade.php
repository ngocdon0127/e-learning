@extends('layouts.main')
@section('head.title')
	{{$Post['Title']}} - Evangels English
@endsection
@section('body.content')
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1657402167852948";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<h2 class="title">{{$Post['Title']}}</h2>
	<h2 class="description">{{$Post['Description']}}</h2>
	<li class="list-group-item">
		@if ($Post['ThumbnailID'] == 1)
			<img class="img-responsive" alt="{{$Post['Title'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="{{'/images/imagePost/' . $Post['Photo']}}" />
		@elseif ($Post['ThumbnailID'] == 2)
		<div class="embed-responsive embed-responsive-4by3">
			<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$Post['Video']}}" frameborder="0" allowfullscreen></iframe>
		</div>
		@endif
	</li>
	@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
		<a class="col-xs-12 btn btn-primary" href="{{route('post.edit', $Post['id'])}}">Sửa thông tin bài đăng</a>
		<a class="col-xs-12 btn btn-primary" data-toggle="modal" href='#modal-add-question'>Thêm câu hỏi</a>

		<a class="col-xs-12 btn btn-danger" data-toggle="modal" href='#modal-id'>Xóa bài đăng này</a>
		<div class="modal fade" id="modal-id">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Cảnh báo:</h4>
					</div>
					<div class="modal-body">
						<h6>Xác nhận xóa?</h6>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a class ="btn btn-primary" href="{{route('admin.destroypost',$Post['id'])}}">Xóa</a>
					</div>
				</div>
			</div>
		</div>

	@endif


	<div class="modal fade" id="modal-add-question">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Chọn dạng câu hỏi</h4>
				</div>
				<div class="modal-body">
					@foreach (App\ConstsAndFuncs::$FORMATS as $k => $v)
					<a class ="btn btn-primary" href="{{route('admin.addquestion', $Post['id'] . '?FormatID=' . $k)}}">{{$v}}</a>
					@endforeach
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" charset="UTF-8">
		var score = 0;
		var fill = 0;
		var maxScore = {{$MaxScore}};
		function ob(x){
			return document.getElementById(x);
		}
		var numQuestion = {!! count($Questions) !!};
		function check(questionID, answerID, trueAnswerID, nextQuestionID){
			console.log('start');
			var date = new Date();
			var id = 'radio_answer_' + questionID + '_' + answerID;
			ob(id).checked = true;
			var id = 'answer_' + questionID + '_' + answerID;

//                ob(id).disabled = true;
			var setOfRadio = document.getElementsByName('question_' + questionID);
			for(i = 0; i < setOfRadio.length; i++){
				setOfRadio[i].disabled = true;
			}

			var setLi = document.getElementById('ul_question_' + questionID).children;
			for(i = 0; i < setLi.length; i++){
				var li = setLi[i];
				li.setAttribute('onclick', '');
				li.style.cursor = 'no-drop';
			}

			console.log('receive');
			var date1 = new Date();
			console.log(date1.getTime() - date.getTime())
//                        ob('answer_' + questionID + '_' + answerID).innerHTML = obj.responseText;

//                var xml = jQuery.parseXML(obj.responseText);
//                        console.log(xml.getElementsByTagName('logical')[0].innerHTML);
			if (trueAnswerID == answerID) {
				ob(id).style.background = '#66ff66';
				score++;
			}
			else {
				ob(id).style.background = '#ff5050';
			}
			var idTrue = 'answer_' + questionID + '_' + trueAnswerID;
			console.log(idTrue);
			ob(idTrue).style.background = '#66ff66';
			fill++;
			if (fill >= maxScore){


				// console.log('diem: ' + score);
				// save result using AJAX
				submitResult();

			}
			else{
				var delayToNextQuestion = 500;      // Time for user review current question.
				var timeScrollToNextQuestion = 300;
				setTimeout(function() {
					$('html, body').animate({
						scrollTop: $("#title_question_" + nextQuestionID).offset().top
					}, timeScrollToNextQuestion);
				}, delayToNextQuestion);
			}

		}

		var t = '';
		function gText(e) {
			t = (document.all) ? document.selection.createRange().text : document.getSelection();
			// console.log(t.length);
			// if (t.length > 0)
				// alert(t);
				ob('inputDictionary').value = t;
				console.log(ob('inputDictionary').value);
				t = ob('inputDictionary').value;
				if (t.length <= 0){
					return;
				}
				ob('divDictionary').innerHTML = 'Searching...';
				$('#modal-id-dictionary').modal();
				$.ajax({
					type: 'GET',
					url: "{{route('ajax.dic')}}",
					beforeSend: function(xhr){
						var token = $('meta[name="_token"]').attr('content');

						if (token) {
							return xhr.setRequestHeader('X-CSRF-TOKEN', token);
						}
					},
					data: {word: ob('inputDictionary').value.toLowerCase().trim()},
					success: function (data) {
						var d = JSON.parse(data);
						// console.log(d.meanings);
						var ulMeanings = document.createElement('ul');
						for(var i = 0; i < d.meanings.length; i++){
							var liMeanings = document.createElement('li');
							liMeanings.innerHTML = d.meanings[i];
							ulMeanings.appendChild(liMeanings);
						}
						var ulExamples = document.createElement('ul');
						for(var i = 0; i < d.examples.length; i++){
							var liExamples = document.createElement('li');
							liExamples.innerHTML = d.examples[i];
							ulExamples.appendChild(liExamples);
						}
						var divDictionary = ob('divDictionary');
						divDictionary.innerHTML = '';
						var pMeanings = document.createElement('p');
						pMeanings.innerHTML = 'Meaning of "' + t.trim() + '" : ';
						divDictionary.appendChild(pMeanings);
						divDictionary.appendChild(ulMeanings);
						var divtmp = document.createElement('div');
						divtmp.setAttribute('class', 'clear');
						divDictionary.appendChild(divtmp);
						var pExamples = document.createElement('p');
						pExamples.innerHTML = 'Examples for "' + t.trim() + '" : ';
						divDictionary.appendChild(pExamples);
						divDictionary.appendChild(ulExamples);
						if (window.getSelection) {
							if (window.getSelection().empty) {  // Chrome
							window.getSelection().empty();
						}
						else if (window.getSelection().removeAllRanges) {  // Firefox
							window.getSelection().removeAllRanges();
						}
						}
						else if (document.selection) {  // IE?
							document.selection.empty();
						}
					}, error: function () {
						console.log("error!!!!");
					}
				});
		}

		// document.onmouseup = gText;
		if (!document.all) document.captureEvents(Event.MOUSEUP);

	</script>
	<ul id="form_test" class="list-group">
		<input id='token' type="text" value="{{$Token}}" style="display: none;" readonly />
		<?php $count_answer=1;?>
		@foreach($Questions as $key => $q)
			@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
				<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><h3 onmouseover="this.style.color = '#f06'" onmouseout="this.style.color = '#60c'" class="title" id="title_question_{!! $key + 1 !!}">Câu hỏi số <?php echo $count_answer++; ?>:</h3></a>
			@else
			<h3 class="title" id="title_question_{!! $key + 1 !!}">Câu hỏi số <?php echo $count_answer++; ?>:</h3>
			@endif

			<!-- Trắc nghiệm -->
			@if ($q['FormatID'] == 1)
				<h4 class="title">{!! nl2br($q['Question']) . ((strlen($q['Description']) > 0) ? (" :<br /><br /> " . nl2br($q['Description'])) : "") !!}</h4>
					@if ($q['ThumbnailID'] == 1)
						@if ($q['Photo'] != null)
							<li class="list-group-item list-group-item-info">
								@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
									<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
								@else
									<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
								@endif
							</li>
						@endif
					@elseif ($q['ThumbnailID'] == 2)
						@if ($q['Video'] != null)
							<div class="embed-responsive embed-responsive-4by3">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$q['Video']}}" frameborder="0" allowfullscreen></iframe>
							</div>
						@endif
					@endif
				
				<ul class="list-group" id="ul_question_{{$q['id']}}">
					@foreach($AnswersFor1[$q['id']] as $k => $a)
						<li id="answer_{{$q['id']}}_{{$a['id']}}" class="list_answer"  onclick="check({{$q['id']}}, {{$a['id']}}, {{ $TrueAnswersFor1[$q['id']]}}, {!! $key + 2 !!})" style="cursor: pointer">
							<input type="checkbox" id="radio_answer_{{$q['id']}}_{{$a['id']}}" name="question_{{$q['id']}}"/>
							<span class="answer_content">{!! \App\Http\Controllers\AnswersController::underline($a['Detail']) !!}</span>
						</li>

						<div class="clear"></div>
					@endforeach
				</ul>
			<!-- End of Trắc nghiệm -->
			@elseif ($q['FormatID'] == 2)
			<!-- Điền từ -->
				@if ($q['ThumbnailID'] == 1)
					@if ($q['Photo'] != null)
						<li class="list-group-item list-group-item-info">
							@if ((auth()->user()) && (auth()->user()->admin == 1))
								<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
							@else
								<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
							@endif
						</li>
					@endif
				@elseif ($q['ThumbnailID'] == 2)
					@if ($q['Video'] != null)
						<div class="embed-responsive embed-responsive-4by3">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$q['Video']}}" frameborder="0" allowfullscreen></iframe>
						</div>
					@endif
				@endif
				<?php
					$subP = \App\Questions::getFilledQuestion($q['Question']);
					reset($Spaces);  // don't know what's different between this view & viewfilledquestion
				?>
				<div style="color:#cc0066; font-weight:bold;">
				@if (strlen($q['Description']) > 0)
					{!! nl2br($q['Description']) . ":" !!}
				@endif
				</div>
				<div>
					<h4 class="title">
						@foreach ($subP as $value)
							{!! nl2br($value) !!}
							@if (count($Spaces[$q['id']]) > 0)
							<select style="color:#cc0066" id="select_space_{{current($Spaces[$q['id']])['id']}}" data-show-icon="true">
								<?php 
									$this_answers = $AnswersFor2[current($Spaces[$q['id']])['id']];
								?>
								@foreach ($this_answers as $a)
								<option class="option_space_{{$a['Logical']}}" value="{{$a['Logical']}}">{!! $a['Detail'] !!}</option>
								@endforeach
							</select>
						
							<!-- change normal select into BS3 select manually-->
							<script type="text/javascript">
								bsselect("select_space_{{current($Spaces[$q['id']])['id']}}");
							</script>
							<?php array_shift($Spaces[$q['id']]) ?>
							@endif
						@endforeach
					</h4>
				</div>
			<!-- End of Điền từ -->
			@elseif ($q['FormatID'] == 5)
			<!-- Nối -->
			<h4 class="title">{!! nl2br($q['Question']) . ((strlen($q['Description']) > 0) ? (" :<br /><br /> " . nl2br($q['Description'])) : "") !!}</h4>
				@if ($q['ThumbnailID'] == 1)
					@if ($q['Photo'] != null)
						<li class="list-group-item list-group-item-info">
							@if ((auth()->user()) && (auth()->user()->admin == 1))
								<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
							@else
								<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
							@endif
						</li>
					@endif
				@elseif ($q['ThumbnailID'] == 2)
					@if ($q['Video'] != null)
						<div class="embed-responsive embed-responsive-4by3">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$q['Video']}}" frameborder="0" allowfullscreen></iframe>
						</div>
					@endif
				@endif
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-bottom: 15px;">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding:0">
							<ul id="ul_subquestion_{{$q['id']}}" class="sortable">
								@foreach($Subquestions[$q['id']] as $s)
									<li id="li_subquestion_{{$s['id']}}" class="ui-state-default li-connected text-center"><p>{{$s['Question']}}</p></li>
								@endforeach
							</ul>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding-right:0">
						<ul id="ul_subquestion_answer_{{$q['id']}}" class="sortable">
							<?php shuffle($AnswersFor5[$q['id']]) ?>
							@foreach($AnswersFor5[$q['id']] as $s)
								<li class="ui-state-default li-connected text-center" id="li_subquestion_answer_{{$s['SubQuestionID']}}"><p><bootstrap-select>{{$s['Detail']}}</bootstrap-select></p></li>
							@endforeach
						</ul>
					</div>
					</div>
				</div>
				<!--<script type="text/javascript" src="/js/jquery/jquery.mobile-1.4.5.min.js"></script>-->
				<script>
					$(document).bind('pageinit', function() {
						$( ".sortable" ).sortable();
						$( ".sortable" ).disableSelection();
						//<!-- Refresh list to the end of sort to have a correct display -->
						$( ".sortable" ).bind( "sortstop", function(event, ui) {
							$('.sortable').listview('refresh');
						});
					});
				</script>
			<!-- End of Nối -->
			@elseif ($q['FormatID'] == 6)
			<!-- Kéo thả -->
			<h4 class="title">{!! nl2br($q['Question']) . ((strlen($q['Description']) > 0) ? (" :<br /><br /> " . nl2br($q['Description'])) : "") !!}</h4>
				@if ($q['ThumbnailID'] == 1)
					@if ($q['Photo'] != null)
						<li class="list-group-item list-group-item-info">
							@if ((auth()->user()) && (auth()->user()->admin == 1))
								<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
							@else
								<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
							@endif
						</li>
					@endif
				@elseif ($q['ThumbnailID'] == 2)
					@if ($q['Video'] != null)
						<div class="embed-responsive embed-responsive-4by3">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$q['Video']}}" frameborder="0" allowfullscreen></iframe>
						</div>
					@endif
				@endif
				<ul id="ul_dragdrop_{{$q['id']}}" class="sortable" style="margin-top: 20px; margin-bottom: 20px">
					<?php shuffle($AnswersFor6[$q['id']]) ?>
					@foreach($AnswersFor6[$q['id']] as $a)
						<li id="li_dragdrop_{{$a['id']}}" class="ui-state-default li-dragdrop form-control">{{$a['Detail']}}</li>
					@endforeach
				</ul>
				<input type="hidden" id="answer_dragdrop_{{$q['id']}}" style="color: #933; font-weight: bold;" class="form-control" value="{{$CompleteAnswersFor6[$q['id']]}}" />
			<!-- End of Kéo thả -->
			@endif

			@if($q['FormatID'] == 3)
			<!-- Sắp xếp -->
				<h3>{{$q['Question']}}</h3>
				@if ($q['Photo'] != null)
						<li class="list-group-item list-group-item-info">
							@if ((auth()->user()) && (auth()->user()->admin == 1))
								<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
							@else
								<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
							@endif
						</li>
					@endif
					<h4>Nhập câu trả lời:</h4>
				<input type="text" id="input_arranged_{{$q['id']}}" class="form-control" value="" placeholder="Input here..." required="required" pattern="" title="Nhập câu trả lời">
				<input type="hidden" id="answer_arranged_{{$q['id']}}" value="{{$AnswersFor3[$q['id']]['Detail']}}" />
			<!-- End of Sắp xếp -->
			@endif
			@if($q['FormatID'] == 4)
			<!-- Điền chữ cái -->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 fill_word" style="padding: 0; margin-bottom: 20px;">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 fw_left" style="border: #ecf0f1 solid 1px;">
						<h2 class="title text-center fw_left_above" id="h2_fillcharacter_{{$q['id']}}">{{$q['Question']}}</h2>
						<input type="text" id="input_fillcharacter_{{$q['id']}}" class="form-control fw_left_below" value="" placeholder="Input here..." required="required" pattern="" title="Nhập câu trả lời">
						<input type="hidden" id="answer_fillcharacter_{{$q['id']}}" value="{{$AnswersFor4[$q['id']]['Detail']}}" />
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 fw_right" style="padding: 0">
						@if ($q['Photo'] != null)
								@if ((auth()->user()) && (auth()->user()->admin == 1))
									<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" /></a>
								@else
									<img class="img-responsive" alt="{{$q['Question'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imageQuestion/{{$q['Photo']}}" />
								@endif
						@endif
					</div>
				</div>
			<!-- End of Điền chữ cái -->
			@endif
		@endforeach
	</ul>
	<button class="btn btn-primary" onclick="nopBai()">Nộp bài</button>
	<script>
		function nopBai(){
			checkFilledQuestions();
			checkConnectedQuestions();
			checkDragDropQuestions();
			checkArrangedQuestions();
			checkFillCharacterQuestions();
			submitResult();
		}
	</script>
	@if (($DisplayedQuestions >= 0) && ($DisplayedQuestions < $NumOfQuestions))
		<p>Bạn đang xem {{$DisplayedQuestions . "/" . $NumOfQuestions}} câu hỏi của bài này.</p>
		<a href="{{route('user.buy')}}" class="btn btn-info">Purchase to see full post</a>
	@endif
	<script type="text/javascript">
		$('div[class="btn-group bootstrap-select"').css("width","auto");
		$('button[class="btn dropdown-toggle btn-default"]').css({"background":"#e0f0ff","color":"#993333","font-weight":"bold"});
		$(document).ready(function(){
			// var max_height = 0;
			//Duyệt qua 3 cột để lấy kích thước của cột lớn nhất
			// $(".fw_left,.fw_right").each(function(){
			// 	if($(this).height() > max_height)
			// 	max_height = $(this).height();
			// });
			//Gán độ cao 3 cột theo giá trị max_heigh
			// max_height = max_height*0.7-30;
			// max_height = $('.fw_right').height();
			// console.log("max_height : " + max_height);
			// $(".fw_left_above").height(max_height * 0.7 - 30);
			// // $(".fw_left_above").css({"top":"50%","margin-bottom":h2_height*0.5});
			// $(".fw_left_below").height(max_height * 0.3 - 30);
			var setOfDivs = document.getElementsByClassName('fill_word');
			console.log(setOfDivs.length);
			for (var i = 0; i < setOfDivs.length; i++) {
				console.log('i = ' + i);
				var max_height = setOfDivs[i].children[1].children[0].clientHeight;
				console.log(max_height);
				// setOfDivs[i].children[0].style.height =  (max_height + 60) + "px";
				setOfDivs[i].children[0].children[0].style.height = (max_height * 0.7 - 30) + "px";
				console.log(setOfDivs[i].children[0].children[0].nodeName);
				setOfDivs[i].children[0].children[1].style.height = (max_height * 0.3 - 15) + "px";
				console.log(setOfDivs[i].children[0].children[1].nodeName);
				console.log('set');
			};

		});
		function checkFilledQuestions(){
			var setOfSpaces = {!! json_encode($SetOfSpaceIDs) !!};
			for (var i = 0; i < setOfSpaces.length; i++) {
				var selectObj = $('#select_space_' + setOfSpaces[i]);

				// bootstrap-select will be hided; a button with data-id attribute equals to id of old bootstrap-select will be added and shown.
				var btn = $('button[data-id="select_space_' + setOfSpaces[i] + '"]');
				if (selectObj.val() == 1){
					score++;
					btn.css('background', "#66ff66");
				}
				else{
					btn.css('background', "#ff5050");
				}
			};
			var setOfOptions = document.getElementsByClassName('option_space_1');
			for (var i = 0; i < setOfOptions.length; i++) {
				setOfOptions[i].innerHTML += ' <span class="glyphicon glyphicon-ok">';
			}
		}

		function checkConnectedQuestions() {
			var setOfQuestionIDs = {!! json_encode($QuestionFor5IDs) !!};
			var lenq = 'li_subquestion_'.length;
			var lena = 'li_subquestion_answer_'.length;
			for (var i = 0; i < setOfQuestionIDs.length; i++) {
				var ulSubQuestions = ob('ul_subquestion_' + setOfQuestionIDs[i]);
				var ulSubQuestionAnswers = ob('ul_subquestion_answer_' + setOfQuestionIDs[i]);
				console.log(ulSubQuestions.children.length);
				for (var j = 0; j < ulSubQuestions.children.length; j++) {
					var li1 = ulSubQuestions.children[j];
					var li2 = ulSubQuestionAnswers.children[j];
					var id1 = li1.id;
					var id2 = li2.id;
					var ss1 = id1.substring(lenq, id1.length);
					var ss2 = id2.substring(lena, id2.length);
					if (ss1 == ss2){
						score++;
						li1.style.background = '#66ff66';
						li2.style.background = '#66ff66';
					}
					else{
						li1.style.background = '#ff5050';
						li1.children[0].innerHTML += '<span style="color: #fff"> => ' + ob('li_subquestion_answer_' + ss1).children[0].children[0].innerHTML + '</span>';
						li2.style.background = '#ff5050';
					}
				};
			};
		}

		function checkDragDropQuestions(){
			var setOfDragDropQuestions = {!! json_encode($DragDropIDs) !!};
			for (var i = 0; i < setOfDragDropQuestions.length; i++) {
				var check = true;
				var ulDragDrop = ob('ul_dragdrop_' + setOfDragDropQuestions[i]);
				for (var j = 1; j < ulDragDrop.children.length; j++) {
					var li1 = ulDragDrop.children[j - 1];
					var li2 = ulDragDrop.children[j];
					var len = 'li_dragdrop_'.length;
					var id1 = li1.id.substring(len, li1.length);
					var id2 = li2.id.substring(len, li2.length);
					if (id1 > id2){
						check = false;
						break;
					}
				}
				var c = '#ff5050';
				if (check){
					score++;
					c = '#66ff66';
				}
				else{
					ob('answer_dragdrop_' + setOfDragDropQuestions[i]).setAttribute('type', 'text');
				}
				for (var k = 0; k < ulDragDrop.children.length; k++) {
					ulDragDrop.children[k].style.background = c;
				}
			}
		}

		function checkArrangedQuestions() {
			var setOfArrangedIDs = {!! json_encode($ArrangedIDs) !!};
			for (var i = 0; i < setOfArrangedIDs.length; i++) {
				var input = ob('input_arranged_' + setOfArrangedIDs[i]);
				var answer = ob('answer_arranged_' + setOfArrangedIDs[i]);
				if (input.value.trim().toUpperCase() == answer.value.trim().toUpperCase()){
					score++;
					input.style.background = '#66ff66';
				}
				else{
					input.style.background = '#ff5050';
					input.value += ' => ' + answer.value.trim();
				}
			}
		}

		function checkFillCharacterQuestions() {
			var setOfArrangedIDs = {!! json_encode($FillCharacterIDs) !!};
			for (var i = 0; i < setOfArrangedIDs.length; i++) {
				var input = ob('input_fillcharacter_' + setOfArrangedIDs[i]);
				var answer = ob('answer_fillcharacter_' + setOfArrangedIDs[i]);
				if (input.value.trim().toUpperCase() == answer.value.trim().toUpperCase()){
					score++;
					input.style.background = '#66ff66';
				}
				else{
					input.style.background = '#ff5050';
					// input.value += ' => ' + answer.value.trim();
					ob('h2_fillcharacter_' + setOfArrangedIDs[i]).innerHTML = answer.value.trim();
				}
			}
		}

		function submitResult(){
			var resultText = 'Bé làm đúng ' + score + '/' + maxScore + ' điểm.\n';
			var x = {!! $Comments !!};
			for(var i = x.length - 1; i >= 0; i--) {
				if (Math.floor(score / maxScore * 100) >= x[i]['min']){
					resultText += x[i]['comment'];
					break;
				}
			}
			ob('writeResult').innerHTML = resultText;
			ob('resultText').style.display = 'block';
			$('html, body').animate({
				scrollTop: $("#resultText").offset().top
			}, 1000);
			$.ajax({
				url: "/finishexam",
				type: "POST",
				beforeSend: function (xhr) {
					var token = $('meta[name="_token"]').attr('content');

					if (token) {
						return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data: {
					Score:  score,
					MaxScore: maxScore,
					token: ob('token').value
				},
				success: function (data) {
					console.log(data);
				}, error: function (data) {
					console.log(data);
				}
			}); //end of ajax
		}
	</script>
	<div class="form-control" id="resultText" style="display: none; height: 200px;">
		<b class="title" id="writeResult"></b> <br />
	</div>
	<ul class="pager">
		@if ($PreviousPost != null)
			<li class="previous"><a href="{{route('user.viewpost', $PreviousPost)}}">Previous post</a></li>
		@endif
			<a id="toTop" href="#" style="float:right"></a>
		@if ($NextPost != null)
			<li class="next"><a href="{{route('user.viewpost', $NextPost)}}">Next post</span></a></li>
		@endif
	</ul>
	<div class="fb-comments" data-href="{!! 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']!!}" data-width="500" data-numposts="5"></div>
	<div class="fb-like" data-href="{!! 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']!!}" data-width="450" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	<input type="hidden" id="inputDictionary" value="tmp">
	<div class="modal fade" id="modal-id-dictionary">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Quick Translation</h4>
				</div>
				<div class="modal-body" id="divDictionary">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('body.navright')
	<div class="panel panel-default xxx">
		<div class="panel-heading">
			Bài đăng cùng khóa
		</div>
		<div class="panel-body" id="div_right_bar">
		@foreach($newpost as $np)
			<a id="a_smallLink_{{$np['id']}}" style="text-decoration: none;" href="{{route('user.viewpost', $np['id'])}}">
				<blockquote>
					@if($np['ThumbnailID'] == '1')
						<img class="img-responsive" alt="{{$np['Title'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imagePost/{{$np['Photo']}}" />
					@elseif($np['ThumbnailID'] == '2')
					<div class="embed-responsive embed-responsive-4by3">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$np['Video']}}" frameborder="0" allowfullscreen></iframe>
					</div>
					@endif
					<h4>{{$np['Title']}}</h4>
					<h6>{{$np['Description']}}</h6>
				</blockquote>
			</a>
		@endforeach
		</div>
	</div>
@endsection
@section('head.css')
	<link rel="stylesheet" href="/js/jquery/jquery-ui.css">
	<script src="/js/jquery/jquery.js"></script>
	<script src="/js/jquery/jquery-ui.min.js"></script>
	<script src="/js/jquery/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
	<script>$('.sortable').draggable();</script>
	<style>
		.sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
		.li-connected, .li-dragdrop{
			cursor: pointer;
			background: #e0f0ff;
			font-weight: bold;
			color: #933;
		}
		.li-connected{
			position: relative;
			height: 80px;
			border-radius: 10px;
			margin-top: 10px;
		}
		.li-connected p {
			margin: 0;
			position: absolute;
			top: 50%;
			left: 50%;
			right: -50%;
			transform: translate(-50%, -50%);
		}
		.li-dragdrop{
			list-style-type: none;
			margin: 1px;
			width: auto;
			display: inline;
			
		}
	</style>
	<script>
		jQuery(function() {
			jQuery( ".sortable" ).sortable();
			jQuery( ".sortable" ).disableSelection();
		});
		function bsselect(x){
			$("#" + x).selectpicker();
		}
		$.noConflict();
	</script>
@endsection