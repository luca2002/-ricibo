<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php";
	echo "</br></br><div class=\"container\">";
	include "../funzioni/sLeggiMailID_USER.php";
	include "../funzioni/sAccodaMail.php";
	$ID_USER=$_GET['ID'];
	if (!isset($ID_USER)) { $ID_USER="";}	
	if (!is_numeric($ID_USER))
		{ $codUscita=5; } // UTENTE NON TROVATO
	else {
		// CONNESSIONE AL DB, CON INCLUDE DELLE FUNZIONI
		include "../funzioni/oDBConn.php";
		$codUscita = oDBConn();
// echo ("</br> codUscita=" . $codUscita);
		if (is_numeric($codUscita)) { // GESTIONE ERRORI DI CONNESSIONE
			if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
			elseif ($codUscita == 2 ) {
				echo("</br>Errore: DB non trovato.");
				mysqli_close($codUscita );
			}
		} else { // SE TUTTO OK, SALVO LA CONNESSIONE AL DB
			$db = $codUscita;
			$codUscita = 0;
		}
// echo ("</br> codUscita=" . $codUscita);
		if ($codUscita==0) {
			$sql = "UPDATE TB_USER SET FLAG_REG=0 WHERE (ID_USER=$ID_USER);";
// echo ("</br> sql=" . $sql);
			$result = mysqli_query($db,$sql);
// echo "</br> result=" . $result;
			if ($result == false) {
				$codUscita=3;   // Fallita la conferma registrazione su FLAG_REG
			} else {
				$mailDest = sLeggiMailID_USER($ID_USER);
				if ($mailDest == "")
					{ $codUscita=4; } // Errore sull'avanzamento della registrazione
				else { // INVIO MAIL DI CONFERMA E RESETTO IL FLAG_REG
					sAccodaMail($mailDest, "", "1");
					$_SESSION['FLAG_REG'] = 0;
				}
			}
			mysqli_close($db);			
		}
	}

	if ($codUscita==0) {
		$_SESSION['INVIO_MAIL']=1;
		header("location: ../indexlog.php");
	}
	elseif ($codUscita==3) { echo ("</br>Fallita la conferma registrazione su FLAG_REG."); }
	elseif ($codUscita==4) { echo ("</br>Mail non trovata per l'utente con ID=$ID_USER"); }
	elseif ($codUscita==5) { echo ("</br>Utente non trovato nel database"); }
	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
//echo ("</br> sql=" . $sql);
	if ($codUscita!=0) {
		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
?>
	</div>
	</body>
</html>
