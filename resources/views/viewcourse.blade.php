@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <div class="title">{{$Title}}</div>
        <ul>
            @foreach ($posts as $key => $value)
                <li><a href="/post/{{$value['id']}}">{{$value['Question']}}</a></li>
            @endforeach
        </ul>
        <a href="/admin/addpost">Thêm câu hỏi</a>
    </div>

@endsection

