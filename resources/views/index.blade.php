@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
<div class="container-fluid">
    <div class="col-md-offset-3 col-md-6">
           <h1 class="title">Các khóa học</h1>
           <ul class="list-group">
           @foreach (\App\Courses::all()->toArray() as $course)
               <li class="list-group-item list-group-item-warning"><a href="/course/{{$course['id']}}">{{$course['Title']}}</a></li>
           @endforeach
           </ul>
           @if ((auth()->user()) && (auth()->user()->admin == 1))
			<a href="/admin/addcourse" class="btn btn-info">Add Course</a>
		 @endif
       </div>
</div>
  <!--   <div class="container">
        <ul>
        @foreach ($allcourse as $course)
            <li><a href="/course/{{$course['id']}}">{{$course['Title']}}</a></li>
        @endforeach
        </ul>
        <a href="/admin/addcourse">Add Course</a>
    </div> -->

@endsection