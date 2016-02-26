@extends('layouts.main')
@section('head.title')
	Course {{$Title}} - Evangels English
@endsection
@section('body.content')
	<h1 class="title">Chủ đề : {{$Title}}</h1>
	<ul class="list-group">
		@foreach ($posts as $key => $value)
			@if ($value['Hidden'] == 0)
			<li class="list-group-item list-group-item-info">
			@else
			<li class="list-group-item list-group-item-warning">
			@endif
				<div>
					<a href="{{route('user.viewpost',$value['id'])}}">{{$value['Title'] . ($value['Hidden'] == 1 ? ' (ẩn)' : '')}}</a>
				</div>
				<div>
					<span class="badge badge-span">Hiện có {{$NumQuestions[$value['id']]}} câu hỏi</span>
				</div>
			</li>
		@endforeach
	</ul>
	@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
		<a class="col-xs-12 btn btn-primary" href="{{route('course.edit', $CourseID)}}">Sửa thông tin khóa học</a>
		<a class="col-xs-12 btn btn-primary" href="{{route('admin.addpost')}}">Thêm bài đăng mới</a>
		<a class="col-xs-12 btn btn-danger" data-toggle="modal" href='#modal-id'>Xóa khóa học này</a>
		<div class="modal fade" id="modal-id">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Cảnh báo:</h4>
					</div>
					<div class="modal-body">
						<h6>Xác nhận xóa?</h6>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a class ="btn btn-primary" href="{{route('admin.destroycourse',$CourseID)}}">Xóa</a>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

