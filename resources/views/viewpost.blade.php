@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container">
        <ul>
            @foreach(\App\Answers::where('PostID', '=', $PostID)->get()->toArray() as $answer)
                <li>{{$answer['Detail']}}
                    @if ($answer['Logical'] != 0)
                        <span>Đúng</span>
                    @endif
                </li>
            @endforeach
            @foreach(\App\Posts::where('id', '=', $PostID)->get()->toArray() as $answer)
                <li><img src = "{{'/images/imagePost/' . $answer['Photo']}}" />
                </li>
            @endforeach

        </ul>
    </div>

@endsection