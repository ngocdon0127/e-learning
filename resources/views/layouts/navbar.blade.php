<nav class="navbar navbar-default" role="navigation" style = "color: #EAEAEA;">
	<!-- Brand and toggle get grouped for better mobile display -->
	<!-- <a id="HomeSmall" style="text-decoration: none;" href="">TEC Club</a> -->
	<div class="navbar-header">
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="padding-top: 9px;">
			<!-- <button style="padding-top: px; height: 50px;background-color: #e7e7e7"> -->
				<a id="HomeSmall" style="text-decoration: none; font-size: 20px; color: red;" href="/"><b><b style="font-size: 25px">E</b>vangels<b style="font-size: 25px">E</b>nglish</b></a>
			<!-- </button> -->
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<!-- <div class="col-sm-offset-3"> -->
	<div class="collapse col-sm-offset-4 navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li><a class="navbar-button" href="/">Home</a></li>
			@if ((auth()->user()) && (auth()->user()->admin == 1))
			<li><a class="navbar-button" href="/admin">Admin</a></li>
			@endif
			<li><a class="navbar-button" href="#">Life</a></li>
			<li><a class="navbar-button" href="#">Quizzes</a></li>
			<li><a class="navbar-button" href="#">Video</a></li>
			<li class="dropdown">
				<a id= "dropDown" href="#" class="dropdown-toggle navbar-button" data-toggle="dropdown">More<b class="caret"></b></a>
				<ul id="dropdown-menu" class="dropdown-menu">
					<li><a href="#">Grammar</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li><a href="#">Separated link</a></li>
				</ul>
			</li>
		</ul>
		<form class="navbar-form navbar-right" role="search">
		
			<!-- search button-->
			<!--<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">

			
			        <button type="button" class="btn btn-default btn-sm">
          				<span class="glyphicon glyphicon-search"></span> Submit 
        			</button>
			</div>-->
			@if (auth()->user())
				<li class="dropdown">
					<a href="#" style="text-decoration: none;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('/auth/logout') }}" onclick='logout = 1;'>Logout</a></li>
					</ul>
				</li>
			<!--<a class="btn btn-primary" href="/auth/logout" role="button">Logout</a>-->
			@else
			<a class="btn btn-primary" href="/auth/login" role="button">Login</a>
			@endif
		</form>
	</div><!-- /.navbar-collapse -->
	<!-- </div> -->
</nav>
