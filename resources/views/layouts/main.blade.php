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
	<link rel="stylesheet" type="text/css" href="/css/admin.css">
	@yield('head.css')
</head>
<body>
	<div class="wrapper">
		@include('layouts.header')
		@include('layouts.navbar')
		<!-- <div class="panel panel-default"> -->

			<!-- <div class="content col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-lg-6 col-lg-offset-3 "> -->
			<div class="content col-lg-6 col-lg-offset-3">
				<div class="row">
					@yield('body.content')
				</div>
			</div>
		<!-- </div> -->
		@include('layouts.footer')
	</div>
		<script type="text/javascript" src="/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/style.js"></script>
		@yield('body.js')
	
</body>
</html>