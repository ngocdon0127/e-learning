@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
    <div class="container col-md-6">
        <ul class="list-group">
            @foreach($Answers as $a)
                <li class="list-group-item list-group-item-info">
                    {{$a['Detail']}}
                </li>
            @endforeach
               <li class="list-group-item">
               <img src="{{'/images/imageQuestion/' . $Photo}}"/>    
           </li>

        </ul>
        <a class="btn btn-info" href="/admin/addanswer/{{$QuestionID}}">Thêm câu trả lời</a>
    </div>

@endsection