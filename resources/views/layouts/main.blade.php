<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('head.title')</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/upload_video.css">
	<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans' type='text/css'>
	<!-- <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'> -->
	<link href='https://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/css/admin.css">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<meta name="description" content="Evangels English. Know English. Know the World" />
	<meta name="keywords" content="learn english online, learning online, english, online, learning" />
	<meta name="author" content="TEC" />
	<meta name="copyright" content="TEC" />
	<meta property="fb:app_id" content="1657402167852948">
	<meta property="og:site_name" content="Evangels English" />
	<meta property="og:type" content="website" />
	<meta property="og:locale" content="vi_VN" />
	<meta property="og:url" content="http://{{$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']}}" />
	@if ((stripos($_SERVER['REQUEST_URI'], 'post') !== false) && isset($Photo))
	<meta property="og:image" content="http://{{$_SERVER['HTTP_HOST']}}/images/imagePost/{{$Photo}}" />
	<meta property="og:title" content="{{$Title}} - Evangels English" />
	@else
	<meta property="og:image" content="http://{{$_SERVER['HTTP_HOST']}}/images/evangelsenglish.png" />
	<meta property="og:title" content="Evangels English. Know English. Know the World" />
	@endif
	<meta property="og:description" content="Evangels English. Know English. Know the World" />
	@if (auth() && (auth()->user()))
	<script type="text/javascript">
		var logout = 0;
		function markTimeOnline(isUnload) {
			$.ajax({
				url: "/timeonline",
				type: "POST",
				beforeSend: function (xhr) {
					var token = $('meta[name="_token"]').attr('content');

					if (token) {
						return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				data: {UserID: {!! auth()->user()->getAuthIdentifier() !!}, unload: isUnload },
				success: function (data) {
					console.log(data);
				}, error: function () {
					console.log("error!!!!");
				}
			}); //end of ajax
		}
		window.onbeforeunload = closingCode;
		function closingCode(){
			if (logout == 0)
				markTimeOnline(1);
			return null;
		}
	</script>
	@endif
	<script type='text/javascript'>
		function saveIP() {
			console.log('start ajax');
			$.ajax({
				url: "/trackip",
				type: "POST",
				beforeSend: function (xhr) {
					var token = $('meta[name="_token"]').attr('content');

					if (token) {
						return xhr.setRequestHeader('X-CSRF-TOKEN', token);
					}
				},
				@if (auth() && (auth()->user()))
				data: {UserID: {!! auth()->user()->getAuthIdentifier() !!}, uri: "{{$_SERVER['REQUEST_URI']}}"},
				@else
				data: {uri: "{{$_SERVER['REQUEST_URI']}}"},
				@endif
				success: function (data) {
					console.log(data);
				}, error: function () {
					console.log("error!!!!");
				}
			}); //end of ajax
		}
	</script>
	<!--Start of Zopim Live Chat Script-->
	<script type="text/javascript">
	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
	$.src="//v2.zopim.com/?3dgbwbmhc2aL8G86QOWgVfX26ycur6x0";z.t=+new Date;$.
	type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
	</script>
	<!--End of Zopim Live Chat Script-->
	@yield('head.css')
</head>
@if (auth() && (auth()->user()))
<body onload="markTimeOnline(0); saveIP();">
@else
<body onload="saveIP();">
@endif
	<div class="wrapper side">
		@include('layouts.header')
		@include('layouts.navbar')
		<div class="container sidebar">
		@yield('body.sidebar')
			<div class=" row">
				<div class="col-sm-3 col-md-3 col-lg-3">
					@yield('body.navleft')
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">					
					@yield('body.content')
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3">
				@yield('body.navright')
				</div>
			</div>
		</div>
	</div>
		@include('layouts.footer')
	</div>
	<script type="text/javascript" src="/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/style.js"></script>
		@yield('body.js')
</body>
</html>
