@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <img src="{{'/images/imageQuestion/' . $Photo}}" width="500px" height="500px"/>
        <ul>
            @foreach($Answers as $a)
                <li>
                    {{$a['Detail']}}
                </li>
            @endforeach

        </ul>
        <a href="/admin/addanswer/{{$QuestionID}}">Thêm câu trả lời</a>
    </div>

@endsection