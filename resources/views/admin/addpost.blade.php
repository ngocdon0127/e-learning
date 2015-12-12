@extends('layouts.main')
@section('head.title')
    ADD POST
@endsection
@section('body.content')
          <div class="container-fluid"> 
           <!-- <div class="col-md-offset-3 col-md-6 "> -->
              <h1 class="title">Thêm bài viết mới</h1>
              {!! Form::open(['name' => 'addPostForm', 'url' => '/admin/addpost', 'role'=>'form', 'files' => true]) !!}
              <div class="form-group">
                  {!! Form::label('CourseID', 'Course ID : ',['class' => 'control-label']) !!}
                  {!! Form::select('CourseID', \App\Courses::getColumn('Title'), null, ['class'=>'form-control', 'onclick' => 'this.style.background = "white"']) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('Photo', 'Photo : ',['class' => 'control-label']) !!}
                  {!! Form::file('Photo', ['accept' => 'image/jpeg, image/png, image/gif','type'=>'file','class'=>'file']) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('FormatID', 'Format ID : ',['class' => 'control-label']) !!}
                  {!! Form::select('FormatID',\App\Formats::getColumn('Title'), null, ['class'=>'form-control', 'onclick' => 'this.style.background = "white"']) !!}
              </div>
              <div class="form-group">
                  {!! Form::label('Title','Title : ',['class' => 'control-label']) !!}
                  {!! Form::text('Title','',['class'=>'form-control']) !!}
              </div>
               <div class="form-group">
                  {!! Form::label('Description', 'Description : ',['class' => 'control-label']) !!}
                  {!! Form::text('Description','',['class'=>'form-control']) !!}
              </div>    
              <div class="form-group">
                  {!! Form::label('', '',['class' => 'control-label']) !!}
                  {!! Form::label('Error', '',['id' => 'error', 'class' => 'control-label', 'style' => 'display: none;']) !!}
              </div>
              <!-- <div class="col-sm-offset-3 col-xs-offset-3 col-sm-10"> -->
                 <script type="text/javascript">
                     function ob(x){
                         return document.getElementById(x);
                     }
                     function submitForm(){
                         var courseob = ob('CourseID');
                         if (courseob.value <= 0){
                             courseob.style.background = '#ff5050';
                             return;
                         }
                         var formatob = ob('FormatID');
                         if (formatob.value <= 0){
                             formatob.style.background = '#ff5050';
                             return;
                         }
                         var acceptedType = ['image/jpeg', 'image/png', 'image/gif'];
             //                        console.log('clicked');
                         var photo = ob('Photo');
                         var type = ob('error').innerHTML = photo.files[0].type;
                         var check = false;
                         for(i = 0; i < acceptedType.length; i++){
                             if (type == acceptedType[i]){
                                 check = true;
                                 break;
                             }
                         }
                         if (!check){
             //                            console.log('not ok');
                             ob('error').style.display = 'block';
                             ob('error').innerHTML = 'Chỉ chọn file ảnh.';
                         }
                         else{
             //                            console.log('ok');
                             ob('error').style.display = 'none';
                             document.addPostForm.submit();
                         }
             //                        ob('error').innerHTML = photo.value;
             
                     }
                 </script>
                 {!! Form::button('Thêm',['class' => 'btn btn-info', 'onClick' => 'submitForm()']) !!}
              <!-- </div> -->
              {!! Form::close() !!}
              <!-- </div> -->
    </div>

@endsection