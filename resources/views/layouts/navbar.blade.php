<div class="container" style="padding:0">
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
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li id="navbar-button"><a class="navbar-button" href="/">Home</a></li>
				@if ((auth()->user()) && (auth()->user()->admin == 1))
				<li id="navbar-button"><a class="navbar-button" href="/admin">Admin</a></li>
				@endif
				<li id="navbar-button"><a class="navbar-button" href="#">Tiếng Anh Tiểu học</a></li>
				<li id="navbar-button"><a class="navbar-button" href="#">Tiếng Anh THCS</a></li>
				<li id="navbar-button"><a class="navbar-button" href="#">TOEIC đột phá</a></li>
				<!-- <li><a class="navbar-button" href="#">Quizzes</a></li> -->
				<li class="dropdown">
					<a id= "dropDown" href="#" class="dropdown-toggle navbar-button" data-toggle="dropdown">Khóa học<b class="caret"></b></a>
					<ul id="dropdown-course" class="dropdown-menu">
						@foreach(\App\Courses::all() as $c)
							<li id="navbar-button"><a href="/course/{{$c->id}}">{{$c->Title}}</a></li>
						@endforeach
					</ul>
				</li>
			</ul>
			{!! Form::open(['method' => 'GET', 'name' => 'searchForm', 'url' => '/search', 'role'=>'search', 'class' => 'navbar-form navbar-right']) !!}
				
				<div class="form-group">
    				<span class="glyphicon glyphicon-search" id="spanSearch"></span>
		        	<input style="display: none" class="glyphicon glyphicon-search form-control" name="HashtagSearch" id="HashtagSearch">
		        	<button style="display: none" type="button" class="btn btn-default btn-sm" id="btnHashtagSearch" onclick="document.searchForm.submit()">
		        		<span class="glyphicon glyphicon-search"></span> Search
		        	</button>
				</div>
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
			{!! Form::close() !!}
		</div>
	</nav>
	<script>
		function ob(x){
			return document.getElementById(x);
		}
		var x = ob("spanSearch");
		x.setAttribute(
			'onMouseOver', 
			'displaySearch()');
		x.setAttribute('onclick', 'displaySearch()');

		// x.setAttribute("onclick",'alert(1)');
		function displaySearch(){
			ob("HashtagSearch").style.display = "inline"; 
			ob("btnHashtagSearch").style.display = "inline";
			ob('spanSearch').style.display="none";
			ob('HashtagSearch').focus();
			ob('HashtagSearch').setAttribute('onBlur', 'hideSearch()');
		}

		function hideSearch(){
			ob("HashtagSearch").style.display = "none"; 
			ob("btnHashtagSearch").style.display = "none";
			ob('spanSearch').style.display="inline";
		}
	</script>
</div>