@extends('layouts.main')
@section('head.title')
    Evangels English
@endsection
@section('head.css')
    <link rel="stylesheet" type="text/css" href="/css/userindex.css">
@endsection
@section('body.content')

<!-- <ul class="list-group">
    @foreach($Posts as $p)
        <li class="active" style="list-style-type:none; padding-top: 10px">
            <a style="text-decoration: none; font-size: 20px;" href="/post/{{$p['id']}}">
                @if($p['FormatID'] == '1')
                <img class='img-responsive' src="/images/imagePost/{{$p['Photo']}}" />
                @elseif($p['FormatID'] == '2')
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$p['Video']}}" frameborder="0" allowfullscreen></iframe>
                </div>
                @endif
                <p>
                    {{$p['Title']}}
                </p>
                <p>
                    {{$p['Description']}}
                </p>
            </a>
        </li>
        </br>
    @endforeach
</ul>
 -->
@foreach($Posts as $p)
<div class="userindexpost">
    <a href="{{route('user.viewpost', $p['id'])}}">
        <h3 class="titlepost">
            {{$p['Title']}}
        </h3>
        <div class="imagepost">
            @if($p['FormatID'] == '1')
                <img class='img-responsive' alt="{{ $p['Title'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imagePost/{{$p['Photo']}}" />
                @elseif($p['FormatID'] == '2')
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$p['Video']}}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endif
        </div>
        <p class="descriptionpost">
            {{$p['Description']}}
        </p>
    </a>
</div>
@endforeach


@if ($Posts->toArray()['last_page'] < 5)
<div class="row">{!! $Posts->render() !!}</div>
@else
    <?php $Posts = $Posts->toArray(); ?>
    @if ($Posts['last_page'] > 1)
    <div class="row">
        <ul class="pagination">
            <li class="disabled"><span>Page {{ $Posts['current_page'] }} of {{ $Posts['last_page'] }}</span></li>
        @if ($Posts['current_page'] <= 1)
            <li class="disabled"><a href="/?page=1"><span class="glyphicon glyphicon-backward"></span></a href="/?page=1"></li>
            <li class="disabled"><span class="glyphicon glyphicon-chevron-left"></span></li>
        @else
            <li><a href="/?page=1"><span class="glyphicon glyphicon-backward"></span></a href="/?page=1"></li>
            <li><a href="/?page={{$Posts['current_page'] - 1}}" rel="prev"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
        @endif
        <?php $index = $Posts['current_page'] - 1;?>
            @if ($index >= 1)
            <li><a href="/?page={{$index}}">{{$index}}</a></li>
            @endif
        <li class="active"><span>{{$Posts['current_page']}}</span></li>
        <?php $index = $Posts['current_page'] + 1;?>
            @if ($index <= $Posts['last_page'])
                <li><a href="/?page={{$index}}">{{$index}}</a></li>
            @endif
        @if ($Posts['current_page'] >= $Posts['last_page'])
            <li class="disabled"><span class="glyphicon glyphicon-chevron-right"></span></li>
            <li class="disabled"><a href="/?page={{$Posts['last_page']}}"><span class="glyphicon glyphicon-forward"></a></li>
        @else
            <li><a href="/?page={{$Posts['current_page'] + 1}}" rel="next"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
            <li><a href="/?page={{$Posts['last_page']}}"><span class="glyphicon glyphicon-forward"></span></a></li>
        @endif
        </ul>
    </div>
    @endif
@endif

@endsection
@section('body.navright')
    <div class="panel panel-default">
        <div class="panel-heading">
            Xem nhiều nhất
        </div>
        <div class="panel-body" style="overflow: auto">
        @foreach($newpost as $np)
        <a style="text-decoration: none;" href="{{route('user.viewpost',$np['id'])}}">
           <blockquote>
               @if($np['FormatID'] == '1')
                   <img class="img-responsive" alt="{{ $np['Title'] . ' - Evangels English - '}}{{$_SERVER['HTTP_HOST']}}" src="/images/imagePost/{{$np['Photo']}}" />
               @elseif($np['FormatID'] == '2')
               <div class="embed-responsive embed-responsive-4by3">
                   <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$np['Video']}}" frameborder="0" allowfullscreen></iframe>
                </div>
               @endif
                <h4>{{$np['Title']}}</h4>
                <h6>{{$np['Description']}}</h6>
           </blockquote>
        </a>
        @endforeach
        </div>
    </div>
@endsection
