<footer id = "footer" class='footer'>
	<div class="jumbotron">
		<div class="container">
			<h1>Hello, world!</h1>
			<p>Copyright &copy; 2015 câu lạc bộ TEC</p>
			<p>
				<a class="btn btn-primary btn-lg">Learn more</a>
			</p>
		</div>
	</div>
	<script type="text/javascript">
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});

//		$.ajaxSetup({
//			headers: {
//				'X-CSRF-TOKEN': $('input[name="_token"]').value()
//			}
//		});
	</script>
</footer>