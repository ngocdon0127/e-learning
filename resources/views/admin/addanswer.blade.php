@extends('layouts.main')
@section('head.title')
    ADD ANSWER
@endsection
@section('body.content')
    <div class="container col-md-6">
       <!-- <div class="container"> -->
        <h1 class="title">Thêm câu trả lời mới</h1>
        <div class="container">{!! Form::open(['url' => '/admin/addanswer/'.'{{QuestionID}}','class'=>'form-horizontal']) !!}
             <!--        {!! Form::label('Detail', 'Câu trả lời: ') !!}
            {!! Form::text('Detail') !!} -->
            
            <div class="form-group col-md-9">
                       {!! Form::label('Detail', 'Câu trả lời: ',['class'=>' control-label']) !!}
                       <div class="">
                           {!! Form::textarea('Detail','',['class'=>'form-control']) !!}
                       </div>
                   </div>
            <!-- {!! Form::checkbox('Logical') !!} -->
            <!-- <input type="text" value="{{$QuestionID}}" style="display: none" readonly name="QuestionID" /> -->
            <!-- {!! Form::submit('Thêm') !!} -->
               <div class="col-sm-10">
                       <div class="checkbox">
                           <label class="checkbox">{!! Form::checkbox('Logical') !!} <strong>Chọn nếu là đáp án đúng</strong></label>
                       </div>
                   <!-- <div class="col-sm-10"> -->
                   <input type="text" value="{{$QuestionID}}" style="display: none" readonly name="QuestionID" />
                       {!! Form::submit('Thêm',['class' => 'btn btn-info']) !!}
                   </div>
            {!! Form::close() !!}
            </div>

    <div class="container">
           <ul class="list-group col-md-9">
               @foreach($Answers as $answer)
                   <li class="list-group-item list-group-item-info">{{$answer['Detail']}}
                       @if ($answer['Logical'] != 0)
                           <span class="badge badge-span">Đúng</span>
                       @endif
                   </li>
               @endforeach
               <li class="list-group-item">
                   <img src = "{{'/images/imageQuestion/' . $Photo}}" />
               </li>
           </ul>
       </div>
       </div>
@endsection
