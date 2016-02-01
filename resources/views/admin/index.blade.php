@extends('layouts.main')
@section('head.title')
    Admin
@endsection
@section('body.content')
	<h1 class="title">Các khóa học</h1>
	<ul class="list-group">
	@foreach (\App\Courses::all()->toArray() as $course)
	    <li class="list-group-item list-group-item-warning"><a href="{{route('admin.viewcourse',$course['id'])}}">{{$course['Title']}}</a></li>
	@endforeach
	</ul>
 	@if ((auth()->user()) && (auth()->user()->admin == 1))
	<a href="{{route('admin.addcourse')}}" class="btn btn-primary">Add Course</a>
	<a href="{{route('admin.addpost')}}" class="btn btn-primary">Add Post</a>
	 @endif
@endsection