<?php
function oDBConn() {
	// INFO DB
	$DBhost = "localhost";  // "93.46.220.3";
<<<<<<< HEAD
=======
	$DBuser = "root";
	$DBpass = "";
>>>>>>> a9e41fb36d0dbea72f6e8f1f27fc76c2bf1b5cf3
	$DBName = "ricibo";
	$codUscita = 0;
	$codUscita = mysqli_connect($DBhost,'root','',$DBName);
	if (!$codUscita) { $codUscita = 1; } // Errore: connessione al DB fallita

	return $codUscita;
}
?>
