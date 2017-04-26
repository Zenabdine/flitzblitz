<html lang="de" dir="ltr" class="redesign no-js" data-ffo-opensans="false" data-ffo-opensanslight="false">
<meta http-equiv="refresh" content="30" > 
<meta charset="ISO-8859-1">
<style>
table{
		border-spacing: 0px;
	    padding: 0px;
		margin: 0 0 0 30px;
		border: 1px solid white
}

div.kreisg {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  background-color: grey;
  margin: 10px;
  counter-decrement: number -1;
}

div.kreis {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  background-color: #000080;
  margin: 10px;
  counter-increment: number -1;
}

div.kreis::after{
    content: counter(number);
    position: relative;
    color: white;
    width: 100%;
    text-align: center;
    top: 43px;
    left:43px;
}

div.kreis:hover {
  background-color: red;
}

.containerdivNewLine { clear: both; float: left; display: block; position: relative; } 

div.ovalr {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  background-color: #990000;
  margin: 5px;
  float: left;
}
div.ovalg {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  background-color: green;
  margin: 5px;
  float: left;
}

body {
   padding: 100 px,100 px, 100px,100 px;
   margin: 100 px,100 px, 100px,100 px;
   counter-reset: number 12
}

.red{
		  display:inline;
		  color:#990000;
	  }
      .darkblue{
		  display:inline;
		  color:darkblue;
	  }
      form { 
	       float: center;
	       !align-content: center;
		   width: 500;
		   border: 0px solid;
		   margin: 0 0 0 100
	  }
      td {
	       font-family : arial;
		   font-weight:bold;
		   color:white;
	  }
	  
      .ms { 
			position:absolute;
			!margin: 1cm;
			!background-color:#99FF99; 
			width: 200px;
			border: 0px solid;
			!margin: 0px 0px 0px 0px;
			top:20px;
			left:600;
	  }
</style>
<link rel="stylesheet" type="text/css" href="../css3clock.css" />
	
<body bgcolor=grey>
<title>status get</title>
<font face=arial color=white>
<basefont face=arial color=white>

<h1>Trainer-Seite</h1>
<script>
function confirm_Click() {
    var strconfirm = confirm("Neue Übung starten?");
    if (strconfirm == true) 
        return true;
	else 
		return false;
}
function FensterOeffnen (Adresse) { 
MeinFenster = window.open(Adresse, "Zweitfenster", "width=300,height=100,left=10,top=10,menubar=no,location=no,resizeable=no" ); 
//MeinFenster.document.write("<p>ein neues Fenster!<br>(Besser wÃ¤re aber eine dialog-Box!)</p>"); 
MeinFenster.focus(); 
}
function getValue(){
    // alert (document.getElementById("classs").value);
    //document.getElementById("demo").innerHTML = "You selected: " + x;
	  classroom.classroomi.value= document.getElementById("classs").value;

  }

</script>
<?php
// alles klar, jetzt kommt Datebankabfrage, wer im Klassenzimmer sitzt

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

// LÃ¶schabfrage zuerst abfangen, z.B. bei neuer Aufgabe
$action = $_POST["action"];
if($action=="delete"){
	// del all states, students and hosts
	$sql = "DELETE FROM states WHERE 1";
	$result = $conn->query($sql);
	$sql = "DELETE FROM students WHERE 1";
	$result = $conn->query($sql);
	$sql = "DELETE FROM workstations WHERE 1";
	$result = $conn->query($sql);
}

// In Datebank schauen wieviele Schüler im Klassenzimmer
$now=time();
// jetzt - 12h
$from=$now-(12*60*60);
$from_ts=  date('Y-m-d H:m:s', $from);

// find all sessions newer than 8 hours
$sql = "SELECT finished, seat from states inner join students on students.id=student where session_created>'$from_ts'";
$result = $conn->query($sql);
//echo "gefunden: $result->num_rows";
$found_students=$result->num_rows;
$students=array();
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $students[]=array($row["finished"],$row["seat"]);
    }
} else {
    echo "0 results";
}

?>

Übersicht-Seite Trainer, zum aktualisieren bitte hier 
<a href=status.php !onclick="document.location.reload(); return false">klicken <img src=../img/icons/reload.gif width=100 align=middle style="position:absolute; top:45px"></a><br style="clear:both">

(Seite wird alle 30 automatisch aktualisiert),
<br>zurück zur <a href=/>Startseite <img src=../img/icons/home.gif width=100 align=middle></a>
<br>
<br>
Zur zeit sind <div class=red><b><?php echo $found_students?></b></div> Studenten angemeldet:<br>

