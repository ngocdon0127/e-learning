@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
<div class="container-fluid">
    <h2 class="title">Câu hỏi</h2>
    <li class="list-group-item img-responsive">
        <img src="{{'/images/imageQuestion/' . $Photo}}"/>
    </li>
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
    <a class="btn btn-info" href="/admin/addanswer/{{$QuestionID}}">Thêm câu trả lời</a>
    
    @endif
    </div>
@endsection