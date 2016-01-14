@extends('layouts.main')
@section('head.title')
    Course {{$Title}}
@endsection
@section('body.content')
    <h1 class="title">Chủ đề : {{$Title}}</h1>
    <ul class="list-group">
        @foreach ($posts as $key => $value)
            <li class="list-group-item list-group-item-success">
                <a href="/post/{{$value['id']}}">{{$value['Title']}}</a>
                <span class="badge badge-span">Hiện có {{$NumQuestions[$value['id']]}} câu hỏi</span>
            </li>
        @endforeach
    </ul>
    @if ((auth()->user()) && (auth()->user()->admin == 1))
        <a class="col-xs-12 btn btn-primary" href="{{route('course.edit', $CourseID)}}">Sửa thông tin khóa học</a>
        <a class="col-xs-12 btn btn-primary" href="/admin/addpost">Thêm bài đăng mới</a>
        <button class="col-xs-12 btn btn-danger" href="" onclick="del()">Xóa khóa học này</button>
        <script type="text/javascript">           
            function del(){
                if (confirm('Xác nhận xóa?') == true){
                    window.location = '/admin/course/{{$CourseID}}/delete';
                }
            }
        </script>
    @endif
@endsection

