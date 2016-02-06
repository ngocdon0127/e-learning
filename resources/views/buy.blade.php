@extends('layouts.main')
@section('head.title')
	TEC Club
@endsection
@section('head.css')
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
@endsection
@section('body.content')
<div class="title" style="font-size: 60px; margin-bottom: 40px; font-family: 'Lato'; font-weight: bold;">We're working on it...</div>
<a href="{{route('user.getactive')}}" class="btn btn-info">If you've already had a license key, click me.</a>
@endsection