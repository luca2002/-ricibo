<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php";
	echo "</br></br><div class=\"container\">";
	/* FLAG_AREA_NEG_ASS CHAR LO LEGGO DALLA SESSIONE */
	$FLAG_AREA_NEG_ASS = $_SESSION['FLAG_PERSONA'];
// echo ("</br> FLAG_AREA_NEG_ASS=" . $FLAG_AREA_NEG_ASS);
	if ($FLAG_AREA_NEG_ASS == 'R') {
		$ID_PERMESSO = 3; // RESPONSABILE D'AREA
	} else {
		$ID_PERMESSO = 4; // UTENTE ORDINARIO
	}
	$FLAG_NEG_PRI_SEC = htmlspecialchars($_POST['FLAG_NEG_PRI_SEC']);
// echo ("</br> FLAG_NEG_PRI_SEC=" . $FLAG_NEG_PRI_SEC);
	$NOME = htmlspecialchars($_POST['NOME']);
	$P_IVA = htmlspecialchars($_POST['P_IVA']);
	$INDIRIZZO_SEDE = htmlspecialchars($_POST['INDIRIZZO_SEDE']);
	$CAP_SEDE = htmlspecialchars($_POST['CAP_SEDE']);
	$COMUNE_SEDE = htmlspecialchars($_POST['COMUNE_SEDE']);
	$PROV_SEDE = htmlspecialchars($_POST['PROV_SEDE']);
	$STATO_SEDE = htmlspecialchars($_POST['STATO_SEDE']);
	$TELEFONO_STRUTTURA = htmlspecialchars($_POST['TELEFONO_STRUTTURA']);
	$GPS_X = htmlspecialchars($_POST['GPS_X']);
	$GPS_Y = htmlspecialchars($_POST['GPS_Y']);
	if ($GPS_X == "") { $GPS_X = 12.1212; }
	if ($GPS_Y == "") { $GPS_Y = 34.3434; }
	$MAIL = htmlspecialchars($_POST['MAIL']);
	$codUscita = 0;

echo "</br> $GPS_X=" . $GPS_X;
echo "</br> $GPS_Y=" . $GPS_Y;


	// CONTROLLO ERRORI: si deve selezionare se e' la sede principale o secondaria
	if ($FLAG_NEG_PRI_SEC != 'P' && $FLAG_NEG_PRI_SEC != 'S') { $codUscita =  $codUscita | 1; }
	// CONTROLLO ERRORI: il nome deve essere compreso tra i 2 e i 30 caratteri
	if (strlen($NOME) < 2 || strlen($NOME) > 30) { $codUscita = $codUscita | 2; }
	// CONTROLLO ERRORI: la partita iva deve essere di 11 caratteri
	if (strlen($P_IVA) != 11) {	$codUscita = 8; }
	// CONTROLLO ERRORI: INDIRIZZO_SEDE deve essere compreso tra i 2 e i 50 caratteri
	if (strlen($INDIRIZZO_SEDE) < 2 || strlen($INDIRIZZO_SEDE) > 50) { $codUscita = $codUscita | 16;}
	// CONTROLLO ERRORI: CAP_SEDE deve essere compreso tra i 2 e i 30 caratteri
	if (strlen($CAP_SEDE) != 5) { $codUscita = $codUscita | 32;}
	// CONTROLLO ERRORI: il nome del comune deve essere compreso tra i 2 e i 30 caratteri
	if (strlen($COMUNE_SEDE) < 2 || strlen($COMUNE_SEDE) > 30) { $codUscita = $codUscita | 64; }
	// CONTROLLO ERRORI: inserire una provincia valida
	if (strlen($PROV_SEDE) != 2) { $codUscita = $codUscita | 128; }
	// CONTROLLO ERRORI: il nome dello stato deve essere compreso tra i 2 e i 30 caratteri
	if (strlen($STATO_SEDE) < 2 || strlen($STATO_SEDE) > 30) { $codUscita = $codUscita | 256;}
	// CONTROLLO ERRORI: inserire un numero di telefono valido
	if (strlen($TELEFONO_STRUTTURA) < 10 || strlen($TELEFONO_STRUTTURA) > 14 ) { $codUscita = $codUscita | 512; }
	// CONTROLLO ERRORI: la mail deve avere una lunghezza fra 8 e 50 caratteri
