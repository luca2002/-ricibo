<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php";
	// CONNESSIONE AL DB, CON INCLUDE DELLE FUNZIONI
	include "../funzioni/oDBConn.php";
	include "../funzioni/sLeggiMailID_USER.php";
	include "../funzioni/sAccodaMail.php";
	include "../funzioni/sCheckOra.php";
	$GIORNI = array(
		0 => array(
			0 => 'LUN_ORA1_APER',
			1 => 'LUN_ORA1_CHIU',
			2 => 'LUN_ORA2_APER',
			3 => 'LUN_ORA2_CHIU'
		),
		1 => array(
			0 => 'MAR_ORA1_APER',
			1 => 'MAR_ORA1_CHIU',
			2 => 'MAR_ORA2_APER',
			3 => 'MAR_ORA2_CHIU'
		),
		2 => array(
			0 => 'MER_ORA1_APER',
			1 => 'MER_ORA1_CHIU',
			2 => 'MER_ORA2_APER',
			3 => 'MER_ORA2_CHIU'
		),
		3 => array(
			0 => 'GIO_ORA1_APER',
			1 => 'GIO_ORA1_CHIU',
			2 => 'GIO_ORA2_APER',
			3 => 'GIO_ORA2_CHIU'
		),
		4 => array(
			0 => 'VEN_ORA1_APER',
			1 => 'VEN_ORA1_CHIU',
			2 => 'VEN_ORA2_APER',
			3 => 'VEN_ORA2_CHIU'
		),
		5 => array(
			0 => 'SAB_ORA1_APER',
			1 => 'SAB_ORA1_CHIU',
			2 => 'SAB_ORA2_APER',
			3 => 'SAB_ORA2_CHIU'
		),
		6 => array(
			0 => 'DOM_ORA1_APER',
			1 => 'DOM_ORA1_CHIU',
			2 => 'DOM_ORA2_APER',
			3 => 'DOM_ORA2_CHIU'
		)
	);
//	echo "</br></br><div class=\"container\">";
	$codUscita = oDBConn();

	// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
	$bInserimento = !(isset($_SESSION['FLAG_REG']));
	if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
//echo("</br>bInserimento>" . $bInserimento . "<</br>");
	if (is_numeric($codUscita)) {
		if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
		elseif ($codUscita == 2 ) { echo("</br>Errore: DB non trovato."); }
	} else {
		// SE TUTTO OK, SALVO LA CONNESSIONE AL DB
		$db = $codUscita;
		$codUscita = 0;
		$ID_AREA = $_SESSION['ID_AREA'];
		$ID_NEG_ASS = $_SESSION['ID_NEG_ASS'];
		$GIORNO_SETTIMANA = 0;
//echo("</BR>ID_AREA:$ID_AREA  - ID_NEG_ASS:$ID_NEG_ASS");
		while (($GIORNO_SETTIMANA < 7) && ($codUscita == 0)) {
			$ORA1_APER = htmlspecialchars($_POST[$GIORNI[$GIORNO_SETTIMANA][0]]);
			$ORA1_CHIU = htmlspecialchars($_POST[$GIORNI[$GIORNO_SETTIMANA][1]]);
			$ORA2_APER = htmlspecialchars($_POST[$GIORNI[$GIORNO_SETTIMANA][2]]);
			$ORA2_CHIU = htmlspecialchars($_POST[$GIORNI[$GIORNO_SETTIMANA][3]]);
			$ORA1_APER = sCheckOra($ORA1_APER);
			$ORA1_CHIU = sCheckOra($ORA1_CHIU);
			$ORA2_APER = sCheckOra($ORA2_APER);
			$ORA2_CHIU = sCheckOra($ORA2_CHIU);
			
//echo("</BR>A1:$ORA1_APER  - C1:$ORA1_CHIU  - A2:$ORA2_APER  - C2:$ORA2_CHIU  - ");
			$GIORNO_ERRORE = $GIORNO_SETTIMANA;
			// 1. TURNO - ORARIO/I MANCANTI
			if ($ORA1_APER == NULL || $ORA1_CHIU == NULL) { $codUscita =  $codUscita | 1; }
			// 1. TURNO - ORARI SBAGLIATI
			else if ($ORA1_APER > $ORA1_CHIU) { $codUscita =  $codUscita | 2; }
			// 2. TURNO - ORARIO/I MANCANTI
			if ($ORA2_APER == NULL || $ORA2_CHIU == NULL) { $codUscita =  $codUscita | 4; }
			// 2. TURNO - ORARI SBAGLIATI
			else if ($ORA2_APER > $ORA2_CHIU) { $codUscita =  $codUscita | 8; }
			// SE TUTTO OK, CONTROLLO CHE IL 1. TURNO SIA PRECEDENTE AL 2.
			if ($codUscita == 0) {
				if ($ORA2_APER < $ORA1_APER) { $codUscita =  $codUscita | 16; }
				if ($ORA2_CHIU < $ORA1_CHIU) { $codUscita =  $codUscita | 32; }
			}
			if ($codUscita |= 0) { $codUscita = -$codUscita; }
			
			if ($codUscita == 0) {
				if ($bInserimento) {
					// INSERIMENTO: DATI APERTURA
					$sql1 = "INSERT INTO TB_APERTURA(ID_AREA, ID_NEG_ASS, GIORNO_SETTIMANA, ORA1_APER, ORA1_CHIU, ORA2_APER, ORA2_CHIU)";
					$sql2 = "VALUES($ID_AREA, $ID_NEG_ASS, $GIORNO_SETTIMANA, '$ORA1_APER', '$ORA1_CHIU', '$ORA2_APER', '$ORA2_CHIU');";
					$sql = $sql1 . $sql2;
				} else {
					// AGGIORNAMENTO: DATI APERTURA
					$sql = "UPDATE TB_APERTURA SET GIORNO_SETTIMANA='$GIORNO_SETTIMANA', ORA1_APER='$ORA1_APER', ORA1_CHIU='$ORA1_CHIU', ORA2_APER='$ORA2_APER', ORA2_CHIU='$ORA2_CHIU' WHERE ((ID_NEG_ASS=$ID_NEG_ASS) AND (GIORNO_SETTIMANA=$GIORNO_SETTIMANA))";
				}
				$ris = mysql_query($sql, $db);
				if (!$ris) { $codUscita = 3; } // inserimento nel DB non corretto
				$GIORNO_SETTIMANA++;
//echo("</BR>sql>$sql<");
//echo("</BR>ris>$ris<");
			}
		}
		// ESEGUO LE SEGUENTI OPERAZIONI SOLO SOLO SE E' UN INSERIMENTO
		if ($bInserimento) {
			// AGGIORNO LA TB_USER PER LO STATO REGISTRAZIONE
			if (($codUscita == 0) AND ($_SESSION['FLAG_REG'] != 0)) {
				$FLAG_REG = $_SESSION['FLAG_REG'];
				if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R')) {
					$FLAG_REG = $FLAG_REG + 1;
				} else {
					$FLAG_REG = 0;
				}
				$_SESSION['FLAG_REG'] = $FLAG_REG;
				$ID_USER = $_SESSION['ID_USER'];
				$sql = "UPDATE TB_USER SET FLAG_REG = $FLAG_REG WHERE ID_USER = $ID_USER;";
				$risultato_query = mysql_query($sql, $db);
				if ($risultato_query == false) {
					$codUscita=6; // Errore sul salvataggio dati di collegamento
				} else {
					// SE IL NEGOZIO/ASSOCIAZIONE HA COMPLETATO LA REGISTRAZIONE, INVIO LA MAIL
					$mailDest = sLeggiMailID_USER($ID_USER);
					if ($mailDest == "")
						{ $codUscita=7; } // Mail non trovata per l'utente con ID=$ID_USER"
					else
						{ sAccodaMail($mailDest, "", "0"); }
				}
			}
		}
	}
