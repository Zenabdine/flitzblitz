<!DOCTYPE html>
<html lang="de" dir="ltr" class="redesign no-js" data-ffo-opensans="false" data-ffo-opensanslight="false">
<head><title>status send</title>
<meta charset="ISO-8859-1">
<style>
body {
	       font-family : arial;
		   /*font-weight:bold;*/
		   color:white;
}
      .invis{
		  display:inline;
		  color:grey;
	  }
.red{
		  display:inline;
		  color:#990000;
	  }
      .darkblue{
		  display:inline;
		  color:darkblue;
	  }

      .ms { 
			position:absolute;
			!margin: 1cm;
			!background-color:#99FF99; 
			width: 200px;
			border: 0px solid;
			!margin: 0px 0px 0px 0px;
			top:20px;
			left:500px;
	  }
</style>
<link rel="stylesheet" type="text/css" href="../css3clock.css" />

</head>
<body bgcolor=grey>

<h1>Studenten-Seite</h1>
<script>
function FensterOeffnen (Adresse) { 
MeinFenster = window.open(Adresse, "Zweitfenster", "width=300,height=100,left=10,top=10,menubar=no,location=no,resizeable=no" ); 
//MeinFenster.document.write("<p>ein neues Fenster!<br>(Besser wäre aber eine dialog-Box!)</p>"); 
MeinFenster.focus(); 
}

</script>
<?php 
$url="open.php";
$message ="";
// server should keep session data for AT LEAST 12 hour
ini_set('session.gc_maxlifetime', 12*60*60);
// each client should remember their session id for EXACTLY 12 hour
session_set_cookie_params(12*60*60);
session_start();

$ip = getenv('REMOTE_ADDR');
$id = session_id();
try { $seat = $_GET["seat"]; }
catch (Exception $ex) { $seat = 0; }

// Datenbank verbinden
$servername = "localhost";
$username = "sp";
$password = "ServicePanel";
$dbname   = "lug_finished";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

// In Datebank schauen ob Session schon angelegt ist
$sql = "SELECT id FROM students where session_id =\"$id\"";
$result = $conn->query($sql);

if ( $result->num_rows > 0){
	// User existiert, dann abfragen ob schon fertig
	$row = mysqli_fetch_assoc($result);
	$student_id= $row["id"];
	$sql = "SELECT finished, seat FROM states where student =$student_id";
	$result = $conn->query($sql);
	
	if ( $result->num_rows > 0){
		$row = mysqli_fetch_assoc($result);
		$message = "Sie haben den Platz Nr.: <div class=red><b>".$row["seat"]."</div> ausgesucht.\n";
		$finished =$row["finished"];
		if ($finished)
			$url="ready.php";
		else 
	    	$url="open.php";
	}
	else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

}
else{
	// User wird eingetragen
	//echo "User wird eingetragen<br>";
	$now = getdate();
	$timestamp="$now[year]-$now[mon]-$now[mday] $now[hours]:$now[minutes]:$now[seconds]";
	$sql = "insert into students (session_id, session_created, workstation) value ('$id', '$timestamp', '$seat')";
	$message = "Sie haben den Platz Nr.: <div class=red><b>$seat</div> ausgesucht.\n";
	//$sqlInsWs = "INSERT INTO students ";
	$student_id=0;
	if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
		$student_id= mysqli_insert_id($conn);
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

    // jetzt in Tabelle workstations eintragen
	$sql = "insert into workstations (name) value ('na')";
	if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
	$workstation_id= mysqli_insert_id($conn);
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	// jetzt in Tabelle states eintragen
	$sql = "insert into states (id, workstation, student, finished,help, seat) value ('$timestamp', $workstation_id,'$student_id', '0','0','$seat')";
	//echo $sql;die(0);
	if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
	} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}

}

?>

Trainer feedback geben und roten Schalter drücken, wenn fertig


<br>
zur�ck zur <a href="/">Startseite <img src=../img/icons/home.gif width=100 align=middle></a>
<br>
<br>
<?php echo $message?>

<!--Sie habe die <div class=red>ID: -->
<div class=invis>
ihre IP ist : <?php echo $ip;?><br>
ihre ID ist : <?php echo $id;?><br>
</div>
<!-- </div> erhalten! -->
<div class=ms> 
<div id="liveclock" class="outer_face">

<div class="marker oneseven"></div>
<div class="marker twoeight"></div>
<div class="marker fourten"></div>
<div class="marker fiveeleven"></div>

<div class="inner_face">
<div class="hand hour"></div>
<div class="hand minute"></div>
<div class="hand second"></div>
</div>

</div>

<script src="../jquery.js"></script>

<script type="text/javascript">

/***********************************************
* CSS3 Analog Clock- by JavaScript Kit (www.javascriptkit.com)
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more
***********************************************/

var $hands = $('#liveclock div.hand')

window.requestAnimationFrame = window.requestAnimationFrame
                               || window.mozRequestAnimationFrame
                               || window.webkitRequestAnimationFrame
                               || window.msRequestAnimationFrame
                               || function(f){setTimeout(f, 60)}


function updateclock(){
	var curdate = new Date()
	var hour_as_degree = ( curdate.getHours() + curdate.getMinutes()/60 ) / 12 * 360
	var minute_as_degree = curdate.getMinutes() / 60 * 360
	var second_as_degree = ( curdate.getSeconds() + curdate.getMilliseconds()/1000 ) /60 * 360
	$hands.filter('.hour').css({transform: 'rotate(' + hour_as_degree + 'deg)' })
	$hands.filter('.minute').css({transform: 'rotate(' + minute_as_degree + 'deg)' })
	$hands.filter('.second').css({transform: 'rotate(' + second_as_degree + 'deg)' })
	requestAnimationFrame(updateclock)
}

requestAnimationFrame(updateclock)


</script>
</div>

<iframe id="reporter" src="<?php echo $url?>"></iframe>



</body>
