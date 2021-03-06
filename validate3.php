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
	// passed in from ajax call
	if (isset($_POST['name']) && isset($_POST['value'])) {
		$soap = $_POST['name'];
		$order = $_POST['value'];

		// first we need to get the current inventory for comparison
		$findinit = $mysqli->prepare("SELECT quantity FROM soaps WHERE name=?");

		if (!$findinit) {
			echo 'Findinit prepare failed.';
		}

		$findinit->bind_param('s', $soap);

		$findinit->execute();

		$findtotal = $findinit->get_result();

		while ($nums = $findtotal->fetch_assoc()) {
			$initotal = $nums['quantity'];
		}

		// next we need to figure out if the user is trying to order more than the inventory holds
		if ($initotal < $order) {
			echo '<p>Sorry, we don\'t have that many in our stock.';
			echo '<p>Please choose a maximum of ' . $initotal .' bars of this soap.';
		}
		else {
			echo '<input type="submit" value="Add to cart">';
		}

		$findtotal->close();

	}
?>