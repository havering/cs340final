<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// global variables to avoid repetition
$host = 'oniddb.cws.oregonstate.edu';
$db = 'ohaverd-db';
$user = 'ohaverd-db';
$pw = 'delete';

// user creates login, sends POST information to db
function userCreate() {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$stmt = $mysqli->prepare("INSERT INTO users (user, name, password, balance) VALUES (?, ?, ?, ?)");

	if (!$stmt) {
		echo 'y u fail tho';
	}
	$stmt->bind_param('sssd', $useName, $name, $pass, $bal);

	$useName = $_POST['username'];

	$name = $_POST['name'];

	$pass = $_POST['password'];
	
	$bal = 0;	

	$stmt->execute();
	
	$stmt->close();
	
}

// function to log a user in if they already have a username
// no validation here needed as ajax has done the validation prior to submit
function userLogin() {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$findName = "SELECT name FROM users WHERE user='" . $_SESSION['username'] . "'";

	$result = $mysqli->query($findName);
	
	$receive = '';

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$receive = $row['name'];

	}

	$findBalance = "SELECT balance FROM users WHERE user='" . $_SESSION['username'] . "'";

	$money = $mysqli->query($findBalance);

	while ($balnc = $money->fetch_array(MYSQLI_ASSOC)) {
		$ba = $balnc['balance'];
	}

	$_SESSION['balance'] = $ba;
	$_SESSION['name'] = $receive;

	$result->close();


}

// three part function
// first, check if the user has a cart already to avoid inserting multiple of the same user
// second, if user has cart, get number of each soap already in cart
// then, add cart items
function addSoap($soap, $quant) {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$cartname = $_SESSION['username'];

	/* DOES THE USER HAVE A CART? */
	$finder = $mysqli->prepare("SELECT * FROM carts WHERE user=?");

	if (!$finder) {
		echo 'Prepare failed';
	}

	$finder->bind_param('s', $cartname);

	$finder->execute();

	$rows = $finder->get_result();

	// if no rows are returned, then the user doesn't exist and user doesn't need to be specified with where
	// also means that no need to retrieve current cart values

	if ($rows->num_rows == 0) {
		$newer = $mysqli->prepare("INSERT INTO carts (user, {$soap}) VALUES (?, ?)");

		if (!$newer) {
			echo 'Newer prepared statement failed.';
		}

		$newer->bind_param('si', $cartname, $quant);

		$newer->execute();

		$newer->close();

	}

	// if rows are returned, user exists, and their cart should be updated
	// second statement needed to retrieve current cart value
	// this is adding one soap at a time so only need to address value passed in via $soap
	else {

		$nowfind = $mysqli->prepare("SELECT {$soap} FROM carts WHERE user=?");

		$nowfind->bind_param('s', $cartname);

		$nowfind->execute();

		// what is returned is the number of soaps in the user's cart
		$numgive = $nowfind->get_result();

		while ($soaps = $numgive->fetch_assoc()) {
			if ($soap == 'orange') {
				$curr = $soaps['orange'];
			}
			if ($soap == 'swirl') {
				$curr = $soaps['swirl'];
			}
			if ($soap == 'church') {
				$curr = $soaps['church'];
			}
			if ($soap == 'butterfly') {
				$curr = $soaps['butterfly'];
			}
			if ($soap == 'antique') {
				$curr = $soaps['antique'];
			}

		}

		$nowfind->close();

		$quant = $quant + $curr;


		$existing = $mysqli->prepare("UPDATE carts SET {$soap}=? WHERE user=?");

		if (!$existing) {
			echo 'Existing prepare failed';
		}

		$existing->bind_param('is', $quant, $cartname);

		$existing->execute();

		$existing->close();

	}

	$finder->close();
}

