<?php
	ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);
	
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$soap = $_POST['id'];
	$cartname = $_SESSION['username'];

	// two parts to this
	// first we need to reintroduce the inventory back into the inventory database
	// then we need to set the user's balance for that item to zero
	$query = "SELECT " . $soap . " FROM carts WHERE user='" . $cartname . "'";

	// what is returned is the number of soaps in the user's cart
	$numgive = $mysqli->query($query);

	// because we don't know which soap the user has deleted, assign a variable to account for each option
	// all but one of these will be zero
	while ($soaps = $numgive->fetch_array(MYSQLI_ASSOC)) {
		$setorange = $soaps['orange'];
		$setswirl = $soaps['swirl'];
		$setant = $soaps['antique'];
		$setch = $soaps['church'];
		$setbutt = $soaps['butterfly'];
	}

	// the sets work correctly, why isn't the next query working

	// next we need to find out how many were in the inventory to begin with 

	$findsoaps = "SELECT quantity FROM soaps WHERE name='" . $soap . "'";

	$returnsoaps = $mysqli->query($findsoaps);

	// only returns one line, the quantity of the soap in question

	while ($fs = $returnsoaps->fetch_array(MYSQLI_ASSOC)) {
		$returnquant = $fs['quantity'];
	}

	// if statements to determine which isn't zero and then do some addition
	if ($setorange != 0) {
		$finalorange = $returnquant + $setorange;

		//echo 'Finalorange is ' . $finalorange;
	}

	if ($setswirl != 0) {
		$finalswirl = $returnquant + $setswirl;
	}

	if ($setant != 0) {
		$finalant = $returnquant + $setant;
	}

	if ($setch != 0) {
		$finalch = $returnquant + $setch;
	}

	if ($setbutt != 0) {
		$finalbutt = $returnquant + $setbutt;
	}

	// now use if statements to figure out which one isn't zero
	// add that inventory back into the inventory database

	if ($finalorange != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name='orange'");

		if (!$setter) {
			echo 'Orange setter failed';
		}
		else {
			$setter->bind_param('i', $finalorange);

			$setter->execute();

			$setter->close();
		}
	}

	if ($finalswirl != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name='swirl'");

		if (!$setter) {
			echo 'Swirl setter failed';
		}
		else {
			$setter->bind_param('i', $finalswirl);

			$setter->execute();

			$setter->close();
		}
	}

	if ($finalant != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name='antique'");

		if (!$setter) {
			echo 'Antique setter failed';
		}
		else {
			$setter->bind_param('i', $finalant);

			$setter->execute();

			$setter->close();
		}
	}

	if ($finalch != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name='church'");

		if (!$setter) {
			echo 'Orange setter failed';
		}
		else {
			$setter->bind_param('i', $finalch);

			$setter->execute();

			$setter->close();
		}
	}

	if ($finalbutt != 0) {
		$setter = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name='butterfly'");

		if (!$setter) {
			echo 'Orange setter failed';
		}
		else {
			$setter->bind_param('i', $finalbutt);

			$setter->execute();

			$setter->close();
		}
	}

	// now it's time to set the user's inventory for the deleted item to zero

	$adder = "UPDATE carts SET " . $soap . "=0 WHERE user='" . $cartname . "'";

	$mysqli->query($adder);
	// not sure why prepared statement failing here
	// $adder = $mysqli->prepare("UPDATE carts SET ?=0 WHERE user=?");

	// if (!$adder) {
	// 	echo 'Adder prepared statement failed';
	// }

	// $adder->bind_param('ss', $soap, $cartname);
	
	// $adder->execute();

	// $adder->close();

	header('LOCATION: cart.php');
?>