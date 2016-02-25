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
				<li id="navbar-button"><a class="navbar-button" href="/"><span class="glyphicon glyphicon-home"> Home</span></a></li>
				@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_ADMIN))
				<li id="navbar-button"><a class="navbar-button" href="{{route('admin')}}">Admin</a></li>
				@endif
				@if ((auth()->user()) && (auth()->user()->admin >= App\ConstsAndFuncs::PERM_SUBADMIN))
				<li id="navbar-button"><a class="navbar-button" href="{{route('subadmin.view')}}">SubAdmin</a></li>
				@endif
				<li id="navbar-button"><a class="navbar-button" href="http://kids.evangelsenglish.com">Kids</a></li>
				@foreach(\App\Categories::all() as $cate)
				<li class="dropdown">
					<a id= "dropDown{{$cate->id}}" href="#" class="dropdown-toggle navbar-button" data-toggle="dropdown">{{$cate->Category}}<b class="caret"></b></a>
					@if (count($courses = \App\Courses::where('CategoryID', '=', $cate->id)->get()) > 0)
						<ul id="dropdown-course-{{$cate->id}}" class="dropdown-menu">
							@foreach($courses as $c)
								<li id="navbar-button-{{$c->id}}"><a href="{{route('user.viewcourse', $c->id)}}">{{$c->Title}}</a></li>
							@endforeach
						</ul>
					@endif
				</li>
				@endforeach
			</ul>
			{!! Form::open(['method' => 'GET', 'name' => 'searchForm', 'url' => '/search', 'role'=>'search', 'class' => 'navbar-form navbar-right']) !!}
				
				<div class="form-group">
					<span class="glyphicon glyphicon-search" id="spanSearch"></span>
					<input style="display: none" class="glyphicon glyphicon-search form-control" name="HashtagSearch" id="HashtagSearch">
					<!-- <button style="display: none" type="button" class="btn btn-default btn-sm" id="btnHashtagSearch" onclick="document.searchForm.submit()">
						 Search
					</button> -->
				</div>
				<div class="form-group">
					@if (auth()->user())
						<li style= "list-style: none;" class="dropdown">
							<a href="#" id="username-dropdown" style="text-decoration: none;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ route('user.getactive') }}">Nạp thẻ</a></li>
								<li><a href="{{ url('/auth/logout') }}" onclick='logout = 1;'>Logout</a></li>
							</ul>
						</li>
					@else
						<a class="btn btn-primary" id="login-button" href="/auth/login" role="button">Login</a>
					@endif
				</div>
			{!! Form::close() !!}
		</div>
	</nav>
	<style>
		#spanSearch, #HashtagSearch{
			transition: all linear 0.2s;
		}
		#HashtagSearch{
			width: 0px;
		}
	</style>
	<script>
		function ob(x){
			return document.getElementById(x);
		}
		var x = ob("spanSearch");
		x.setAttribute(
			'onMouseOver', 
			'displaySearch()');
		x.setAttribute('onclick', 'displaySearch()');
		function displaySearch(){
			@if (auth()->user())
				// ob('username-dropdown').style.display = 'none';
			@else
			@endif
			$("#HashtagSearch").fadeIn();
			// ob('HashtagSearch').style.display = "block";
			ob('HashtagSearch').style.width = "200px";
			// $('#btnHashtagSearch').fadeIn();
			ob('spanSearch').style.display="none";
			ob('HashtagSearch').focus();
			ob('HashtagSearch').setAttribute('onBlur', 'hideSearch()');
		}

		function hideSearch(){
			setTimeout(function(){
				ob('HashtagSearch').style.width = "0px";
				$("#HashtagSearch").fadeOut(200);
				// ob('btnHashtagSearch').style.display = 'none';
				$('#spanSearch').fadeIn(100);
				// $('#username-dropdown').fadeIn();
			}, 200);
		}

		
	</script>
</div>