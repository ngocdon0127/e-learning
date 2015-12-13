@extends('layouts.master')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
<ul>
    @foreach($Posts as $p)
        <li>
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

@endsection