<?php
	//ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	include('imp.php');
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gold Hills Soapery</title>
	<link rel="stylesheet" type="text/css" href="style.css">
  		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
		// inventory validation
		$(document).ready(function(){
			$(("#value")).keyup(function() {
				var numpicked = $('#value').val();
				var sname = "antique";

				if(numpicked == "") {
					$("#display").html("");
				}
				else {
					$.ajax({
					type: "POST",
					url: "validate3.php",
					data: { value: numpicked, 
							name: sname
						},
					success: function(html){
					$("#display").empty();
					$("#display").append(html);
					}
				});
			return false;
			}
			});
		});

		</script>
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
<center><h3>Antique</h3></center>

<div id="left">
<img src="antique.jpg">
</div>
<div id="right">
<p>We love the effect of the "antique" finish on top of this darker soap. Brisk hints of lemon contrast the luxurious lather created by this olive oil and coconut oil based soap, and it is sure to leave you feeling clean and refreshed.
<p><b>Price: $5.99</b>
<p><form action="cart.php?action=antique" method="POST">
	Quantity: <input type="number" min="0" name="num" id="value"><div id="display"><input type="submit" value="Add to cart"></div>
</form>
</div>
<div id="commentdiv">
	<center><h4>Comments</h4></center>
<?php
	$where = 'antique';

	displayComments($where);
?>
</div>

<!--form should only appear if the user is logged in - no anonymous comments allowed-->
<div id="commentform">
<?php
	if (isset($_SESSION['username'])) {

		echo '<p><i>We love feedback! Feel free to leave a comment:</i>
			<form action="comment.php" method="POST">
			<p>Name: ' . $_SESSION['name'];
		echo '<p>Comment:
			<br><textarea rows="8" cols="30" maxlength="255" name="comment" id="comment"></textarea>
			<input type="hidden" name="wherefrom" id="wherefrom" value="antique">
			<br><input type="submit" value="Submit">
			</form>';
	}


?>
</div>
</body>
</html>