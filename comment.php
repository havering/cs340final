<?php
	//ini_set('session.save_path', '/nfs/stak/students/o/ohaverd/session');
	session_start();

	$host = 'oniddb.cws.oregonstate.edu';
	$db = 'ohaverd-db';
	$user = 'ohaverd-db';
	$pw = 'delete';

	$mysqli = new mysqli($host, $user, $pw, $db);
	if ($mysqli->connect_errno) {
		echo 'Failed to connect to MySQLi: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	$cartname = $_SESSION['username'];
	$comment = $_POST['comment'];
	$where = $_POST['wherefrom'];

	$addcomment = $mysqli->prepare("INSERT INTO comments (user, name, comment) VALUES (?, ?, ?)");

	if (!$addcomment) {
		echo 'Addcomment prepare fail';
	}

	$addcomment->bind_param('sss', $cartname, $where, $comment);

	$addcomment->execute();

	$addcomment->close();

	if ($where == 'orange') {
		header('LOCATION: orange.php');
	}

	if ($where == 'swirl') {
		header('LOCATION: swirl.php');
	}

	if ($where == 'butterfly') {
		header('LOCATION: butterfly.php');
	}

	if ($where == 'antique') {
		header('LOCATION: antique.php');
	}

	if ($where == 'church') {
		header('LOCATION: church.php');
	}
?>