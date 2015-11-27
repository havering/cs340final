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

	// first find totals for each that need to be readded into the stock
	$totalfromcart = $mysqli->prepare("SELECT * FROM carts WHERE user=?");

	if (!$totalfromcart) {
			echo 'Ugh more failure';
			var_dump($totalfromcart->connect_error);
		}

	$totalfromcart->bind_param('s', $cartname);

	$totalfromcart->execute();

	$totals = $totalfromcart->get_result();

	while ($row = $totals->fetch_assoc()) {
		$setorange = $row['orange'];
		$setswirl = $row['swirl'];
		$setant = $row['antique'];
		$setch = $row['church'];
		$setbutt = $row['butterfly'];
	}

	// then add those totals back into soaps
	$updateorange = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

	if (!$updateorange) {
		echo 'Update orange failed.';
	}

	$orange = 'orange';
	$updateorange->bind_param('is', $setorange, $orange);
	$updateorange->execute();
	$updateorange->close();

	$updateswirl = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

	if (!$updateswirl) {
		echo 'Update swirl failed.';
	}

	$swirl = 'swirl';
	$updateswirl->bind_param('is', $setswirl, $swirl);
	$updateswirl->execute();
	$updateswirl->close();

	$updateantique = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

	if (!$updateantique) {
		echo 'Update antique failed.';
	}

	$antique = 'antique';
	$updateantique->bind_param('is', $setant, $antique);
	$updateantique->execute();
	$updateantique->close();

	$updatechurch = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

	if (!$updatechurch) {
		echo 'Update church failed.';
	}

	$church = 'church';
	$updatechurch->bind_param('is', $setch, $church);
	$updatechurch->execute();
	$updatechurch->close();

	$updatebutt = $mysqli->prepare("UPDATE soaps SET quantity=quantity+? WHERE name=?");

	if (!$updatebutt) {
		echo 'Update church failed.';
	}

	$butt = 'butterfly';
	$updatebutt->bind_param('is', $setbutt, $butt);
	$updatebutt->execute();
	$updatebutt->close();

	// then delete all the soap quantities from the user's cart
	$deleteall = $mysqli->prepare("UPDATE carts SET orange=0, swirl=0, church=0, antique=0, butterfly=0 WHERE user=?");

	$deleteall->bind_param('s', $cartname);

	$deleteall->execute();

	$deleteall->close();

	$totalfromcart->close();

	header('LOCATION: cart.php');
?>