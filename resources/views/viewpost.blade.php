@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <img src="{{'/images/imagePost/' . $Photo}}" width="500px" height="500px"/>
        {{--<script src="/js/function.js"></script>--}}
        <script type="text/javascript">
            var score = 0;
            var fill = 0;
            var maxScore = {{$MaxScore}};
            function ob(x){
                return document.getElementById(x);
            }
            function check(questionID, answerID, trueAnswerID){
                console.log('start');
                var date = new Date();
                var id = 'answer_' + questionID + '_' + answerID;
                ob(id).disabled = true;
                var set = document.getElementsByName('question_' + questionID);
                for(i = 0; i < set.length; i++){
                    set[i].disabled = true;
                }

                console.log('receive');
                var date1 = new Date();
                console.log(date1.getTime() - date.getTime())
//                        ob('answer_' + questionID + '_' + answerID).innerHTML = obj.responseText;

//                var xml = jQuery.parseXML(obj.responseText);
//                        console.log(xml.getElementsByTagName('logical')[0].innerHTML);
                if (answerID == trueAnswerID) {
                    ob(id).style.background = 'green';
                    score++;
                }
                else {
                    ob(id).style.background = 'red';
                }
                var idTrue = 'answer_' + questionID + '_' + trueAnswerID;
                ob(idTrue).style.background = 'green';
                fill++;
                if (fill >= maxScore){
                    alert(score);
                }
//                obj.open('GET', '/ajax/checkanswer/' + questionID + '/' + answerID, true);
//                ob.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//                obj.send();

            }
        </script>
        <ul id="form_test">

            @foreach($Questions as $q)
                <li>
                    <a href="/question/{{$q['id']}}"> {{$q['Question']}} </a>
                    <ul>
                        @foreach($Bundle[$q['id']] as $k => $a)
                            <li id="answer_{{$q['id']}}_{{$a['id']}}"><input type="radio" name="question_{{$q['id']}}" onclick="check({{$q['id']}}, {{$a['id']}}, {{$BundleAnswers[$q['id']]}})" />{{$a['Detail']}}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach

        </ul>
        <a href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    </div>

@endsection