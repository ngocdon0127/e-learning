@extends('layouts.main')
@section('head.title')
    ADD ANSWER
@endsection
@section('body.content')
    <div class="col-sm-offset-3 col-xs-offset-3 col-sm-6 col-xs-6">
        <ul class="list-group">
            <li class="list-group-item">
                <img src = "{{'/images/imageQuestion/' . $Photo}}" />
            </li>
            <ul class="list-group">
                 @foreach($Answers as $answer)
                   <li class="list-group-item list-group-item-info">{{$answer['Detail']}}
                       @if ($answer['Logical'] != 0)
                           <span class="badge badge-span">Đúng</span>
                       @endif
                   </li>
                   <div class="clear"></div>
               @endforeach
            </ul>
        </ul>
        <h1 class="title">Thêm câu trả lời mới</h1>
        <!-- <div class="col-sm-9"> -->
            {!! Form::open(['name' => 'addAnswerForm', 'url' => '/admin/addanswer/' . $QuestionID,'class'=>'control-label']) !!}
             <!--        {!! Form::label('Detail', 'Câu trả lời: ') !!}
            {!! Form::text('Detail') !!} -->
            
            <div class="form-group">
                {!! Form::label('Detail', 'Câu trả lời: ',['class'=>'control-label']) !!}
                    <script type="text/javascript">
                    var count = -1;
                    var minAnswer = 4;
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
                        for(var i = 1; i < childrens.length; i++){
                            var div = childrens[i];
                            div.id = 'divanswer' + i;
                            div.children[0].id = div.children[0].name = 'answer' + i;
                            var radio = div.children[1];
                            radio.id = 'radio' + i;
                            if (radio.checked){
                                resultQuestion = i;
                            }
                            div.setAttribute('class','div_i');
                            div.children[0].setAttribute('class','col-sm-9');
                            radio.setAttribute('class','checked');
                            radio.setAttribute('type','checkbox');
                            div.children[2].setAttribute('class','children btn btn-info');
//                            radio.setAttribute('onclick', 'markAnswer("' + radio.id + '")');
                            if (i > minAnswer - 1)
                                div.children[2].setAttribute('onclick', 'xoa("divanswer' + i + '")');
                        }
//                        console.log(resultQuestion);
                        ob('result').value = resultQuestion;
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
                        var e = document.createElement('input');
                        e.type = 'text';
//                        e.name = 'answer' + count;
//                        e.id = e.name;
                        e.setAttribute('class', 'col-sm-9');
                        var divElement = document.createElement('div');
                        divElement.id = "divanswer" + count;
                        ob('answers').appendChild(divElement);
                        divElement.appendChild(e);
                        var radio = document.createElement('input');
                        radio.type = 'checkbox';
                        radio.name = 'radio_answer';
                        divElement.appendChild(radio);
                        var btnDel = document.createElement('input');
                        btnDel.value = 'Xoa';
                        btnDel.type = 'button';
                        btnDel.setAttribute('onClick','xoa("' + divElement.id + '")');
                        divElement.appendChild(btnDel);
                        updateID();
                    }

                    function submitForm(){
                        updateID();
//                        console.log(count);
//                        console.log(resultQuestion);
                        if (resultQuestion > -1){
                            document.addAnswerForm.submit();
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
                       </script>
                   </div>
                   <input type="button" value="+" onclick="add()">
                </div>
            </div>


                   <!-- <div class="col-sm-10"> -->
                <input type="text" value="{{$QuestionID}}" style="display: none" readonly name="QuestionID" />
                {!! Form::button('Thêm',['class' => 'btn btn-info', 'onclick' => 'submitForm()']) !!}
            {!! Form::close() !!}
        <!-- </div> -->


    </div>
@endsection
//             