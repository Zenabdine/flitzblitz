<!DOCTYPE html>
<html lang="de" dir="ltr" class="redesign no-js" data-ffo-opensans="false" data-ffo-opensanslight="false">
<head><title>choose place</title>
<meta charset="iso-8859-1"/>
<style type="text/css">
body {
	       font-family : arial;
		   /*font-weight:bold;*/
		   color:white;
           counter-reset: number
}

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
  counter-increment: number;
}

div.kreis {
  width: 100px;
  height: 100px;
  border-radius: 50px;
  background-color: #000080;
  margin: 10px;
  counter-increment: number;
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

.invis{
	  display:inline;
	  color:grey;
}
      .red{
		  display:inline;
		  color:red;
	  }

      .ms { 
			position:absolute;
			!margin: 1cm;
			!background-color:#99FF99; 
			width: 200px;
			border: 0px solid;
			!margin: 0px 0px 0px 0px;
			top:20px;
			left:700px;
	  }
</style>
<link rel="stylesheet" type="text/css" href="../css3clock.css" />

</head>
<body bgcolor=grey>

<h1>Bitte wählen Sie ihren Sitz</h1>
<script>
function FensterOeffnen (Adresse) { 
MeinFenster = window.open(Adresse, "Zweitfenster", "width=300,height=100,left=10,top=10,menubar=no,location=no,resizeable=no" ); 
//MeinFenster.document.write("<p>ein neues Fenster!<br>(Besser wÃ¤re aber eine dialog-Box!)</p>"); 
MeinFenster.focus(); 
}

</script>

bitte klicken Sie auf den Platz auf dem Sie sitzen


<br>
zurück zur <a href="/">Startseite <img src=../img/icons/home.gif width=100 align=middle></a>
<br>
<br>

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

<!--  Klassenzimmer abbilden    -->
<table width=400 height=300 border=1>
<tr><?php for ($i=1;$i<=4;$i++) echo "<td><a href=report.php?seat=$i><div class=\"kreis\"></div></a></td>"?></tr>
<tr><?php for ($i=5;$i<=8;$i++) echo "<td><a href=report.php?seat=$i><div class=\"kreis\"></div></a></td>"?></tr>
<tr><td><div class=\"kreisg\"></div></td><?php for ($i=9;$i<=11;$i++) echo "<td><a href=report.php?seat=$i><div class=\"kreis\"></div></a></td>"?></tr>
</table>



</body>
