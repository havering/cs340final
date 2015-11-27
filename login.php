<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<meta http-equiv="X-UA-Compatible" content="IE=8"></meta> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$(("#password")).keyup(function() {
				var ajname = $('#username').val();
				var ajpass = $('#password').val();

				if(ajname=="" || ajpass=="") {
					$("#display").html("");
				}
				else {
					$.ajax({
					type: "POST",
					url: "validate2.php",
					data: { username: ajname, 
							password: ajpass
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
	</div>
	<div id="output"></div>
	<div id="login">
	<form action="index.php?action=login" method="POST" id="loginform">
		<p>Enter username: <input type="text" name="username" id="username">
		<p>Enter password: <input type="password" name="password" id="password">
		<div id="display"><!-- <p><input type="submit" value="Submit" onclick="formCheck()"> --></div><br>
	</form>
</div>
</body>
</html>