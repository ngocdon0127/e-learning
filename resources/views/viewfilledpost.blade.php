@extends('layouts.main')
@section('head.title')
	{{$Title}} - Evangels English
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
	<h2 class="title">{{$Title}}</h2>
	<h2 class="description">{{$Description}}</h2>
	<li class="list-group-item">
		@if ($Thumbnail == 1)
			<img class="img-responsive" alt="{{$Title . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="{{'/images/imagePost/' . $Photo}}" />
		@elseif ($Thumbnail == 2)
		<div class="embed-responsive embed-responsive-4by3">
			<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$Video}}" frameborder="0" allowfullscreen></iframe>
		</div>
		@endif
	</li>
	@if ((auth()->user()) && (auth()->user()->admin == 1))
		<a class ="col-xs-12 btn btn-primary" href="{{route('post.edit', $PostID)}}">Sửa thông tin bài đăng</a>
		<a class ="col-xs-12 btn btn-primary" href="{{route('admin.addquestion',$PostID)}}">Thêm câu hỏi</a>

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
						<a class ="btn btn-primary" href="{{route('admin.destroypost',$PostID)}}">Xóa</a>
					</div>
				</div>
			</div>
		</div>

	@endif
	
	<script type="text/javascript" charset="UTF-8">
		function ob(x){
			return document.getElementById(x);
		}
		var numQuestion = {!! count($Questions) !!};

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
						// window.preventDefault();
						// window.location = "#modal-id";
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

		document.onmouseup = gText;
		if (!document.all) document.captureEvents(Event.MOUSEUP);

	</script>
	<ul id="form_test" class="list-group">
		<input id='token' type="text" value="{{$Token}}" style="display: none;" readonly />
		<?php $count_answer=1 ?>
		<?php $setOfSpaces = array() ?>
		@foreach($Questions as $key => $q)
			@if ((auth()->user()) && (auth()->user()->admin == 1))
				<a style="text-decoration: none;" href="{{route('user.viewquestion', $q['id'])}}"><h3 onmouseover="this.style.color = '#f06'" onmouseout="this.style.color = '#6600cc'" class="title" id="title_question_{!! $key + 1 !!}">Câu hỏi số <?php echo $count_answer++; ?>:</h3></a>
			@else
			<h3 class="title" id="title_question_{!! $key + 1 !!}">Câu hỏi số <?php echo $count_answer++; ?>:</h3>
			@endif
			<h4 class="title">
			<?php 
				$subP = \App\Questions::getFilledQuestion($q['Question']);
				$Answers = array();
				$Spaces = \App\Spaces::where('QuestionID', '=', $q['id'])->get()->toArray();
				foreach ($Spaces as $value) {
					$Answers += array($value['id'] => \App\Answers::where('SpaceID', '=', $value['id'])->get()->toArray());
				}
				foreach ($Spaces as $key => $value) {
					$setOfSpaces = array_merge($setOfSpaces, [$value['id']]);
				}
				reset($Spaces);  // don't know what's different between this view & viewfilledquestion
			?>
			<div  style="color:#cc0066; font-weight:bold;">
			@if (strlen($q['Description']) > 0)
				{!! nl2br($q['Description']) . ":" !!}
			@endif
			</div>
			<div>
				@foreach ($subP as $value)
					{!! nl2br($value) !!}
					@if (count($Spaces) > 0)
					<select style="color:#cc0066" class="selectpicker" id="select_space_{{current($Spaces)['id']}}" data-show-icon="true">
						<?php 
							$this_answers = $Answers[current($Spaces)['id']];
							shuffle($this_answers);
						?>
						@foreach ($this_answers as $a)
						<option class="option_space_{{$a['Logical']}}" value="{{$a['Logical']}}">{!! $a['Detail'] !!}</option>
						@endforeach
					</select>

					<!-- change normal select into BS3 select manually-->
					<!--<script type="text/javascript">
						//$('#select_space_{{current($Spaces)['id']}}').selectpicker();
					</script>-->
					<?php array_shift($Spaces) ?>
					@endif
				@endforeach</div>
			</h4>
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
						<!-- <li class="list-group-item list-group-item-info"> -->
						<div class="embed-responsive embed-responsive-4by3">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$q['Video']}}" frameborder="0" allowfullscreen></iframe>
						</div><!-- </li> -->
					@endif
				@endif
		@endforeach
	</ul>
	<button class="btn btn-primary" onclick="check()">Nộp bài</button>
	<script>
		function check(){
			var score = 0;
			var setOfSpaces = {!! json_encode($setOfSpaces) !!};
			var maxScore = setOfSpaces.length;
			for (var i = 0; i < setOfSpaces.length; i++) {
				var selectObj = $('#select_space_' + setOfSpaces[i]);
				// bootstrap-select was be changed into button with data-id attribute is equal to id of old select
				var btn = $('button[data-id="select_space_' + setOfSpaces[i] + '"]');
				if (selectObj.val() == 1){
					score++;
					btn.css('background', "#66ff66");
				}
				else{
					btn.css('background', "#ff5050");
				}
			};
			var resultText = 'Đúng ' + score + '/' + maxScore + ' câu.\n';
			var x = {!! $Comments !!};
			// console.log("start chấmming");
			for(var i = x.length - 1; i >= 0; i--) {
//                    console.log(Math.floor(score / maxScore * 100));
//                    console.log(min[i]);
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
			var setOfOptions = document.getElementsByClassName('option_space_1');
			for (var i = 0; i < setOfOptions.length; i++) {
				setOfOptions[i].innerHTML += '<span class="glyphicon glyphicon-ok">';
				// setOfOptions[i].style.background = "#66ff66";
			}

			// var set = document.getElementsByTagName('option');
			// for (var i = 0; i < set.length; i++) {
			// 	set[i].innerHTML += '<span class="glyphicon glyphicon-ok">';
			// 	// set[i].style.color = "white";
			// 	// console.log(set[i].innerHTML);
			// };

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
	<div class="panel panel-default">
		<div class="panel-heading">
			Bài đăng cùng khóa
		</div>
		<div class="panel-body" style="max-height: 1000px; overflow: auto" id="div_right_bar">
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