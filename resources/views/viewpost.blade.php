@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container col-md-6">
        <ul class="list-group">
			<li class="list-group-item">
                <img src="{{'/images/imagePost/' . $Photo}}" />
            </li>
            @foreach($Questions as $q)
                <li class="list-group-item list-group-item-info">
                    <a href="/question/{{$q['id']}}"> {{$q['Question']}} </a>
                    <img src="/images/imageQuestion/{{$q['Photo']}}" />
                    <ul>
                        @foreach($Bundle[$q['id']] as $a)
                            <li id="answer_{{$q['id']}}_{{$a['id']}}"><input type="radio" name="question_{{$q['id']}}" onclick="check({{$q['id']}}, {{$a['id']}})"/>{{$a['Detail']}}</li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
        <a class="btn btn-info" href="/admin/addquestion/{{$PostID}}">Thêm câu hỏi</a>
    </div>

@endsection