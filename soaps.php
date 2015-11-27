<?php
	//ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	include('imp.php');
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gold Hills Soapery</title>
	
	<style>
		
		a {
			text-decoration: none;
			color: black;
		}

		a:hover {
			text-decoration: underline;
			color: black;
		}
		a:visited {
			text-decoration: underline;
			color: black;
		}

		#navbar {
			width: 100%;
			height: 80px;
			background-color: #d3d3d3;
			background-image: url(hills.png);
			background-repeat: no-repeat;
			margin-top: 0px;
			margin-left: none;
			padding: none;
			font-size: 14pt;
			text-align: center;
			line-height: 80px;
			background: url(hills.png) no-repeat, -webkit-linear-gradient(left, #FFB547 , black); /* For Safari 5.1 to 6.0 */
  			background: url(hills.png) no-repeat,, -o-linear-gradient(right, #FFB547, black); /* For Opera 11.1 to 12.0 */
  			background: url(hills.png) no-repeat,, -moz-linear-gradient(right, #FFB547, black); /* For Firefox 3.6 to 15 */
  			background: url(hills.png) no-repeat, linear-gradient(to right, #FFB547 , black); /* Standard syntax */
  		}

		/* Responsive image gallery tutorial from: http://www.dwuser.com/education/content/creating-responsive-tiled-layout-with-pure-css/*/
		body {
		   margin: 0;
		   padding: 0;
		   background: #EEE;
		   font-family: sans-serif;
		}
		.wrap {
		   overflow: hidden;
		   margin: 10px;
		}
		.box {
		   float: left;
		   position: relative;
		   width: 20%;
		   padding-bottom: 18%;
		}
		.boxInner {
		   position: absolute;
		   left: 10px;
		   right: 10px;
		   top: 10px;
		   bottom: 10px;
		   overflow: hidden;
		}

		.boxInner img {
		   width: 100%;
		   background-color: white;
    		display: inline-block;

		}

		.boxInner img:hover {
    		opacity: .8; 
		}

		.boxInner .titleBox {
		   position: absolute;
		   bottom: 0;
		   left: 0;
		   right: 0;
		   margin-bottom: -50px;
		   background: #000;
		   background: rgba(0, 0, 0, 0.5);
		   color: #FFF;
		   padding: 5px;
		   text-align: center;
		   -webkit-transition: all 0.3s ease-out;
		   -moz-transition: all 0.3s ease-out;
		   -o-transition: all 0.3s ease-out;
		   transition: all 0.3s ease-out;
		}
		body.no-touch .boxInner:hover .titleBox, body.touch .boxInner.touchFocus .titleBox {
		   margin-bottom: 0;
		}
		@media only screen and (max-width : 480px) {
		   /* Smartphone view: 1 tile */
		   .box {
		      width: 100%;
		      padding-bottom: 100%;
		   }
		}
		@media only screen and (max-width : 650px) and (min-width : 481px) {
		   /* Tablet view: 2 tiles */
		   .box {
		      width: 50%;
		      padding-bottom: 50%;
		   }
		}
		@media only screen and (max-width : 1050px) and (min-width : 651px) {
		   /* Small desktop / ipad view: 3 tiles */
		   .box {
		      width: 33.3%;
		      padding-bottom: 33.3%;
		   }
		}
		@media only screen and (max-width : 1290px) and (min-width : 1051px) {
		   /* Medium desktop: 4 tiles */
		   .box {
		      width: 25%;
		      padding-bottom: 25%;
		   }
		}
		
		img{
			border-radius: 10px;
		}
		#displaybal {
			float: right;
			color: white;
			padding-right: 10px;
			font-size: 12pt;
		}
	</style>
	<!-- Enable media queries for old IE -->
	<!--[if lt IE 9]>
   <script src="css3-mediaqueries.js"></script>
	<![endif]-->
</head>
<body class="no-touch">
	<div id="navbar">
		<a href="index.php">Home</a> |
		<a href="soaps.php">Soaps</a> | 
		<a href="cart.php">Cart</a> | 
		<a href="index.php?action=logout">Log Out</a>
		<div id="displaybal">
			<?php 
			if (isset($_SESSION['balance'])) {
				echo '<b>Balance:</b> $' . $_SESSION['balance'];
				} ?></div>
	</div>
<center><h3>Soaps</h3></center>
<div class="wrap">
    
  <!-- Define all of the tiles: -->
  <div class="box">
    <div class="boxInner">
    	<a href="antique.php">
      <img src="antique.jpg" /></a>
      <div class="titleBox">Antique</div>
    </div>
  </div>
  <div class="box">
    <div class="boxInner">
    	<a href="butterfly.php">
      <img src="butterfly.jpg" /></a>
      <div class="titleBox">Butterfly</div>
    </div>
  </div>
  <div class="box">
    <div class="boxInner">
    	<a href="church.php">
      <img src="church.jpg" /></a>
      <div class="titleBox">Red Church</div>
    </div>
  </div>
  <div class="box">
    <div class="boxInner">
    	  <a href="orange.php">
      <img src="orange.jpg" /></a>
      <div class="titleBox">Orange Cream</div>
    </div>
  </div>
  <div class="box">
    <div class="boxInner">
    	<a href="swirl.php">
      <img src="swirl.jpg" /></a>
      <div class="titleBox">Swirl</div>
    </div>
  </div>
</div>
<!-- /#wrap -->
</div>
<?php
	//print 'Session user is ' . $_SESSION['name'];
?>
</body>
</html>
