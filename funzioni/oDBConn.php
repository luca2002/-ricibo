<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
	$nomeUtente = substr($_SESSION['PATH'],2);
	$DBuser = $nomeUtente;
	$DBpass = $nomeUtente;
	$DBName = $nomeUtente;
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost, $DBuser, $DBpass);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita
	else {
		$ris = mysqli_select_db($DBName);
		if (!$ris) {  // Errore: DB non trovato
			mysqli_close($codUscita);
			$codUscita = 2;
		}
	}
	return $codUscita;
}
?>
