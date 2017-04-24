<html lang="de" dir="ltr" class="redesign no-js" data-ffo-opensans="false" data-ffo-opensanslight="false">
<head>
	<meta charset="utf-8">
	<style>
	      .red{
			  display:inline;
			  color:red;
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
				top:0;
				left:600;
		  }
	</style>
		
	<!--[if lt IE 9]>
	  <script type="text/javascript" src="../excanvas.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../station-clock.js"></script>
	<script type="text/javascript">
	  var clock = new StationClock("clock");
	  clock.body = StationClock.NoBody;
	  clock.dial = StationClock.GermanStrokeDial;
	  clock.hourHand = StationClock.PointedHourHand;
	  clock.minuteHand = StationClock.PointedMinuteHand;
	  clock.secondHand = StationClock.HoleShapedSecondHand;
	  clock.boss = StationClock.NoBoss;
	  clock.minuteHandBehavoir = StationClock.BouncingMinuteHand;
	  clock.secondHandBehavoir = StationClock.OverhastySecondHand;
	  window.setInterval(function() { clock.draw() }, 50);
	</script>
	<script>
		function FensterOeffnen (Adresse) { 
		MeinFenster = window.open(Adresse, "Zweitfenster", "width=300,height=100,left=10,top=10,menubar=no,location=no,resizeable=no" ); 
		//MeinFenster.document.write("<p>ein neues Fenster!<br>(Besser wäre aber eine dialog-Box!)</p>"); 
		MeinFenster.focus(); 
		}
		function getValue(){
		    // alert (document.getElementById("classs").value);
		    //document.getElementById("demo").innerHTML = "You selected: " + x;
			  classroom.classroomi.value= document.getElementById("classs").value;
		
		  }
	</script>
	<title>status get</title>
</head>
<body bgcolor=grey>
	<font face=arial color=white>
	<!-- <basefont face=arial color=white>  -->
	<basefont face=arial color=white>

		<h1>Trainer-Seite</h1>
		Übersicht-Seite Trainer, zum aktualisieren bitte hier <a
		href=status.html onclick="document.location.reload(); return false">klicken</a>
		<table border=1 cellspacing=0 !align=center style="margin: 50 0 0 100">
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
		<br>
		<form name=classroom>
			Bitte Klassenzimmer auswählen:<br> <select id=classs name=classrooms
				!onchange="getValue();">
				<optgroup label="Klassenzimmer EG">
					<option>Aula</option>
					<option>Kaffeeautomat</option>
					<option>Empfang</option>
					<option>Nebenraum</option>
				</optgroup>
				<optgroup label="Klassenzimmer 1. OG">
					<option>Stockholm</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="Klassenzimmer 2. OG">
					<option selected>Düsseldorf</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="Klassenzimmer 3. OG">
					<option>Technikraum</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="extern 1">
					<option>Extern 1</option>
					<option>Extern 2</option>
					<option>Extern 3</option>
					<option>Extern 4</option>
				</optgroup>
				<optgroup label="extern 2">
					<option>Extern 11</option>
					<option>Extern 12</option>
					<option>Extern 13</option>
					<option>Extern 14</option>
				</optgroup>

			</select>
			<!-- <input name=classroomi value="Düsseldorf"> </input> -->
			<input type=submit value="Klassenzimmer abfragen" name=send>
		</form>


		<form name=classroom action="formaction.php">
			<br> <br>
			<div class=darkblue>Verwaltung-Tools</div>
			<br> Bitte Klassenzimmer auswählen:<br>
			<select id=classs name=location !onchange="getValue();">
				<optgroup label="Klassenzimmer EG">
					<option>Aula</option>
					<option>Kaffeeautomat</option>
					<option>Empfang</option>
					<option>Nebenraum</option>
				</optgroup>
				<optgroup label="Klassenzimmer 1. OG">
					<option>Stockholm</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="Klassenzimmer 2. OG">
					<option value="duesseldorf" selected>D&uuml;sseldorf</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="Klassenzimmer 3. OG">
					<option>Technikraum</option>
					<option></option>
					<option></option>
					<option></option>
				</optgroup>
				<optgroup label="extern 1">
					<option>Extern 1</option>
					<option>Extern 2</option>
					<option>Extern 3</option>
					<option>Extern 4</option>
				</optgroup>
				<optgroup label="extern 2">
					<option>Extern 11</option>
					<option>Extern 12</option>
					<option>Extern 13</option>
					<option>Extern 14</option>
				</optgroup>
			</select>
			<!-- <input type=submit value="&Uuml;bung verwalten" name=send> -->
			<button type=submit name="action" value="manage">Klassenzimmer neustarten</button>
		</form>
		
		<!-- { start | stop | restart } exercise -->

		<div class=ms>
			<canvas id="clock" width="200" height="200">
	  			Dieser Browser wird leider nicht unterstützt.
			</canvas>
		</div>
	</font>
</body>
</html>

