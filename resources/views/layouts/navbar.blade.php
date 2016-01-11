<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="padding-top: 9px;">
				<a id="homesmall" href="/"><b><b style="font-size: 25px">E</b>vangels<b style="font-size: 25px">E</b>nglish</b></a>
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
	<div class="collapse col-sm-offset-3 navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li id="navbar-button"><a class="navbar-button" href="/">Home</a></li>
			@if ((auth()->user()) && (auth()->user()->admin == 1))
			<li id="navbar-button"><a class="navbar-button" href="/admin">Admin</a></li>
			@endif
			<!--<li id="navbar-button"><a class="navbar-button" href="#">Giới thiệu</a></li>-->
			<!-- <li><a class="navbar-button" href="#">Quizzes</a></li> -->
			<li class="dropdown">
				<a id= "dropDown" href="#" class="dropdown-toggle navbar-button" data-toggle="dropdown">Khóa học<b class="caret"></b></a>
				<ul id="dropdown-course" class="dropdown-menu">
					@foreach(\App\Courses::all() as $c)
						<li id="navbar-button"><a href="/course/{{$c->id}}">{{$c->Title}}</a></li>
					@endforeach
				</ul>
			</li>

			<!--<li id="navbar-button"><a class="navbar-button" href="#">Hướng dẫn</a></li>-->
			<!--<li class="dropdown">
				<a id= "dropDown" href="#" class="dropdown-toggle navbar-button" data-toggle="dropdown">Liên hệ<b class="caret"></b></a>
				<ul id="dropdown-lienhe" class="dropdown-menu">
					<li id="navbar-button"><a href="#">Grammar</a></li>
					<li id="navbar-button"><a href="#">Another action</a></li>
					<li id="navbar-button"><a href="#">Something else here</a></li>
					<li id="navbar-button"><a href="#">Separated link</a></li>
				</ul>
			</li>-->
		</ul>
			{!! Form::open(['method' => 'GET', 'name' => 'searchForm', 'url' => '/search', 'role'=>'search', 'class' => 'navbar-form navbar-right']) !!}
			<div class="form-group">
				@if (auth()->user())
					<li style= "list-style: none;" class="dropdown">
						<a href="#" style="text-decoration: none;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/auth/logout') }}" onclick='logout = 1;'>Logout</a></li>
						</ul>
					</li>
				@else
					<a class="btn btn-primary" href="/auth/login" role="button">Login</a>
				@endif
			</div>
			<!-- search button-->
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search" name="HashtagSearch" id="HashtagSearch">


			        <button type="button" class="btn btn-default btn-sm" onclick="document.searchForm.submit()">
          				<span class="glyphicon glyphicon-search"></span> Submit
        			</button>
			</div>
		{!! Form::close() !!}
	</div>
</nav>
