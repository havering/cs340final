<?php
	ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);
	include('imp.php');	

	// need to check for logout action in case user is directed here via logout request
	if(isset($_GET['action']) && $_GET['action'] == 'logout') {
		session_unset($_SESSION['username']);
		session_unset($_SESSION['name']);
		session_unset($_SESSION['balance']);
		session_destroy();
	}
	// if we have returned to index via existing user log in
	if(isset($_GET['action']) && $_GET['action'] == 'login') {

		$_SESSION['username'] = $_POST['username'];

		userLogin();

	}
	// if we have returned to index via new user creation
	if(isset($_GET['action']) && $_GET['action'] == 'new') {
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['username'] = $_POST['username'];
		userCreate();
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gold Hills Soapery</title>
	<style>
		body {
			font-family: sans-serif;
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
		}

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
  			background: url(hills.png) no-repeat, linear-gradient(to right, #FFB547, black); /* Standard syntax */

		}
		#logine {
			margin-left: 20%;
			margin-right: 20%;
		}
		#linker {
			text-decoration: underline;
		}
		#displaybal {
			float: right;
			color: white;
			padding-right: 10px;
			font-size: 12pt;
		}
	</style>
</head>
<body>
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
<center><h3>Welcome to Gold Hills Soapery</h3></center>
<div id="logine">
<?php
	
	if (!isset($_SESSION['username'])) {
		echo '<p>You are not logged in. You can browse, but you won\'t be able to buy soaps without <span id="linker"><a href="login.php">logging in</a></span> or <span id="linker"><a href="new.php">creating a new account</a></span>.';
	}
	else {
		echo '<p>Welcome, ' . $_SESSION['name'] . '!';
		}
		echo '<p>For the last 5 years, Gold Hills Soapery has been proud to bring the finest of hand-made, all-natural soaps to California\'s gold country. Our soaps are personally crafted by our master soapmaker, and available for purchase';
		echo ' at farmers markets across Northern California, as well as nationally via our website. Feel free to browse, leave a comment, or purchase one of our great hand-crafted soaps.';
	
?>
</div>
<div id="sales">
</div>
</body>
</html>

