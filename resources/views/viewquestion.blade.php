@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container col-md-6">
        <ul class="list-group">
            <li class="list-group-item">
                <img src="{{'/images/imageQuestion/' . $Photo}}"/>
            </li>
            @foreach($Answers as $a)
                <li class="list-group-item list-group-item-info">
                    {{$a['Detail']}}
                </li>
            @endforeach

        </ul>
        @if ((auth()->user()) && (auth()->user()->admin == 1))
        <a class="btn btn-info" href="/admin/addanswer/{{$QuestionID}}">Thêm câu trả lời</a>
        @endif
    </div>

@endsection