<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Main Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin.css">
	<link rel="stylesheet" href="/css/style.css">
	<script type="text/javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.equalheights/1.5.2/jquery.equalheights.min.js"></script>

	<style>
		body{
			background: #f0f0f5;
		}
		.container{
			background: #fff;
		}
		.navbar-default .navbar-nav>li>a {
    		color: #1C2363;
		}

	  	img {
			border-radius: 10px;
			width: 100%;
	  	}
	  	.img-circle{
			margin:5px;
			height: 60px;
			width: 60px;
			float: left;
		}
		.img{
			height: 200px;
			border-radius: 20px;
			cursor: pointer;
		}
		.cover1,.cover2{
			padding : 10px;
			margin-top : 10px;
			border-radius:10px;
			   
		}
		p{
			float: left;
			padding-top: 20px;
   			padding-left: 40px;
   			font-size: 20px;
		}
		li#navbar-button:hover,
		a#dropDown:visited{
			background: #ff66cc;
		}
		button{
			display: block;
		}
	 </style>

</head>
<body>
@include('layouts.header')
@include('layouts.navbar')
	<div class="container">
		<h1 class="text-center title">LUYỆN THI TOEIC </h1>
		<div class="row">
		@foreach(\App\Courses::where('CategoryID','=',4)->get() as $c)
			@foreach(\App\Posts::where('CourseID','=',$c->id)->get() as $p)
				<div class="col-md-4">
					<a id="a_smallLink_{{$p['id']}}" style="text-decoration: none;" href="/post/{{$p['id']}}">
						<img class="img-responsive img" src="/images/imagePost/{{$p['Photo']}}" />
<!-- 						<h4>{{$p['Title']}}</h4>
							<h6>{{$p['Description']}}</h6> -->
							
						
						<img src="images/tom.jpg" alt="" class="img-circle">
							<p>990 Điểm</p>
						
					</a>
				</div>
			@endforeach
		@endforeach
		</div>
	</div>                   
</body>
<script type="text/javascript">
	$(function(){$('.parent div').equalHeights();});
</script> 
</body>
</html>