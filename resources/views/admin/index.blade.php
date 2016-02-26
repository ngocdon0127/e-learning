@extends('layouts.main')
@section('head.title')
	Admin
@endsection
@section('body.content')
	<h1 class="title">Các khóa học</h1>
	<ul class="list-group">
	@foreach (\App\Courses::all()->toArray() as $course)
		@if ($course['Hidden'] == 1)
		<li class="list-group-item list-group-item-warning"><a href="{{route('admin.viewcourse',$course['id'])}}">{{$course['Title'] . ' (ẩn)'}}</a></li>
		@else
		<li class="list-group-item list-group-item-info"><a href="{{route('admin.viewcourse',$course['id'])}}">{{$course['Title']}}</a></li>
		@endif
	@endforeach
	</ul>
	@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
	<a href="{{route('admin.addcourse')}}" class="btn btn-primary">Add Course</a>
	<a href="{{route('admin.addpost')}}" class="btn btn-primary">Add Post</a>
	 @endif
@endsection