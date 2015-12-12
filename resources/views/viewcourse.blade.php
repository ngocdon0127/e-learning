@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <h1 class="title">Chủ đề : {{$Title}}</h1>
    <ul class="list-group">
        @foreach ($posts as $key => $value)
            <li class="list-group-item list-group-item-success">
                <a href="/post/{{$value['id']}}">{{$value['Title']}}</a>
                <span class="badge badge-span">Hiện có {{$CountPost}} bài đăng</span>
            </li>
        @endforeach
    </ul>
    @if ((auth()->user()) && (auth()->user()->admin == 1))
    <a class="btn btn-info" href="/admin/addpost">Thêm Post</a>
    @endif
@endsection

