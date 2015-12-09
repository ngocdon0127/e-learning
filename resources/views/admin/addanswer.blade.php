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
        <h1>Thêm câu trả lời mới</h1>
        {!! Form::open(['url' => '/admin/addanswer/'.'{{PostID}}']) !!}
        {!! Form::label('Detail', 'Câu trả lời: ') !!}
        {!! Form::text('Detail') !!}
        {!! Form::checkbox('Logical') !!}
        <input type="text" value="{{$PostID}}" style="display: none" readonly name="PostID" />
        {!! Form::submit('Thêm') !!}
        {!! Form::close() !!}
    </div>

@endsection
