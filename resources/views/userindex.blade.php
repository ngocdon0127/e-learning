@extends('layouts.master')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
<ul class="list-group">
    @foreach($Posts as $p)
        <li class="list-group-item">
            <a href="/post/{{$p['id']}}">
                <img class='img-responsive' src="/images/imagePost/{{$p['Photo']}}" />
                <p>
                    {{$p['Title']}}
                </p>
                <p>
                    {{$p['Description']}}
                </p>
            </a>
        </li>
    @endforeach
</ul>
<div class="row">{!! $Posts->render() !!}</div>

@endsection