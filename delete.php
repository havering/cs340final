<?php
	//ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);
	
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'delete';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$soap = $_POST['id'];
	$cartname = $_SESSION['username'];

	// two parts to this
	// first we need to reintroduce the inventory back into the inventory database
	// then we need to set the user's balance for that item to zero
	$query = $mysqli->prepare("SELECT {$soap} FROM carts WHERE user=?");

	$query->bind_param('s', $cartname);

	$query->execute();

	// what is returned is the number of soaps in the user's cart
	$numgive = $query->get_result();

	// because we don't know which soap the user has deleted, assign a variable to account for each option
	// all but one of these will be zero
	while ($soaps = $numgive->fetch_assoc()) {
		$setorange = $soaps['orange'];
		$setswirl = $soaps['swirl'];
		$setant = $soaps['antique'];
		$setch = $soaps['church'];
		$setbutt = $soaps['butterfly'];
	}

	// add that inventory back into the inventory database
	if ($setorange != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

		if (!$setter) {
			echo 'Orange setter failed';
		}
		else {
			$setter->bind_param('is', $setorange, $soap);

			$setter->execute();

			$setter->close();
		}
	}

	if ($setswirl != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

		if (!$setter) {
			echo 'Swirl setter failed';
		}
		else {
			$setter->bind_param('is', $setswirl, $soap);

			$setter->execute();

			$setter->close();
		}
	}

	if ($setant != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

		if (!$setter) {
			echo 'Antique setter failed';
		}
		else {
			$setter->bind_param('is', $setant, $soap);

			$setter->execute();

			$setter->close();
		}
	}

	if ($setch != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

		if (!$setter) {
			echo 'church setter failed';
		}
		else {
			$setter->bind_param('is', $setch, $soap);

			$setter->execute();

			$setter->close();
		}
	}

	if ($setbutt != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

		if (!$setter) {
			echo 'Butterfly setter failed';
		}
		else {
			$setter->bind_param('is', $setbutt, $soap);

			$setter->execute();

			$setter->close();
		}
	}

	// now it's time to set the user's inventory for the deleted item to zero
	$adder = $mysqli->prepare("UPDATE carts SET {$soap}=0 WHERE user=?");

	if (!$adder) {
		echo 'Adder prepared statement failed';
	}

	$adder->bind_param('s', $cartname);
	
	$adder->execute();

	$adder->close();

	header('LOCATION: cart.php');
?>