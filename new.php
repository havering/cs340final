<!DOCTYPE html>
<html>
<head>
	<title>Create New Account</title>
  <meta http-equiv="X-UA-Compatible" content="IE=8"></meta> 
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
        background: url(hills.png) no-repeat, linear-gradient(to right, #FFB547 , black); /* Standard syntax */
  }
	</style>
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