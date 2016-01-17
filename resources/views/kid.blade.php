
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
		body,header{
			background: #66ccff;
			    /*background: #ff66cc;*/
		}
		.navbar-default .navbar-nav>li>a {
    		color: #1C2363;
		}

	  	img {
			border-radius: 10px;
			width: 100%;
		   /*height: 400px;          */
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
		.navbar,
		.cover1,
		li#navbar-button:hover,
		a#dropDown:visited{
			background: #ff66cc;
		}
		.cover2{
			background: #cc33ff;
		}
		button{
			display: block;
		}
	 </style>

</head>
<body>
@include('layouts.header')
@include('layouts.navbar')
<audio>
   <source src="/audio/demen.mp3"></source>
</audio>
<div class="container">
  <div class="row parent">
	  <div class="col-md-8">
		<div class="cover1">
			<p>GIỚI THIỆU CHUNG VỀ KHÓA HỌC</p>
			<img src="/images/kid.jpg" alt="" class="img-responsive">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti reprehenderit reiciendis, sunt fuga officiis voluptatum molestias. Voluptates fugiat aliquam, ipsam hic officia non, id, facilis nisi itaque, rerum incidunt minima expedita explicabo laborum. Ea tempora harum nemo eos quos in nobis quibusdam, dignissimos voluptates, optio eaque atque! Error laborum qui sit, accusamus repellat totam optio neque aperiam possimus quod, voluptates sed? Quaerat architecto assumenda ut odit excepturi optio, fugiat minus, facilis. Aspernatur iste cupiditate est, quis sint. Provident facilis iste assumenda est nihil nemo qui tempore similique suscipit. Blanditiis doloremque, a rem aspernatur assumenda obcaecati qui laborum, odio ullam sed.</p>
		</div>
	  </div>
	  <div class="col-md-4" >
		 <div class="cover2" style="overflow: auto;">
		 	<p>XEM NHIỀU NHẤT</p>
			@foreach($newpost as $np)
			 <a id="a_smallLink_{{$np['id']}}" style="text-decoration: none;" href="/post/{{$np['id']}}">
				<blockquote>
					@if($np['FormatID'] == '1')
						<img class="img-responsive" src="/images/imagePost/{{$np['Photo']}}" />
					@elseif($np['FormatID'] == '2')
						<iframe class="img-responsive" src="https://www.youtube.com/embed/{{$np['Video']}}" frameborder="0" allowfullscreen></iframe>
					@endif
					<h4>{{$np['Title']}}</h4>
					<h6>{{$np['Description']}}</h6>
				</blockquote>
			</a>
			@endforeach
		 </div>
	  </div>  
  </div>
</div>
	<div class="container">
		<h1>CÁC POST GỢI Ý</h1>
		<div class="row">
		@foreach(\App\Courses::where('CategoryID','=',2)->get() as $c)
			@foreach(\App\Posts::where('CourseID','=',$c->id)->get() as $p)
				<div class="col-md-3">
					<a id="a_smallLink_{{$p['id']}}" style="text-decoration: none;" href="/post/{{$p['id']}}">
						<img class="img-responsive img" src="/images/imagePost/{{$p['Photo']}}" />
						<h4>{{$p['Title']}}</h4>
						<h6>{{$p['Description']}}</h6>
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
<script>
	var audio = $("audio")[0];
	$(".img-responsive").mouseenter(function() {
		audio.play();
	});
	$('.img-responsive').mouseout(function(){
		audio.pause();
	});

</script>
</html>