// displays cart using data drawn from carts db
// adds it together for display
function displayCart() {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$cartname = $_SESSION['username'];

	$finder = $mysqli->prepare("SELECT * FROM carts WHERE user=?");

	if (!$finder) {
		echo 'Prepare failed';
	}

	$finder->bind_param('s', $cartname);

	$finder->execute();

	$getsoaps = $finder->get_result();

	while ($soaps = $getsoaps->fetch_assoc()) {
		$numOrange = $soaps['orange'];
		$numSwirl = $soaps['swirl'];
		$numAnt = $soaps['antique'];
		$numCh = $soaps['church'];
		$numButt = $soaps['butterfly'];
	}

	$sumOrange = $numOrange * 4.99;
	$sumSwirl = $numSwirl * 4.99;
	$sumAnt = $numAnt * 5.99;
	$sumCh = $numCh * 5.99;
	$sumButt = $numButt * 4.99;

	$soapTotal = $sumOrange + $sumSwirl + $sumAnt + $sumCh + $sumButt;



	// don't echo out a soap if the user hasn't purchased one
	if ($sumOrange != 0) {
		echo '<tr><td>Orange Cream</td>';
		echo '<td><center>' . $numOrange . '</center></td>';
		echo '<td>$4.99</td>';
		// delete button
		$rowId = 'orange';
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<center><input type="submit" value="Remove"></center></form>';
	}

	if ($sumSwirl != 0) {
		echo '<tr><td>Swirl</td>';
		echo '<td><center>' . $numSwirl . '</center></td>';
		echo '<td>$4.99</td>';
		$rowId = 'swirl';
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<center><input type="submit" value="Remove"></center></form>';
	}

	if ($sumAnt != 0) {
		echo '<tr><td>Antique</td>';
		echo '<td><center>' . $numAnt . '</center></td>';
		echo '<td>$5.99</td>';
		$rowId = 'antique';
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<center><input type="submit" value="Remove"></center></form>';
	}

	if ($sumCh != 0) {
		echo '<tr><td>Red Church</td>';
		echo '<td><center>' . $numCh . '</center></td>';
		echo '<td>$5.99</td>';
		$rowId = 'church';
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<center><input type="submit" value="Remove"></center></form>';
	}

	if ($sumButt != 0) {
		echo '<tr><td>Butterfly</td>';
		echo '<td><center>' . $numButt . '</center></td>';
		echo '<td>$4.99</td>';
		$rowId = 'butterfly';
		echo '<td><form action="delete.php" method="POST">';
		echo '<input type="hidden" name="id" value="' . $rowId . '">';
		echo '<center><input type="submit" value="Remove"></center></form>';
	}

	echo '<tr><td></td><td><b>Total: </b></td><td><span id="total">$' . $soapTotal . '</span></td>';

	// don't forget to update the user's balance in the user database
	updateBalance($soapTotal);

}

// function to update the database with the inventory when a user adds soaps to their cart
function updateInv($soap, $quant) {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}
	// first, a query to get the current total
	$findinit = "SELECT quantity FROM soaps WHERE name='" . $soap . "'";

	$findtotal = $mysqli->query($findinit);

	while ($nums = $findtotal->fetch_array(MYSQLI_ASSOC)) {
		$initotal = $nums['quantity'];
	}

	$endtotal = $initotal - $quant;

	// second, an update to the table with the new inventory
	$updater = $mysqli->prepare("UPDATE soaps SET quantity=? WHERE name=?");

	if (!$updater) {
		echo 'Updater prepare failed.';
	}

	$updater->bind_param('is', $endtotal, $soap);

	$updater->execute();

	$updater->close();

}

// updates balance each time a new soap is added to the cart
function updateBalance($soapTotal) {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$_SESSION['balance'] = $soapTotal;

	$cartname = $_SESSION['username'];

	$udate = $mysqli->prepare("UPDATE users SET balance=? WHERE user=?");

	if (!$udate) {
		echo 'Udate prepared statement failed.';
	}

	$udate->bind_param('ds', $soapTotal, $cartname);

	$udate->execute();

	$udate->close();
}

// function to display the comments for each soap
// passed in the page that is attempting to have the comments displayed
function displayComments($where) {
	global $host, $user, $pw, $db;

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$findcomments = $mysqli->prepare("SELECT * FROM comments WHERE name=?");

	if (!$findcomments) {
		echo 'Findcomments prepare failed.';
	}

	$findcomments->bind_param('s', $where);

	$findcomments->execute();

	$finder = $findcomments->get_result();

	while ($rows = $finder->fetch_assoc()) {
		echo '<p><b>' . $rows['user'] . '</b>';
		echo '<br>' . $rows['comment'];
		echo '<hr>';
	}
}

?>

