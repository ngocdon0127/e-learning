<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>@yield('head.title')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<!-- <link rel="stylesheet" type="text/css" href="/css/style.css"> -->
	<link rel="stylesheet" type="text/css" href="/css/admin.css">
	@yield('head.css')
</head>
<body>
	<div class="wrapper">
		@include('layouts.header')
		<div class="content">
			<!-- <div class="col-sm-6"> -->
				@yield('body.content')
			<!-- </div> -->
		</div>
		@include('layouts.footer')
	</div>
		<!-- // <script type="text/javascript" src="/js/jquery/jquery.js"></script> -->
		<!-- // <script type="text/javascript" src="/js/bootstrap.min.js"></script> -->
		<!-- @yield('body.js') -->
	
</body>
</html>