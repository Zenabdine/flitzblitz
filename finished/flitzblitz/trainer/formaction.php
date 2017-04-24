<?php
	include "../dbconnect.php";
	
	if (DEBUG) {
		echo __FILE__.':'.__LINE__.'$_REQUEST:<br/>';
		var_dump($_REQUEST);
	}
	
	if (!isset($_REQUEST['location'])) {
		if (DEBUG)
			$location = 'duesseldorf';
		else ;		// throw no location exception 
	} else
		$location = $_REQUEST['location'];
		
		$exercise = get_active_exercise($location, $dbh);
		if (DEBUG) {
			echo __FILE__.':'.__LINE__.':get_active_exercise(): ';
			var_dump($exercise);
		}
	
	if ($exercise == 0) { // no active exercise --> create one.
		try {
			$timestamp = date('Y-m-d H:i:s');
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$dbh->beginTransaction();
// 			$sth = $dbh->query("INSERT INTO `exercises` (`start`, `name`, `status`, `current`) VALUES (NOW(), `Übung 1`, null, true)");
			$sth = $dbh->exec("INSERT INTO `exercises` VALUES (NOW(), null, '$timestamp', true, '$location')");
			echo __FILE__.':'.__LINE__.':_insert new exercise_: ';
			print_r($sth); echo '<br/>';
			if (DEBUG) {
				if (!$sth) {
					if ($sth === 0) {	// query successful && 0 rows.
						echo __FILE__.':'.__LINE__."_insert into exercise_: $sth<br/>";
					}
					// query unsuccessful
					echo __FILE__.':'.__LINE__."_insert into `exercise`_ failed.";
				} else { // query successful
					echo __FILE__.':'.__LINE__."_insert into `exercise`_: $sth <br/>";
				}
			}
			
			$sth = $dbh->exec("INSERT INTO `rooms` VALUES ('$location', null, null, null, '$timestamp')");
			if (DEBUG) {
				if (!$sth) {
					if ($sth === 0) {	// query successful && 0 rows.
						echo __FILE__.':'.__LINE__.":_insert into `rooms`_: $sth<br/>";
					}
					// query unsuccessful
					echo __FILE__.':'.__LINE__.":_insert into `rooms`_ failed.";
				} else { // query successful
					echo __FILE__.':'.__LINE__.":_insert into `rooms`_: $sth <br/>";
				}
			}
			$dbh->commit();
		} catch(PDOException $e) {
			$dbh->rollBack();
			echo "Could not create exercise: " . $e->getMessage();
		}
	}
	if (DEBUG) {
		echo __FILE__.':'.__LINE__.':'.'$_REQUEST: ';
		echo var_dump($_REQUEST);
	}
	
	if (isset($_REQUEST['action']))
		switch ($_REQUEST['action']) {
			case 'manage':
// 				if (!isset($_REQUEST['location'])) {
// 					if (DEBUG)
// 						$stmt_success = $sth->execute(['duesseldorf']); // null?
// 				} else
// 					$stmt_success = $sth->execute([$_REQUEST['location']]);
				$sth = $dbh->prepare('SELECT * FROM `exercises` WHERE `room` = ?');
				$stmt_success = $sth->execute([$_REQUEST['location']]);
				if (false) {
					echo __FILE__.':'.__LINE__.':'.'_select * from `execises_:$stmt_success: '.$stmt_success.'<br/>';
					echo __FILE__.':'.__LINE__.':'.'_select * from `execises_: ';
					echo var_dump($sth);
					echo __FILE__.':'.__LINE__.':'.'_select * from `execises_:$result:';
					echo var_dump($sth->fetchAll());
				}
				echo "<html><body>";
					echo "<form action=\"formaction.php\" method=\"post\">";
						while ($row = $sth->fetch()) {
							echo "<p>Raum: ". ucwords($row[4]) ." Start: $row[0] Name: $row[1] aktiv: $row[3]</p>";
							
						}
						echo "<button type=\"submit\" name=\"action\" value=\"stop\">&Uuml;bung stoppen</button>";
						echo "<button type=\"submit\" name=\"action\" value=\"restart\">&Uuml;bung neustarten</button>";
						echo "<input type=\"hidden\" name=\"location\" value=\"" . $_REQUEST['location'] . "\">";
						echo "<input type=\"hidden\" name=\"exercise\" value=\"" . $row[0] . "\">";
					echo "</form>";
				echo "</body></html>";
				break;
			case 'stop';
				if (isset($_REQUEST['location'])) {
					if (isset($_REQUEST['exercise'])) {
						try {
							$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$dbh->beginTransaction();
							$sth = $dbh->prepare("UPDATE `exercises` SET `current` = 0 WHERE `start` = ?");
							$stmt_success = $sth->execute([$_REQUEST['exercise']]);
							if (DEBUG) {
								echo __FILE__.':'.__LINE__.':'."UPDATE `exercises` SET `current` = 0: $stmt_success<br/>";
							}
							$sth = $dbh->prepare("UPDATE `rooms` SET `active_exercise` = null WHERE `name` = ?");
							$stmt_success = $sth->execute([$_REQUEST['location']]);
							if (DEBUG) {
								echo __FILE__.':'.__LINE__.':'."UPDATE `rooms` SET `active_exercise` = 0: $stmt_success<br/>";
							}
							$dbh->commit();
						} catch(PDOException $e) {
							$dbh->rollBack();
							echo "Could not create exercise: " . $e->getMessage();
						}
					} else { /* throw no exercise exception */
						if (DEBUG) {
							echo __FILE__.':'.__LINE__.':'."no exercise exception";
						}
					}
				} else { /* throw no location exception */
					if (DEBUG) {
						echo __FILE__.':'.__LINE__.':'."no location exception";
					}
				}
				break;
		}