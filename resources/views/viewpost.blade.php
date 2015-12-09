@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <img src = "{{'/images/imagePost/' . $Photo}}" />
        <ul>
            @foreach($Answers as $answer)
                <li>{{$answer['Detail']}}
                    @if ($answer['Logical'] != 0)
                        <span>Đúng</span>
                    @endif
                </li>
            @endforeach

        </ul>
        <a href="/admin/addanswer/{{$PostID}}">Thêm câu trả lời</a>
    </div>

@endsection