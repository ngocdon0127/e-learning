@extends('layouts.main')
@section('head.title')
EDIT QUESTION
@endsection
@section('head.css')
<style>
  .control-label{
    text-align: left;
  }
</style>
@endsection
@section('body.content')
   <div class="container-fluid">
        <!-- <div class="col-md-offset-3 col-md-6"> -->
           <h1 class="col-md-offset-3 title">Chỉnh sửa câu hỏi</h1>
       
           {!! Form::model($Question, ['method' => 'PUT', 'name' => 'editQuestionForm', 'route' => ['question.update', $Question['id']], 'class'=>'form-horizontal', 'files' => true]) !!}


               <div class="form-group">
                   {!! Form::label('Question','Question : ',['class' => 'control-label']) !!}
                   {!! Form::text('Question', null,['class'=>'form-control']) !!}
               </div>
               <div class="form-group">
                   {!! Form::label('FormatID', 'Format ID : ',['class' => 'control-label']) !!}
                   {!! Form::select('FormatID',\App\Formats::getColumn('Title'), '', ['class'=>'form-control', 'onclick' => 'this.style.background = "white";', 'onchange' => 'configForm()']) !!}
               </div>
               <div class="form-group" id="divPhoto">
                   {!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
                   {!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif']) !!}
               </div>
               <div class="form-group" id="divVideo">
                   {!! Form::label('Video', 'Link Youtube : ',['class' => 'control-label']) !!}
                   {!! Form::text('Video', null, ['class'=>'form-control']) !!}
               </div>
               <div class="form-group">
                   {!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
                   {!! Form::text('Description', null,['class'=>'form-control']) !!}
               </div>
               <div class="form-group">
                   {!! Form::label('', '',['class' => 'control-label']) !!}
                   {!! Form::label('Error', '',['id' => 'error', 'class' => 'control-label', 'style' => 'display: none;']) !!}
                   </div>
               </div>
               <div class="col-sm-offset-3 col-sm-10">
                   <script type="text/javascript">
                       function ob(x){
                           return document.getElementById(x);
                       }

                       ob('FormatID').value = {{$Question['FormatID']}};

                       function configForm(){
                           switch (ob('FormatID').value){
                               case '1':
                                   ob('divPhoto').style.display = 'block';
                                   ob('divVideo').style.display = 'none';
                                   break;
                               case '2':
                                   ob('divPhoto').style.display = 'none';
                                   ob('divVideo').style.display = 'block';
                                   break;
                               default:
                                   console.log('dmm');
                           }
                       }

                       configForm();
                       ob('Video').value = "https://www.youtube.com/watch?v=" + "{{ $Question['Video'] }}";

                       function displayError(x){
                           ob('error').style.display = 'block';
                           ob('error').innerHTML = x;
                       }
                       function submitForm(){
                           switch (ob('FormatID').value){
                               case '1':
                                   var acceptedType = ['image/jpeg', 'image/png', 'image/gif'];
                                   //                        console.log('clicked');
                                   var photo = ob('Photo');
                                   if (photo.files.length <= 0){
                                       document.editQuestionForm.submit();
                                       return;
                                   }
                                   var type = photo.files[0].type;
                                   var check = false;
                                   for(i = 0; i < acceptedType.length; i++){
                                       if (type == acceptedType[i]){
                                           check = true;
                                           break;
                                       }
                                   }
                                   if (!check){
                                       //                            console.log('not ok');
                                       displayError('Chỉ chọn file ảnh.');
                                   }
                                   else{
                                       //                            console.log('ok');
                                       if ('size' in photo.files[0]){
                                           console.log(photo.files[0].size);
                                       }
                                       else{
                                           console.log('ko co size');
                                       }
                                       if (photo.files[0].size > 2 * 1024 * 1024){
                                           console.log('size qua lon');
                                           ob('error').style.display = 'block';
                                           displayError('Chỉ chọn file có kích thước tối đa 2 MB.');
                                           return;
                                       }
                                       ob('error').style.display = 'none';
                                       document.editQuestionForm.submit();
                                   }
                                   break;
                               case '2':
                                    if (ob('Video').value.length > 0){
                                    var linkVideo = ob('Video').value;
                                    if ((linkVideo.indexOf('watch?v=') < 0) && (linkVideo.indexOf('youtu.be/') < 0)){
                                      displayError('Link video Youtube không đúng.');
                                      return;
                                    }
                                    $('#error').fadeOut();
                                    document.editQuestionForm.submit();
                                    }
                                    else{
                                        $('#error').fadeOut();
                                        document.editQuestionForm.submit();
                                    }
                                    break;
                                   
                           }
       //                        ob('error').innerHTML = photo.value;
       
                       }
                   </script>
       
                   {!! Form::button('Sửa',['class' => 'btn btn-info', 'onClick' => 'submitForm()']) !!}
               </div>
               <!-- end script -->
       
           {!! Form::close() !!}
           <!-- end form -->
       <!-- </div> -->
   </div>
<!-- end container -->

@endsection