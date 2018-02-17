<html>
<?php
if (isset($_GET['ID'])) { $ID_AREA = $_GET['ID']; } else { $ID_AREA = -1; }
if ($ID_AREA > -1) { $Tipo = 2; } else { $Tipo = 1; }
?>
<head>
	<?php include 'menuHead.php'; ?>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php
	$codUscita = 0;
	include 'funzioni/oDBConn.php';
	include 'funzioni/FunctionsMaps.php';
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) {
		if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
		elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); }
	} else {
		$db=$codUscita;
		sMap1($Tipo, $ID_AREA,$db);
		mysqli_close($db);
	}
?>
</head>
<body bgcolor="white">
	<?php include "menu.php"; ?></br></br>
	<div class="container">
	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center">
	<div class="card-content white-text">
	<?php sMap2($Tipo); ?>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
