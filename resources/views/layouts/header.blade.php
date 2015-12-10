<header>
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<div class="row" style="height: 100px;">
		<div class="col-sm-offset-2" style="color: #9400D3;"> <h1><b><a href="/" style="text-decoration: none;">TEC Club</a></h1></b></div>
	</div>
	<div>
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="col-sm-offset-2">
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="#">News</a></li>
						<li><a href="#">Buzz</a></li>
						<li><a href="#">Life</a></li>
						<li><a href="#">Quizzes</a></li>
						<li><a href="#">Video</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-left">
						<!-- <li><a href="#">Link</a></li> -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">More<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#">Pronounce</a></li>
								<li><a href="#">Grammar</a></li>
								<li><a href="#">Business English</a></li>
							</ul>
						</li>
					</ul>
					<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default">Search</button>
						</div>
						<div class="form-group">
						<button type="button" class="btn btn-primary">Login</button>
						</div>
					</form>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>
	</div>
</header>