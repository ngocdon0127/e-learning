@extends('layouts.main')
@section('head.title')
    Main Page
@endsection

@section('body.sidebar')
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row">
			@foreach($post as $p)
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">	
				<a href="{{route('user.viewpost', $p['id'])}}">
			        <div class="imagepost">
			            @if($p['FormatID'] == '1')
			                <img class='img-responsive' src="http://www.evangelsenglish.com/images/imagePost/Post_16_89.jpg" />
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
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="background-color: green; height: 200px;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="background-color: red; height: 100px;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div style="background-color: #90E88E; height: 300px;"></div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div style="background-color: #90E88E; height: 300px;"></div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div style="background-color: #90E88E; height: 300px;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div style="background-color: yellow; height: 50px;"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 300px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 300px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 300px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div style="background-color: orange; height: 300px;"></div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div style="background-color: orange; height: 300px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div style="background-color: pink; height: 50px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
				</div>
				<div class="row" style="padding-top: 5px;">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
				</div>
				<div class="row" style="padding-top: 5px;">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<div style="background-color: brown; height: 60px;"></div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				
			</div>
		</div>
	</div>
@endsection