// echo "</br> MAIL=" . $MAIL;
	if (strlen($MAIL) < 8 || strlen($MAIL) > 50) {
		$codUscita = $codUscita | 1024;    // Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri
	} else { // CONTROLLO CORRETTEZZA SINTASSI MAIL
		$i=stripos($MAIL, '@');
		$i2=strrpos($MAIL, '.', $i);
		$l=strlen($MAIL);
// echo "</br> i=" . $i;
// echo "</br> i2=" . $i2;
// echo "</br> l=" . $l;
		$codUscita2 = 2048; // Errore: la mail ha una sintassi errata
		if ($i>2) { if ($i2>(i+2)) { if ($l>$i2+2) { $codUscita2=0; } } }
		$codUscita = $codUscita | $codUscita2;
	}
// echo ("</br> codUscita=" . $codUscita);
// echo ("</br> Sono qua3");

	if ($codUscita >0) { $codUscita = -$codUscita; }
// echo ("</br> codUscita=" . $codUscita);
// echo ("</br> Sono qua4");


	// CONNESSIONE AL DB, CON INCLUDE DELLE FUNZIONI
	$codUscita = 0;
	include "../funzioni/oDBConn.php";
	$codUscita = oDBConn();
// echo ("</br> codUscita=" . $codUscita);

	if (is_numeric($codUscita)) { 
		if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
		elseif ($codUscita == 2 ) { echo("</br>Errore: DB non trovato."); }
	} else {
		// SE TUTTO OK, SALVO LA CONNESSIONE AL DB
		$db = $codUscita;
		$codUscita = 0;
		// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
		$bInserimento = !(isset($_SESSION['FLAG_REG']));
		if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
// echo("</br>bInserimento>" . $bInserimento . "<</br>");
		if ($bInserimento) {
			// INSERIMENTO: SALVATAGGIO DATI ASSOCIAZIONE/NEGOZIO
			$ID_AREA = $_SESSION['ID_AREA'];
			$sql1 = "INSERT INTO TB_NEG_ASS(ID_AREA, FLAG_AREA_NEG_ASS, FLAG_NEG_PRI_SEC, NOME, P_IVA, INDIRIZZO_SEDE, CAP_SEDE, COMUNE_SEDE, PROV_SEDE, STATO_SEDE, TELEFONO_STRUTTURA, GPS_X, GPS_Y, MAIL)";
			$sql2 = "VALUES($ID_AREA, '$FLAG_AREA_NEG_ASS', '$FLAG_NEG_PRI_SEC', \"$NOME\", \"$P_IVA\", \"$INDIRIZZO_SEDE\", \"$CAP_SEDE\", \"$COMUNE_SEDE\", \"$PROV_SEDE\", \"$STATO_SEDE\", \"$TELEFONO_STRUTTURA\", $GPS_X, $GPS_Y, \"$MAIL\");";
			$sql = $sql1 . $sql2;
			$risultato_query = mysql_query($sql, $db);
			if ($risultato_query == false) { 
				$codUscita=3; // Errore sul salvataggio dati principali
			} else {
				// LETTURA ID_NEG_ASS E SALVATAGGIO IN SESSIONE
				$ID_NEG_ASS = mysql_insert_id();
				$_SESSION['ID_NEG_ASS'] = $ID_NEG_ASS;
				$_SESSION['FLAG_NEG_PRI_SEC'] = $FLAG_NEG_PRI_SEC;
			}
		} else {
			// AGGIORNAMENTO: SALVATAGGIO DATI ASSOCIAZIONE/NEGOZIO
			$ID_NEG_ASS = $_SESSION['ID_NEG_ASS'];
			$sql = "UPDATE TB_NEG_ASS SET FLAG_AREA_NEG_ASS='$FLAG_AREA_NEG_ASS', FLAG_NEG_PRI_SEC='$FLAG_NEG_PRI_SEC', NOME='$NOME', P_IVA='$P_IVA', INDIRIZZO_SEDE='$INDIRIZZO_SEDE', CAP_SEDE='$CAP_SEDE', COMUNE_SEDE='$COMUNE_SEDE', PROV_SEDE='$PROV_SEDE', STATO_SEDE='$STATO_SEDE', TELEFONO_STRUTTURA='$TELEFONO_STRUTTURA', GPS_X='$GPS_X', GPS_Y='$GPS_Y', MAIL='$MAIL' WHERE (ID_NEG_ASS=$ID_NEG_ASS)";
			$result = mysql_query($sql, $db);
		}
echo ("</br> sql=> " . $sql . " <");
		
		// ESEGUO LE SEGUENTI OPERAZIONI SOLO SOLO SE E' UN INSERIMENTO
		if ($bInserimento) {		
			// CREO IL RECORD DI UNIONE PERSONA-NEG/ASS
			if ($codUscita == 0) {		
				$ID_PERSONA = $_SESSION['ID_PERSONA'];
				$sql1 = "INSERT INTO TB_PERS_NEG_ASS(ID_AREA, ID_NEG_ASS, ID_PERSONA)";
				$sql2 = " VALUES ($ID_AREA, $ID_NEG_ASS, $ID_PERSONA);";
				$sql = $sql1 . $sql2;
				$risultato_query = mysql_query($sql, $db);
				if ($risultato_query == false) { $codUscita=4; } // Errore sul salvataggio dati di collegamento
			}
			// AGGIORNO LA TB_USER PER LO STATO REGISTRAZIONE
			if (($codUscita == 0) AND ($_SESSION['FLAG_REG'] !=0 )){
				$FLAG_REG = $_SESSION['FLAG_REG'];
				if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R'))
						{ $FLAG_REG = $FLAG_REG + 1; }
					else
						{ $FLAG_REG = 0; }
				$_SESSION['FLAG_REG'] =  $FLAG_REG;
				$ID_USER = $_SESSION['ID_USER'];
				$sql = "UPDATE TB_USER SET FLAG_REG = $FLAG_REG WHERE ID_USER = $ID_USER;";
				$risultato_query = mysql_query($sql, $db);
				if ($risultato_query == false) { $codUscita=6; } // Errore sul salvataggio dati di collegamento
			}
		}
		mysql_close($db);
	}
