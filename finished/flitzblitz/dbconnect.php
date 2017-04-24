<?php
$servername = "localhost";
$username = "root";
$password = "lugfinished";
$database = "lug_finished";

define('DEBUG', true);

try {
	$dbh = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	// set the PDO error mode to exception
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (DEBUG) echo __FILE__.':'.__LINE__.":Connected successfully <br/><br/>";
}
catch(PDOException $e)
{
	echo __FILE__.':'.__LINE__."Connection failed: " . $e->getMessage();
}

function create_exercise($room, $has_trainer) {
	
}

function get_active_exercise($room, $dbh) {
	
	if (!isset($room)) {
		if (DEBUG)
			$room = 'duesseldorf';
			else echo __FILE__.':'.__LINE__."get_acive_exercise(): no room given";
	}
	
	$sql = 'SELECT COUNT(*) FROM `room` WHERE name = ?';
	$sth = $dbh->prepare($sql);
	$statement_success = $sth->execute([$room]);
	if ($statement_success) {
		if ($sth->fetchColumn() > 0) {
			if ($sth->fetchColumn() > 1) {
				if (DEBUG) echo __FILE__.':'.__LINE__.":get_active_exercise(): more than one active exercise.<br/>";
			} else {
				$sql = 'SELECT active_exercise FROM rooms WHERE name = ?';
				$sth = $dbh->prepare($sql);
				$sth->execute([$room]);
			}
		}
	}
	
	if (DEBUG) echo __FILE__.':'.__LINE__.":get_active_exercise()::stmt-execute: $statement_success <br/>";
	if (DEBUG) echo __FILE__.':'.__LINE__.":get_active_exercise()::rowCount(): " . $sth->rowCount() . "<br/>";
	// http://localhost/Finish-IT.php/statuspanel.php?action=select_room&location=duesseldorf&user=student
	// 2do: check if exercise exists. create one if it doesn't.
	if ($statement_success) {
		if ($sth->rowCount() > 0) {
			if ($sth->rowCount() > 1)
				if (DEBUG) echo __FILE__.':'.__LINE__.":get_active_exercise(): more than one active exercise.<br/>";
			return $sth->fetchAll(PDO::FETCH_ASSOC);
		} else if ($sth->rowCount() == 0) return 0;
	}
	else return -1;
}