<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title id="title">
		@yield('title')
	</title>
</head>
<body>
	@include('layouts.header')
	@include('layouts.nav')
	<section id='content'>
		@yield('content')
	</section>
	@include('layouts.footer')
</body>
</html>