// echo ("</br> sql=> " . $sql . " <");
// echo ("</br> codUscita=" . $codUscita);

	// GESTISCO IL REINDIRIZZAMENTO PAGINA
	if ($codUscita==0) {
		// CASO DI MODIFICA DATI
		if ($bInserimento) {
		// CASO DI PRIMA REGISTRAZIONE
			if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R')) {
				header("location: apertura.php");
			} else {
				header("location: ../index.php");
			}
		} else {
			header("location: ../indexlog.php");
		}
	} elseif ($codUscita < 0) {
		$codUscita = -$codUscita;
		if (($codUscita & 1) == 1) { echo("</br>Errore: si deve selezionare se e' la sede principale o secondaria."); }
		if (($codUscita & 2) == 2) { echo("</br>Errore: il nome deve essere compreso tra i 2 e i 30 caratteri."); }
		if (($codUscita & 8) == 8) { echo("</br>Errore: la partita iva deve essere di 11 caratteri."); }
		if (($codUscita & 16) == 16) { echo("</br>Errore: l'indirizzo della sede deve essere compreso tra i 2 e i 50 caratteri."); }
		if (($codUscita & 32) == 32) { echo("</br>Errore: CAP di lunghezza non valida."); }
		if (($codUscita & 64) == 64) { echo("</br>Errore: il nome del comune deve essere compreso tra i 2 e i 30 caratteri."); }
		if (($codUscita & 128) == 128) { echo("</br>Errore: la provincia deve essere la sigla di soli 2 caratteri."); }
		if (($codUscita & 256) == 256) { echo("</br>Errore: il nome dello stato deve essere compreso tra i 2 e i 30 caratteri."); }
		if (($codUscita & 512) == 512) { echo("</br>Errore: inserire un numero di telefono valido."); }
		if (($codUscita & 1024) == 1024) { echo("</br>Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri."); }
		if (($codUscita & 2048) == 2048) { echo("</br>Errore: la mail ha una sintassi errata."); }
		}
	elseif ($codUscita==1) { echo("</br>Errore: connessione al DB fallita."); }
	elseif ($codUscita==2) { echo("</br>Errore: DB non trovato."); }
	elseif ($codUscita==3) { echo("</br>Errore sul salvataggio dei dati principali."); }
	elseif ($codUscita==4) { echo("</br>Errore sul salvataggio dei dati di collegamento."); }
	elseif ($codUscita==6) { echo("</br>Errore sull'avanzamento della registrazione."); }
	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
	if ($codUscita!=0) {
		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
/*
delete from TB_MAIL where MAIL='torresin7@gmail.com';
delete from TB_USER WHERE USER='Lore74';
delete from TB_PERSONA where NOME='Lorenzo';
delete from TB_NEG_ASS where ID_NEG_ASS>2;
*/
?>
	</div>
</body>
</html>
