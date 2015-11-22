<?php
	ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	error_reporting(E_ALL);
	include('imp.php');

	// if the user somehow gets here while logged out, they don't trigger adding to the cart
	if (isset($_SESSION['username'])) {

		$name = $_SESSION['name'];

		// if statements to determine which soap adding the person came here from
		/*ANTIQUE*/
		if (isset($_GET['action']) && $_GET['action'] == 'antique') {
			$soap = $_GET['action'];
			$quant = $_POST['num'];

			addSoap($soap, $quant);
			updateInv($soap, $quant);
		}
		
		/*BUTTERFLY*/
		if (isset($_GET['action']) && $_GET['action'] == 'butterfly') {
			$soap = $_GET['action'];
			$quant = $_POST['num'];

			addSoap($soap, $quant);
			updateInv($soap, $quant);
		}

		/*RED CHURCH*/
		if (isset($_GET['action']) && $_GET['action'] == 'church') {
			$soap = $_GET['action'];
			$quant = $_POST['num'];

			addSoap($soap, $quant);
			updateInv($soap, $quant);
		}

		/*ORANGE CREAM*/
		if (isset($_GET['action']) && $_GET['action'] == 'orange') {
			$soap = $_GET['action'];
			$quant = $_POST['num'];

			addSoap($soap, $quant);
			updateInv($soap, $quant);
		}

		/*SWIRL*/
		if (isset($_GET['action']) && $_GET['action'] == 'swirl') {
			$soap = $_GET['action'];
			$quant = $_POST['num'];

			addSoap($soap, $quant);
			updateInv($soap, $quant);
		}

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
  			background: url(hills.png) no-repeat, -o-linear-gradient(right, #FFB547, black); /* For Opera 11.1 to 12.0 */
  			background: url(hills.png) no-repeat, -moz-linear-gradient(right, #FFB547, black); /* For Firefox 3.6 to 15 */
  			background: url(hills.png) no-repeat, linear-gradient(to right, #FFB547, black); /* Standard syntax */

		}
		#incart {
			padding-left: 10%;
			padding-right: 10%;
		}

		#actualcart {
			padding-left: 40%;
			padding-right: 40%;
			margin-top: 5%;
		}

		table {
			border-collapse: separate; 
			border-spacing: 10px; 
			border: 1px solid black
		}

		#total {
			border-top: 1px solid black;
			padding-top: 4px;
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
<center><h3>Cart</h3></center>
<div id="incart">
<?php
	if (isset($_SESSION['name'])) {
		echo '<p>Welcome, ' . $name . ', here you may review the items in your cart.';
		echo '<p>If you would like to update your cart, please return to the soaps page and select a new number of soaps to purchase.';
	}
	else {
		echo '<p>You must log in to view your cart.';
	}
?>
<div id="actualcart">
	<table>
	<tr><td><b>Soap</b></td>
	<td><b>Quantity</b></td>
	<td><b>Price</b></td>
	<td><b> </b></td>
<?php
	displayCart();
?>
</table>
</div>
</div>
</body>
</html>