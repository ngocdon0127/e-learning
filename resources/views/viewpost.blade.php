@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container col-md-6">
        <ul class="list-group">
            @foreach($Questions as $q)
                <li class="list-group-item list-group-item-info">
                    <a href="/question/{{$q['id']}}"> {{$q['Question']}} </a>
                </li>
            @endforeach

            <li class="list-group-item">
                <img src="{{'/images/imagePost/' . $Photo}}" />
            </li>
        </ul>
        <a class="btn btn-info" href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    </div>

@endsection