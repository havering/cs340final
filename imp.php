<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// user creates login, sends POST information to db
function userCreate() {
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

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
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

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
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

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
		$newer = "INSERT INTO carts (user," . $soap . ") VALUES ('" . $cartname . "', '" . $quant . "')";

		$mysqli->query($newer);
	}

	// if rows are returned, user exists, and their cart should be updated
	// second statement needed to retrieve current cart value
	// this is adding one soap at a time so only need to address value passed in via $soap
	else {

		$nowfind = "SELECT " . $soap . " FROM carts WHERE user='" . $cartname . "'";

		$getsoap = $mysqli->query($nowfind);

		while ($soaps = $getsoap->fetch_array(MYSQLI_ASSOC)) {
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

		$quant = $quant + $curr;


		$existing = "UPDATE carts SET " . $soap . "=" . $quant . " WHERE user='" . $cartname . "'";

		$mysqli->query($existing);

	}

	$finder->close();
}

// displays cart using data drawn from carts db
// adds it together for display
function displayCart() {
	$host = '.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'yNlBHwYIyC3BdLuK';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$cartname = $_SESSION['username'];

	$finder = "SELECT * FROM carts WHERE user='" . $cartname . "'";

	if (!$finder) {
		echo 'Prepare failed';
	}

	$getsoaps = $mysqli->query($finder);

	while ($soaps = $getsoaps->fetch_array(MYSQLI_ASSOC)) {
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
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

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
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

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
	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = '';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$findcomments = "SELECT * FROM comments WHERE name='". $where . "'";

	$finder = $mysqli->query($findcomments);

	while ($rows = $finder->fetch_array(MYSQLI_ASSOC)) {
		echo '<p><b>' . $rows['user'] . '</b>';
		echo '<br>' . $rows['comment'];
		echo '<hr>';
	}
}

?>

