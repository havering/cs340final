<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'delete';
	
	$mysqli = new mysqli($host, $user, $pw, $db);

	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}
	
	if(isset($_POST['username'])) {
		$name = mysqli_real_escape_string($mysqli, $_POST['username']);

		// $query = "SELECT * FROM users WHERE username='" . $name . "'";

		// $rows = $mysqli->query($query);
		// $count = count($rows);

		$stmt = $mysqli->prepare("SELECT * FROM users WHERE user=?");

		if (!$stmt) {
			echo 'Ugh more failure';
			var_dump($stmt->connect_error);
		}

		$stmt->bind_param('s', $name);

		$stmt->execute();

		$result = $stmt->get_result();


		if ($result->num_rows != 0) {
 			echo "Username not available. Please enter a new username.";
 			//vardump($rows);
		}
		else {
			echo '<p><input type="submit" value="Submit">';
		}

		$stmt->close();

	}
?>