<!--  Klassenzimmer abbilden    -->
<table width=400 height=300 border=1>
<tr><?php for ($i=11;$i>=9;$i--) echo "<td><div class=\"kreis\" id=\"kreis$i\"></div></td>"?><td><div class="kreisg"></div></td></tr>
<tr><?php for ($i=8;$i>=5;$i--) echo "<td><div class=\"kreis\" id=\"kreis$i\"></div></td>"?></tr>
<tr><?php for ($i=4;$i>=1;$i--) echo "<td><div class=\"kreis\" id=\"kreis$i\"></div></td>"?></tr>
</table>

<script type="text/javascript">
<?php
// Jetzt Lampen dynamisch aufbauen:
$result = $conn->query($sql);
while($row = mysqli_fetch_assoc($result)) {
	//echo "$i i: ".$students[0][0] . " val: ".$students[0][1]." val: ".$students[0][2]."<br>";
	if ($row["finished"])
		echo "document.getElementById(\"kreis". $row["seat"] . "\").style.background = \"green\";\n";
    else
		echo "document.getElementById(\"kreis" . $row["seat"] . "\").style.background = \"#990000\";\n";
}

?>
</script>
<?php 
/*
 $i=0;$j=0;
foreach ($students as $i => $value) {
	//echo "i: ".$i . " val: ".$value."<br>";
	if ($i>0 and $i%4==0)
		if ($value){
			echo "<div class=containerdivnewline></div>";
			echo "<div class=\"ovalg\"></div>";
		}
	else{
		echo "<div class=containerdivnewline></div>";
		echo "<div class=\"ovalr\"></div>";
	}
	else{
		if ($value)
			echo "<div class=\"ovalg\"></div>";
			else
				echo "<div class=\"ovalr\"></div>";
	}
}

 for ($i=0;$i<$found_students;$i++)
 {
 if ($i%4==0){
 echo "<div class=containerdivnewline></div>";
 echo "<div class=\"oval\"></div>";
 }
 else
 echo "<div class=\"oval\"></div>";
 }
 */
 ?>


<br style="clear:left">
<!-- Tabelle war nur Platzhalter
<table border=1 cellspacing=0 !align=center style="margin:50 0 0 100">
<tr>
  <td width=100 height=100 bgcolor=#A61A1A align=center>9</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>10</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center></td>
  <td width=100 height=100 bgcolor=#A61A1A align=center></td>
</tr>
<tr>
  <td width=100 height=100 bgcolor=#A61A1A align=center>5</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>6</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>7</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>8</td>
</tr>
<tr>
  <td width=100 height=100 bgcolor=#A61A1A align=center>1</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>2</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>3</td>
  <td width=100 height=100 bgcolor=#A61A1A align=center>4</td>
</tr>
</table>
 -->
<br>
<form name=classroom_list>
Bitte Klassenzimmer auswählen:<br>

<select id=classs name=classrooms !onchange="getValue();"> 
<optgroup label="Klassenzimmer EG">
   <option> Aula </option>
   <option> Kaffeeautomat</option>
   <option> Empfang </option>
   <option> Nebenraum</option>
<optgroup label="Klassenzimmer 1. OG">
   <option> Stockholm</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="Klassenzimmer 2. OG">
   <option selected> Düsseldorf</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="Klassenzimmer 3. OG">
   <option> Technikraum</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="extern 1">
   <option> Extern 1</option>
   <option> Extern 2</option>
   <option> Extern 3</option>
   <option> Extern 4</option>
<optgroup label="extern 2">
   <option> Extern 11</option>
   <option> Extern 12</option>
   <option> Extern 13</option>
   <option> Extern 14</option>
</select>   
<!-- <input name=classroomi value="Düsseldorf"> </input>
 -->
 <input type=submit value="Klassenzimmer abfragen" name=send>
 
 </form>


<form name=classroom_del action="status.php" method="post" onsubmit="return(confirm_Click())">
<input type=hidden name=action value=delete>
<br>
<br>
<div class=darkblue>Verwaltung-Tools</div><br>
Bitte Klassenzimmer auswählen:<br>

<select id=classs name=classrooms !onchange="getValue();"> 
<optgroup label="Klassenzimmer EG">
   <option> Aula </option>
   <option> Kaffeeautomat</option>
   <option> Empfang </option>
   <option> Nebenraum</option>
<optgroup label="Klassenzimmer 1. OG">
   <option> Stockholm</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="Klassenzimmer 2. OG">
   <option selected> Düsseldorf</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="Klassenzimmer 3. OG">
   <option> Technikraum</option>
   <option> </option>
   <option> </option>
   <option> </option>
<optgroup label="extern 1">
   <option> Extern 1</option>
   <option> Extern 2</option>
   <option> Extern 3</option>
   <option> Extern 4</option>
<optgroup label="extern 2">
   <option> Extern 11</option>
   <option> Extern 12</option>
   <option> Extern 13</option>
   <option> Extern 14</option>
</select>   
 <input type=submit value="Klassenzimmer neustarten" name=delete>
 
 </form>


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

</body>
