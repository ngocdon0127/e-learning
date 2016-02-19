@extends('layouts.main')
@section('head.title')
    Evangels English
@endsection
@section('body.content')
	@if ($count > 0)
	<h2 class="title">Danh sách thành viên lớp: {{$stdList[0]->classname}}</h2>
	@endif
		<div class="container-fluid">
		<div class="row">
			<div class="col-md-6"><h4><strong>Tên thành viên</strong></h4></div>
			<div class="col-md-6"><h4><strong>Thời gian online</strong></h4></div>		    		
		</div>
			@foreach($stdList as $std)
				<div class="row">
					<div class="col-md-6"><h4>{{ $std->name }}</h4></div>
					<div class="col-md-6"><h4>{{ $std->TotalHoursOnline }}</h4></div>		    		
				</div>
			@endforeach
		</div>
	<div class="col-md-12">
		<a class="btn btn-primary" href="{{route('subadmin.addmembers', $id)}}" role="button">Add member</a>
		<a class="btn btn-danger" data-toggle="modal" href='#modal-id'>Delete Class</a>
		<div class="modal fade" id="modal-id">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Cảnh báo</h4>
					</div>
					<div class="modal-body">
						Xóa lớp học này nhá?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a class="btn btn-danger" href="{{route('subadmin.deleteclass',$id)}}" style="margin-bottom: 0px;">Okie</a>
					</div>
				</div>
			</div>
		</div>
		
	</div>
@endsection