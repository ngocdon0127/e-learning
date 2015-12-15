@extends('layouts.main')
@section('head.title')
    Post {{$Title}}
@endsection
@section('body.content')
    <h1 class="title">Ảnh của post</h1>
    <li class="list-group-item">
        <img class="img-responsive" src="{{'/images/imagePost/' . $Photo}}" />
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
        function check(questionID, answerID, trueAnswerID){
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

                var resultText = 'Bạn trả lời đúng ' + score + '/' + maxScore + ' câu.\n';
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
                alert(resultText);
            }
//                obj.open('GET', '/ajax/checkanswer/' + questionID + '/' + answerID, true);
//                ob.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//                obj.send();

        }
    </script>
    <h1 class="title">Các câu hỏi</h1>
    <ul id="form_test" class="list-group">
        <?php $count_answer=1;?>
        @foreach($Questions as $q)
            <h2 class="title">Câu hỏi số <?php echo $count_answer++; ?>:</h2>
                <a style="text-decoration: none;" href="/question/{{$q['id']}}"><h4>{{$q['Question']}} : {{$q['Description']}}</h4></a>
            
            <li class="list-group-item list-group-item-info">
                <img class="img-responsive" src="/images/imageQuestion/{{$q['Photo']}}" />
            </li>
           <ul class="list-group" id="ul_question_{{$q['id']}}">
                @foreach($Bundle[$q['id']] as $k => $a)
                    <li id="answer_{{$q['id']}}_{{$a['id']}}" class="list_answer"  onclick="check({{$q['id']}}, {{$a['id']}}, {{$BundleAnswers[$q['id']]}})" style="cursor: pointer">
                        <input type="checkbox" id="radio_answer_{{$q['id']}}_{{$a['id']}}" name="question_{{$q['id']}}"/>
                       <label for="radio_answer_{{$q['id']}}_{{$a['id']}}" class="answer_content">{{$a['Detail']}}</label>
                    </li>

                    <div class="clear"></div>
                @endforeach
            </ul>

        @endforeach
    </ul>
@endsection