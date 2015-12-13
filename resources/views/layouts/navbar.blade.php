<nav class="navbar navbar-default col-sm-12" data-spy="affix" data-offset-top="197" role="navigation" style = "color: #EAEAEA; class="active"">
	<!-- Brand and toggle get grouped for better mobile display -->
	<!-- <a id="HomeSmall" style="text-decoration: none;" href="">TEC Club</a> -->
	<div class="navbar-header">
	<a id="HomeSmall" style="text-decoration: none;" href="">TEC Club</a>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<!-- <div class="col-sm-offset-3"> -->
	<div class="collapse col-sm-offset-2 navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li class="active"><a href="/">Home</a></li>
			<li class="active"><a href="/admin">Admin</a></li>
			<li class="active"><a href="#">Life</a></li>
			<li class="active"><a href="#">Quizzes</a></li>
			<li class="active"><a href="#">Video</a></li>
			<li class="dropdown active">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">More<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">Grammar</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li><a href="#">Separated link</a></li>
				</ul>
			</li>
			<li class="active">
				<link src="//www.facebook.com/plugins/follow?href=https%3A%2F%2Fwww.facebook.com%2Fkevinhoa95&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden;"></link>
			</li>
		</ul>
		<form class="navbar-form navbar-right" role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">

			<!-- <button type="submit" class="btn btn-default">Submit</button> -->
			        <button type="button" class="btn btn-default btn-sm">
          				<span class="glyphicon glyphicon-search"></span> Submit 
        			</button>
						</div>
			@if (auth()->user())
			<!-- <button type="button" class="btn btn-default"><a href="/auth/logout">Logout</a></button> -->
			<a class="btn btn-primary" href="/auth/logout" role="button">Logout</a>
			@else
			<!-- <button type="button" class="btn btn-default"><a href="/auth/login">Login</a></button> -->
			<a class="btn btn-primary" href="/auth/login" role="button">Login</a>
			@endif
		</form>
	</div><!-- /.navbar-collapse -->
	<!-- </div> -->
</nav>
