<!DOCTYPE html>
<html>
<head>
	<title>Create New Account</title>
  <meta http-equiv="X-UA-Compatible" content="IE=8"></meta> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#username").blur(function() {
        var username = $('#username').val();
        if(username=="") {
          $("#display").html("");
      }
      else {
        $.ajax({
        type: "POST",
        url: "validate.php",
        data: "username="+ username ,
        success: function(html){
        $("#display").html(html);
      }
      });
      return false;
      }
      });
    });
  </script>
	<?php include('imp.php'); ?>
</head>
<body>
  <div id="navbar">
    <a href="index.php">Home</a> |
    <a href="soaps.php">Soaps</a> | 
    <a href="cart.php">Cart</a> | 
    <a href="index.php?action=logout">Log Out</a>
  </div>
	<div id="login">
	<form action="index.php?action=new" method="POST">
		<p>Enter your name: <input type="text" name="name">
		<p>Enter a username: <input type="text" name="username" id="username">
		<p>Enter a password: <input type="password" name="password"><br><br>
    <div id="display"><p></div><br>
	</form>
</div>
</body>
</html>