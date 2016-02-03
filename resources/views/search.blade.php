@extends('layouts.main')
@section('head.title')
	Evangels English
@endsection
@section('body.content')

<h2>Các Post phù hợp với từ khóa: {{$Hashtags}}</h2>
<ul class="list-group">
	@foreach($Posts as $p)
		<li class="active" style="list-style-type:none; padding-top: 10px">
			<a style="text-decoration: none; font-size: 20px;" href="{{route('user.viewpost',$p['id'])}}">
				<img class='img-responsive' src="/images/imagePost/{{$p['Photo']}}" />
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

@endsection
