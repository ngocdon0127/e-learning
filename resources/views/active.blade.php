@extends('layouts.main')
@section('head.title')
	Active
@endsection
@section('body.content')
<div class="container-fluid">
	{!! Form::open(['name' => 'activeForm', 'route' => ['user.postactive']]) !!}
	<div class="form-group">
		{!! Form::label('key', 'Nhập key trên thẻ cào : ',['class' => 'control-label']) !!}
		{!! Form::text('key', '', ['class'=>'form-control', 'placeholder'=>'Key gồm có 10 ký tự.']) !!}
	</div>
	<div class="form-group">
		{!! Form::text('UserID', auth()->user()->getAuthIdentifier(), ['style'=>'display: none', 'readonly' => 'readonly']) !!}
	</div>
	{!! Form::submit('Active', ['class' => 'btn btn-primary']) !!}
	{!! Form::close() !!}
	@if (isset($result))
	<div class="form-group">
		<p>{{$result}}</p>
	</div>
	@endif
	<div class="form-group control-label">
	@if (App\User::find(auth()->user()->getAuthIdentifier())['admin'] == 1)
		<p>Admin được sử dụng web với full quyền lợi VIP, forever :)))</p>
	@elseif (App\ConstsAndFuncs::is_vip(auth()->user()->getAuthIdentifier()))
		<p>Bạn đang là VIP. Bạn có thể nhập thêm mã thẻ, thời gian dùng VIP sẽ được cộng dồn.</p>
	@endif
	</div>
</div>
@endsection