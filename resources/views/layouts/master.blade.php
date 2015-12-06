<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('head.title')</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	@yield('head.css')
</head>
<body>
	@include('partials.navbar')

	@include('partials.header')

	@yield('body.content')
	
	@include('partials.footer')
	<script type="text/javascript" src="/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	@yield('body.js')
</body>
</html>