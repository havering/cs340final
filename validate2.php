<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'yNlBHwYIyC3BdLuK';
	
	$mysqli = new mysqli($host, $user, $pw, $db);

	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}
	
	if(isset($_POST['username']) && isset($_POST['password'])) {

		$name = mysqli_real_escape_string($mysqli, $_POST['username']);
		$pass = mysqli_real_escape_string($mysqli, $_POST['password']);

		$query = "SELECT * FROM users WHERE user='" . $name . "' AND password='" . $pass . "'";

		$rows = $mysqli->query($query);

		if ($rows->num_rows == 0) {
 			echo "Invalid username or password. Please try again.";
		}
		else {
			echo '<p><input type="submit" value="Submit">';
		}

		$rows->close();
	}
?>