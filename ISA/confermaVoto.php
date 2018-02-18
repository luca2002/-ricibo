<?php
require '../funzioni/oDBConn.php';
$codUscita = oDBConn();
if (is_numeric($codUscita)){
	if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
	elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
}
else{//il database è connesso
	$db = $codUscita;
}
//riceviamo i dati dal url e li sanitizziamo.
if (isset($_GET['id'])){
	echo filter_var($_GET['id'],FILTER_VALIDATE_INT);
	
}
else{echo'errore!!';}
?>
<html>
</html>