@extends('layouts.main')
@section('head.title')
	ADD ANSWER
@endsection
@section('body.content')
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
<h1>Thêm câu trả lời mới</h1>
{!! Form::open(['url' => '/admin/addanswer/'.'{{PostID}}']) !!}
{!! Form::label('Detail', 'Câu trả lời: ',['class' => 'cotrol-label']) !!}
{!! Form::text('Detail','',['id' => 'Detail', 'class'=> 'form-control']) !!}
{!! Form::checkbox('Logical') !!}
<input type="text" value="{{$PostID}}" style="display: none" readonly name="PostID" />
{!! Form::submit('Thêm',['class'=>'btn btn-primary btn-sm']) !!}
{!! Form::close() !!}
@endsection
