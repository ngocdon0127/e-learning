
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Main Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script type="text/javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.equalheights/1.5.2/jquery.equalheights.min.js"></script>
	 <script type="text/javascript" src="jquery.equalheights.min.js"></script>
	 <script type="text/javascript" src="jquery.equalheights.js"></script>
	<style>
		 header{
			background: orange;
			font-family: Oswald, sans-serif;
		 }
		 .container{
			padding:15px;
		 }
		  body{
			   background: #66ccff;
		  }
		  img {
			   vertical-align: middle;
			   border-radius: 10px;
			   /*border: 5px solid rgba(65, 5, 93, 0.67);*/
			   width: 100%;
			   /*height: 400px;          */
		  }
		  .img{
			height: 200px;
			padding : 10px;
			    border-radius: 20px;

		  }
		  .cover1,.cover2{
			   padding : 15px;
			   border-radius:10px;
			   
		  }
		  .cover1{
			   background: #ff66cc;
		  }
		  .cover2{
			   background: #cc33ff;
		  }
		  th{
		  	background: red;
		  }
		  button{
		  	display: block;
		  }
	 </style>

</head>
<body>
<audio>
   <source src="demen.mp3">xxx</source>
</audio>
<header>
   <div class="container">
	 <div class="col-md-6">
		<h1> Evangels English</h1>
   
	 </div>
	 <div class="col-md-6">
		<h1 style="float:right">Kid School</h1>
	 </div>
   </div>
</header>
<div class="container">
  <div class="row parent">
	  <div class="col-md-8">
		<div class="cover1">
			<p>GIỚI THIỆU CHUNG VỀ KHÓA HỌC</p>
			<img src="1.jpg" alt="" class="img-responsive 123">
		</div>
	  </div>
	  <div class="col-md-4">
		 <div class="cover2">
		 	<p>CÁC POST ĐƯỢC VIEW NHIỀU NHẤT</p>
			<p>ảnh và tiêu đề của post</p>

		 </div>
	  </div>  
  </div>
</div>
	 <div class="container">
	 	<h1>CÁC POST GỢI Ý</h1>
		  <div class="row">
			   <div class="col-md-3">
					<p>ảnh và tiêu đề của post</p>
			   </div>
			</div>
	 </div>                   
</body>
   <script type="text/javascript">
  $(function(){$('.parent div').equalHeights();});
  </script> 
  <script>
   var audio = $("audio")[0];
   $(".img-responsive").mouseenter(function() {
	  audio.play();
   });
   $('.img-responsive').mouseout(function(){
	  audio.pause();
   });

</script>
</html>
