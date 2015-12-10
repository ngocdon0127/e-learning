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
            function check(questionID, answerID){
                var obj = new XMLHttpRequest();
                obj.onreadystatechange = function(){
                    if ((obj.readyState == 4) && (obj.status == 200)){
//                        ob('answer_' + questionID + '_' + answerID).innerHTML = obj.responseText;
                        var id = 'answer_' + questionID + '_' + answerID;
                        var xml = jQuery.parseXML(obj.responseText);
                        console.log(xml.getElementsByTagName('logical')[0].innerHTML);
                        switch (xml.getElementsByTagName('logical')[0].innerHTML) {
                            case '1':
                                ob(id).style.background = 'green';
                                score++;
                                break;
                            case '0':
                                ob(id).style.background = 'red';
                                break;
                            default:
                                ob(id).style.background = 'yellow';
                                break;
                        }
                        ob(id).disabled = true;
                        var set = document.getElementsByName('question_' + questionID);
                        for(i = 0; i < set.length; i++){
                            set[i].disabled = true;
                        }
                        var idTrue = 'answer_' + questionID + '_' + xml.getElementsByTagName('answer')[0].innerHTML;
                        ob(idTrue).style.background = 'green';
                        fill++;
                        if (fill >= maxScore){
                            alert(score);
                        }
                    }
                }
                obj.open('GET', '/ajax/checkanswer/' + questionID + '/' + answerID, true);
//                ob.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                obj.send();

            }
        </script>
        <ul id="form_test">
            @foreach($Questions as $q)
                <li>
                    <a href="/question/{{$q['id']}}"> {{$q['Question']}} </a>
                    <ul>
                        @foreach($Bundle[$q['id']] as $a)
                            <li id="answer_{{$q['id']}}_{{$a['id']}}"><input type="radio" name="question_{{$q['id']}}" onclick="check({{$q['id']}}, {{$a['id']}})"/>{{$a['Detail']}}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach

        </ul>
        <a href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    </div>

@endsection