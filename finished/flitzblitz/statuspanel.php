<?php
session_start();
include "dbconnect.php"; // returns pdo database handler $dbh

define('DEBUG', true);

if (isset($_SESSION['finished']))
	$finished = $_SESSION['finished'];
else $finished = array();

if (DEBUG) {
	echo '$_REQUEST:';
	var_dump($_REQUEST);
}
if (isset($_REQUEST['action']))
	switch ($_REQUEST['action']) {
		case 'select_room':
			if ($_REQUEST['user'] == 'student') {
				// 2do: get active exercises for $_SERVER['location'] = { duesseldorf, dortmund, berlin, frankfurt, karlsruhe }
				$sth = $dbh->prepare('SELECT active_exercise FROM rooms WHERE name = ?');
				if (!isset($_SERVER['location'])) {
					if (DEBUG)
						$stmt_success = $sth->execute(['duesseldorf']); // null?
				}
				else
					$stmt_success = $sth->execute($_SERVER['location']);
				if (DEBUG) echo "stmt-execute: $stmt_success <br/>";
				if (DEBUG) echo "rowCount(): " . $sth->rowCount() . "<br/>";
				// http://localhost/Finish-IT.php/statuspanel.php?action=select_room&location=duesseldorf&user=student
				// 2do: check if exercise exists. create one if it doesn't.
				$exercise = $sth->fetch(PDO::FETCH_ASSOC);
				
				if (!$exercise) // there is currently no exercise in this room --> initialise new exercise. notify about trainer absence.
					$sth = $dbh->prepare("INSERT INTO exercises ");
					create_exercise($room, false);
					;
			}
			break;
		case 'register':
			$finished[$_SERVER['REMOTE_ADDR']] = false;
			$dbr = $dbh->query("select * from states");
			var_dump($dbr);
			header("Location: students/open.html"); /* Redirect browser */
			exit();
		case 'finish':
			$finished[$_SERVER['REMOTE_ADDR']] = true;
			$dbr = $dbh->query("select * from states");
			while ($row = $dbr->fetch())
			{
				var_dump($row);
			}
			break;
		case 'unfinish':
			$finished[$_SERVER['REMOTE_ADDR']] = false;
		break;
	}

if (isset($finished))
	foreach ($finished as $ws => $isfinished) {
		if ($isfinished) {
			echo $ws . "<br />";
		}
	}
?>