//echo("</br> codUscita=" . $codUscita);
//echo("</BR>sql>$sql<");
	if ($codUscita == 0) {
	// NEL CASO DI UN REDIRECT CHIUDO LA CONNESSIONE AL DB
		mysql_close($db);
		// CASO DI MODIFICA DATI
		if ($bInserimento) {
			 // CASO DI PRIMA REGISTRAZIONE
			$_SESSION['INVIO_MAIL']=1;
			header("location: ../invio-mail.php");
		} else {
			header("location: ../indexlog.php");
		}
	}
	elseif ($codUscita <= -1) {
		$codUscita = -$codUscita;
		switch ($GIORNO_ERRORE) {
			case 0: { $GIORNO_ERRORE = "Lunedi'";  break; }
			case 1: { $GIORNO_ERRORE = "Martedi'";  break; }
			case 2: { $GIORNO_ERRORE = "Mercoledi'";  break; }
			case 3: { $GIORNO_ERRORE = "Giovedi'";  break; }
			case 4: { $GIORNO_ERRORE = "Venerdi'";  break; }
			case 5: { $GIORNO_ERRORE = "Sabato";  break; }
			case 6: { $GIORNO_ERRORE = "Domenica";  break; }
		}
		echo ("</BR></BR></BR><center>E' stato riscontrato un errore nel giorno di $GIORNO_ERRORE.</BR>");
		if (($codUscita & 1) == 1) { echo ("Il turno 1 non ha inserito l'orario/i."); }
		if (($codUscita & 2) == 2) { echo ("Il turno 1 ha orario apertura successivo alla chiusura."); }
		if (($codUscita & 4) == 4) { echo ("Il turno 2 non ha inserito l'orario/i."); }
		if (($codUscita & 8) == 8) { echo ("Il turno 2 ha orario apertura successivo alla chiusura."); }
		if (($codUscita & 16) == 16) { echo ("Il turno 1 ha apertura successiva al turno 2."); }
		if (($codUscita & 32) == 32) { echo ("Il turno 1 ha chiusura successiva al turno 2."); }
		if ($bInserimento) { 
			echo ("Orari non salvati.</BR></BR>");
			$sql = "DELETE FROM TB_APERTURA WHERE ID_NEG_ASS = $ID_NEG_ASS;";
			$ris = mysql_query($sql, $db);
			mysql_close($db);
			if (!$ris) {
				echo ("</BR>Errore nella cancellazione dei campi corretti dal DB.</BR>sql>$sql");
			}
		} else {
			echo ("</BR><A HREF=\"apertura.php\">Cliccare qui per tornare agli orari appena inseriti.</a>");
		}
		echo ("</BR>Vi ricordiamo che il formato dell'orario &egrave; HH:MM. - Esempio: 12:30</center>");
	}
	elseif ($codUscita == 3) { echo ("</br>Errore: inserimento nel DB non corretto."); 	}
	elseif ($codUscita == 6) { echo ("</br>Errore sull'avanzamento della registrazione."); }
	elseif ($codUscita == 7) { echo ("</br>Mail non trovata per l'utente con ID=$ID_USER"); }
//	elseif ($codUscita == 8) { echo ("</br>Errore nella ricerca dell'utente nel DB."); }
// echo ("</br> codUscita=" . $codUscita);
	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
	if ($codUscita != 0) {
		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
		// ATTIVO IL BOTTONE "INDIETRO" SOLO SE IN INSERIMENTO, L'ERRORE PER LA MODIFICA E' GESTITO PRIMA
		if ($bInserimento) {
			echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
		}
	}
?>
	</div>
</body>
</html>
