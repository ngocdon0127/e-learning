@extends('layouts.main')
@section('head.title')
    Evangels English
@endsection
@section('body.content')
	<h2 class="title">Danh sách lớp học: </h2>
	<ul class="list-group">
		@foreach($classes as $cl)
	    	<li class="list-group-item list-group-item-warning"><a href="{{route('subadmin.viewclass',$cl->id)}}">{{$cl->classname}}</a></li>
		@endforeach
	</ul>
 	@if ((auth()->user()) && (auth()->user()->admin == 1))
		<a href="{{route('subadmin.addclass')}}" class="btn btn-primary">Add Class</a>
	 @endif
@endsection

