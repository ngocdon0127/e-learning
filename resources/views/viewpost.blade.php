@extends('layouts.main')
@section('head.title')
    Post {{$Title}}
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
    <h1 class="title">{{$Title . ' : ' . $Description}}</h1>
    <li class="list-group-item">
        @if ($Format == 1)
            <img class="img-responsive" src="{{'/images/imagePost/' . $Photo}}" />
        @elseif ($Format == 2)
            <iframe class="img-responsive" src="https://www.youtube.com/embed/{{$Video}}" frameborder="0" allowfullscreen></iframe>
        @endif
    </li>
    @if ((auth()->user()) && (auth()->user()->admin == 1))
        <a class ="btn btn-info" href="{{route('post.edit', $PostID)}}">Sửa thông tin bài đăng</a>
        <button class ="btn btn-info" onclick="del()">Xóa bài đăng này</button>
        <script type="text/javascript">
            function del(){
                if (confirm('Xác nhận xóa?') == true){
                    window.location = '/admin/post/{{$PostID}}/delete';
                }
            }
        </script>
        <a class ="btn btn-info" href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    @endif
    
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
            if (answerID == trueAnswerID) {
                ob(id).style.background = '#66ff66';
                score++;
            }
            else {
                ob(id).style.background = '#ff5050';
            }
            var idTrue = 'answer_' + questionID + '_' + trueAnswerID;
            ob(idTrue).style.background = '#66ff66';
            fill++;
            if (fill >= maxScore){

                var resultText = 'Đúng ' + score + '/' + maxScore + ' câu.\n';
                var x = {!! $Comments !!};
                console.log("start chấmming");
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

                console.log('diem: ' + score);
                // save result using AJAX
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
            else{
                var delayToNextQuestion = 500;      // Time for user review current question.
                var timeScrollToNextQuestion = 300;
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $("#title_question_" + nextQuestionID).offset().top
                    }, timeScrollToNextQuestion);
                }, delayToNextQuestion);
            }
//                obj.open('GET', '/ajax/checkanswer/' + questionID + '/' + answerID, true);
//                ob.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//                obj.send();

        }
    </script>
	@if (!auth() || !(auth()->user()))
	<h3 style="background: rgb(255, 110, 110); color: #933" class="list_answer">Bạn chưa đăng nhập. Kết quả làm bài sẽ không được lưu lại. </h3>
    <a class="btn btn-primary" href="/auth/login" role="button">Login now</a>
	@endif
    <h1 class="title">Các câu hỏi</h1>
    <ul id="form_test" class="list-group">
        <input id='token' type="text" value="{{$Token}}" style="display: none;" readonly />
        <?php $count_answer=1;?>
        @foreach($Questions as $key => $q)
            <h2 class="title" id="title_question_{!! $key + 1 !!}">Câu hỏi số <?php echo $count_answer++; ?>:</h2>
				@if ((auth()->user()) && (auth()->user()->admin == 1))
					<a style="text-decoration: none;" href="/question/{{$q['id']}}"><h4>{{$q['Question']}} : {{$q['Description']}}</h4></a>
				@else
					<h4>{{$q['Question']}} : {{$q['Description']}}</h4>
				@endif
            @if ($q['Photo'] != null)
            <li class="list-group-item list-group-item-info">
                <img class="img-responsive" src="/images/imageQuestion/{{$q['Photo']}}" />
            </li>
            @endif
           <ul class="list-group" id="ul_question_{{$q['id']}}">
                @foreach($Bundle[$q['id']] as $k => $a)
                    <li id="answer_{{$q['id']}}_{{$a['id']}}" class="list_answer"  onclick="check({{$q['id']}}, {{$a['id']}}, {{$BundleAnswers[$q['id']]}}, {!! $key + 2 !!})" style="cursor: pointer">
                        <input type="checkbox" id="radio_answer_{{$q['id']}}_{{$a['id']}}" name="question_{{$q['id']}}"/>
                       <span class="answer_content">{!! $a['Detail'] !!}</span>
                    </li>

                    <div class="clear"></div>
                @endforeach
            </ul>

        @endforeach
    </ul>
    <div class="form-control" id="resultText" style="display: none; height: 200px;">
        <b class="title" id="writeResult"></b> <br />
    </div>
	<div style="margin-top: 10px">
        @if ($PreviousPost != null)
            <a class="btn btn-primary" href="{{route('user.viewpost', $PreviousPost)}}">Previous Post</a>
        @endif
        <a class="btn btn-primary" href="#">Back to top</a>
        @if ($NextPost != null)
            <a class="btn btn-primary" href="{{route('user.viewpost', $NextPost)}}">Next Post</a>
        @endif
    </div>
    <div class="fb-comments" data-href="{!! 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']!!}" data-width="500" data-numposts="5"></div>
    <div class="fb-like" data-href="{!! 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']!!}" data-width="450" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
@endsection
@section('body.navright')
    <div class="panel panel-default">
        <div class="panel-heading">
            Các post gần đây
        </div>
        <div class="panel-body">
        @foreach($newpost as $np)
        <a style="text-decoration: none;" href="/post/{{$np['id']}}">
           <blockquote>
               <img class="img-responsive" src="/images/imagePost/{{$np['Photo']}}" />
                <h4>{{$np['Title']}}</h4>
                <h6>{{$np['Description']}}</h6>
           </blockquote>
        </a>
        @endforeach
        </div>
    </div>
@endsection