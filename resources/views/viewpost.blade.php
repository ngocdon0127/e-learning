@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <img src="{{'/images/imagePost/' . $Photo}}" width="500px" height="500px"/>
        <ul>
            @foreach($Questions as $q)
                <li>
                    <a href="/question/{{$q['id']}}"> {{$q['Question']}} </a>
                </li>
            @endforeach

        </ul>
        <a href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    </div>

@endsection