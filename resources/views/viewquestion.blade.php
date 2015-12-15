@extends('layouts.main')
@section('head.title')
    Question {{$QuestionID}}
@endsection
@section('body.content')
    <h2 class="title">Câu hỏi: {{$Question}}</h2>
    <li class="list-group-item ">
        <img class= "img-responsive" src="{{'/images/imageQuestion/' . $Photo}}"/>
    </li>
    <h2 class="title">{{$Description}}</h2>
    <h2 class="title">Đáp án</h2>
    <ul class="list-group">
        @foreach($Answers as $a)
          <li class="list-group-item list-group-item-info">
              {{$a['Detail']}}
          </li>
          <div class="clear"></div>
        @endforeach
    </ul>
    @if ((auth()->user()) && (auth()->user()->admin == 1))
    <a class="btn btn-info" href="{{route('question.edit', $QuestionID)}}">Sửa câu hỏi</a>
    <a class="btn btn-info" href="{{route('answer.edit', $QuestionID)}}">Sửa đáp án</a>
    <button class="btn btn-info" href="" onclick="del()">Xóa câu hỏi này</button>
    <script type="text/javascript">
        function del(){
            if (confirm('Xác nhận xóa?') == true){
                window.location = '/admin/question/{{$QuestionID}}/delete';
            }
        }
    </script>
    @endif
@endsection