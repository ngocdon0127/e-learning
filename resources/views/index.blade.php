@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <ul>
        @foreach ($allcourse as $course)
            <li><a href="/course/{{$course['id']}}">{{$course['Title']}}</a></li>
        @endforeach
        </ul>
        <a href="/admin/addcourse">Add Course</a>
    </div>

@endsection