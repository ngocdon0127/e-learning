@extends('layouts.main')
@section('head.title')
    Question {{$Question['id']}}
@endsection
@section('body.content')
    <h2 class="title">Câu hỏi: {{$Question['Question']}}</h2>
    @if ($Question['FormatID'] == 1)
        @if ($Question['Photo'] != null)
            <li class="list-group-item ">
                <img class= "img-responsive" src="{{'/images/imageQuestion/' . $Question['Photo']}}"/>
            </li>
        @endif
    @elseif($Question['FormatID'] == 2)
        @if ($Question['Video'] != null)
        <iframe class="img-responsive" src="https://www.youtube.com/embed/{{$Question['Video']}}" frameborder="0" allowfullscreen></iframe>
        @endif
    @endif

    <h2 class="title">{{$Question['Description']}}</h2>
    <h2 class="title">Đáp án</h2>
    <ul class="list-group">
        @foreach($Answers as $a)
          <li class="list-group-item list-group-item-info">
              {!! $a['Detail'] !!}
          </li>
          <div class="clear"></div>
        @endforeach
    </ul>
    @if ((auth()->user()) && (auth()->user()->admin == 1))
    <a class="btn btn-primary col-xs-12" href="{{route('question.edit', $Question['id'])}}">Sửa câu hỏi</a>
    <a class="btn btn-primary col-xs-12" href="{{route('answer.edit', $Question['id'])}}">Sửa đáp án</a>
    <a class="btn btn-primary col-xs-12" href="/post/{{$Question['PostID']}}">Quay lại bài đăng</a>
    <button class="btn btn-danger col-xs-12" href="" onclick="del()">Xóa câu hỏi này</button>
    <script type="text/javascript">
        function del(){
            if (confirm('Xác nhận xóa?') == true){
                window.location = '/admin/question/{{$Question['id']}}/delete';
            }
        }
    </script>
    @endif
@endsection