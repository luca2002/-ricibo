<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php" ?>
	</head>
	<body>	
<?php include "../menu.php";
	echo "</br></br><div class=\"container\">";
//echo ("</br> SESSION['FLAG_REG']=" . $_SESSION['FLAG_REG']);
//echo ("</br> SESSION['FLAG_PERSONA']=" . $_SESSION['FLAG_PERSONA']);
	// SE E' UN VOLONTARIO, IMPOSTO IL CAMPO A 'P'
	if ($_SESSION['FLAG_PERSONA'] == 'V') { $FLAG_PRI_SEC = 'P'; }
		// SE E' UNA PRIMA REGISTRAZIONE NEL SALVATAGGIO IMPOSTO FLAG_PRI_SEC=P
		else if (($_SESSION['FLAG_REG'] != 0) OR ($_SESSION['FLAG_PERSONA'] != ('R' && 'N' && 'A'))) {
			$FLAG_PRI_SEC = 'P';
		} else {
			$FLAG_PRI_SEC = htmlspecialchars($_POST['FLAG_PRI_SEC']);
		}
	$_SESSION['FLAG_PRI_SEC'] = $FLAG_PRI_SEC;
//echo ("</br> FLAG_PRI_SEC=" . $FLAG_PRI_SEC);

	$NOME = htmlspecialchars($_POST['NOME']);
	$COGNOME = htmlspecialchars($_POST['COGNOME']);
	$DATA_NASCITA = date('Y-m-d', strtotime($_POST['DATA_NASCITA']));
	//$DATA_NASCITA = htmlspecialchars($_POST['DATA_NASCITA']);
//echo ("DATA_NASCITA>$DATA_NASCITA<</br>");	
	$PROV_DOM = htmlspecialchars($_POST['PROV_DOM']);
//echo ("PROV_DOM>$PROV_DOM<</br>");	
	$COMUNE_DOM = htmlspecialchars($_POST['COMUNE_DOM']);
//echo ("COMUNE_DOM>$COMUNE_DOM<</br>");	
	$CAP_DOM = htmlspecialchars($_POST['CAP_DOM']);
//echo ("CAP_DOM>$CAP_DOM<</br>");	
	$CELL = htmlspecialchars($_POST['CELL']);
//echo ("</br> Sono qua1");
	
	if((!isset($_SESSION['ID_AREA'])) AND (!isset($_SESSION['ID_USER'])) AND (!isset($_SESSION['ID_PERMESSO'])) AND (!isset($_SESSION['FLAG_REG']))) {
		echo ("</br>Sessione scaduta, ritornare alla pagina di inserimento dati.");
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
	$codUscita=0;
	$sql="";
// echo ("</br> Sono qua2");	
	if ((strlen($NOME) < 2) OR (strlen($NOME) > 30) OR(strlen($COGNOME) < 2) OR (strlen($COGNOME) > 30)) { $codUscita = $codUscita | 1; }
	if (strlen($PROV_DOM) != 2) { $codUscita = $codUscita | 16; }
	if ((strlen($COMUNE_DOM) < 3) OR (strlen($COMUNE_DOM) > 30)) { $codUscita = $codUscita | 32; }
	if (strlen($CAP_DOM) != 5) { $codUscita = $codUscita | 64; }
	if ((strlen($CELL) != 9) AND (strlen($CELL) != 10)) { $codUscita = $codUscita | 128; }
//echo ("</br> codUscita=" . $codUscita);
//echo ("</br> Sono qua3");

	if ($codUscita >0)
		{ $codUscita = -$codUscita; }
	else
	{
//echo ("</br> codUscita=" . $codUscita);
		include "../funzioni/oDBConn.php";
		include "../funzioni/sLeggiMailID_USER.php";
		include "../funzioni/sAccodaMail.php";

function sInizialiMaiuscole($stri) {
// echo "</BR> IniMaiusc 1) stri: $stri</BR>";
	$stri = strtolower(trim($stri));
	$l = strlen($stri);
	if ($l > 0) {
		if ($l == 1) { $stri = strtoupper($stri); }
		else { $stri = strtoupper(substr($stri, 0, 1)) . substr($stri, 1); }
		$i = stripos($stri, " ");
		while (!($i === false)) {
			// CARATTERE CENTRALE
			if ($i < $l) {
				$stri = substr($stri, 0, $i+1) . strtoupper(substr($stri, $i+1, 1)) . substr($stri, ($i+2));
			}
//echo "IniMaiusc 2B) i: $i - l: $l</BR>";
			$i = stripos($stri, " ", $i+1);
		}
	}
//echo "IniMaiusc 3) stri: $stri</BR>";
	return $stri;
}

		$codUscita = oDBConn();
		if (is_numeric($codUscita)) { 
			if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
			elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
		} else {
			$db=$codUscita;
			$codUscita=0;
			$ID_AREA = $_SESSION['ID_AREA'];
			// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
			$bInserimento = !(isset($_SESSION['FLAG_REG']));
			if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
//echo("</br>bInserimento>" . $bInserimento . "<</br>");

			// CONTROLLO STRINGHE
			$PROV_DOM = strtoupper($PROV_DOM);
			$COMUNE_DOM = sInizialiMaiuscole($COMUNE_DOM);
//echo("</br>COMUNE_DOM>" . $COMUNE_DOM . "<</br>");
			if ($bInserimento) {
				// INSERIMENTO: SALVATAGGIO DATI PERSONA FISICA
				$sql1 = "INSERT INTO TB_PERSONA(ID_AREA, FLAG_PRI_SEC, NOME, COGNOME, DATA_NASCITA, PROV_DOM, COMUNE_DOM, CAP_DOM)";
				$sql2 = " VALUES ('$ID_AREA', '$FLAG_PRI_SEC', '$NOME', '$COGNOME', '$DATA_NASCITA', '$PROV_DOM', '$COMUNE_DOM', '$CAP_DOM')";
				$sql = $sql1 . $sql2;
				$result = mysqli_query($db,$sql);
				// CARICO IN SESSIONE I DATI UTENTE
				$ID_PERSONA = mysqli_insert_id($db);
				$_SESSION['ID_PERSONA'] = $ID_PERSONA;
			} else {
				// AGGIORNAMENTO: SALVATAGGIO DATI PERSONA FISICA
				$ID_PERSONA = $_SESSION['ID_PERSONA'];
				$sql = "UPDATE TB_PERSONA SET FLAG_PRI_SEC='$FLAG_PRI_SEC', NOME='$NOME', COGNOME='$COGNOME', DATA_NASCITA='$DATA_NASCITA', PROV_DOM='$PROV_DOM', COMUNE_DOM='$COMUNE_DOM', CAP_DOM='$CAP_DOM' WHERE (ID_PERSONA=$ID_PERSONA)";
				$result = mysqli_query($db,$sql);
			}
//echo ("</br> SESSION['ID_PERSONA']=" . $_SESSION['ID_PERSONA']);
//echo "</br> sql=" . $sql;
//echo "</br> result=" . $result;
			// SALVATAGGIO DEL NUMERO CELL IN TB_CELLULARI
			if ($bInserimento) {
				// INSERIMENTO: SALVATAGGIO CELL
				$sql = "INSERT INTO TB_CELLULARI(ID_AREA, ID_PERSONA, CELL) VALUES (\"$ID_AREA\", \"$ID_PERSONA\", \"$CELL\")";
				$result = mysqli_query($db,$sql);
			} else {
				// AGGIORNAMENTO: SALVATAGGIO CELL
				$sql = "UPDATE TB_CELLULARI SET CELL='$CELL' WHERE (ID_PERSONA=$ID_PERSONA)";
				$result = mysqli_query($db,$sql);
			}
//echo "</br> sql=" . $sql;
//echo "</br> result=" . $result;
//echo ("</br> ID_PERSONA=" . $ID_PERSONA);

			// SE LA REGISTRAZIONE E' OK, SOLO X INSERIMENTO: AGGIORNO LO STATO DI REGISTRAZIONE IN SESSIONE E TABELLA
			if (($bInserimento) AND ($codUscita==0) AND ($_SESSION['FLAG_REG']!=0)){
				if ($_SESSION['FLAG_PERSONA']=='V')
					{ $FLAG_REG = 9; }
				if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R'))
					{ $FLAG_REG = 3; }
				$_SESSION['FLAG_REG'] = $FLAG_REG;
				$ID_PERSONA = $_SESSION['ID_PERSONA'];
//echo ("</br> 1) ID_USER=" . $ID_USER);
				$ID_USER = $_SESSION['ID_USER'];
//echo ("</br> 2) ID_USER=" . $ID_USER);
				$sql = "UPDATE TB_USER SET ID_PERSONA=$ID_PERSONA, FLAG_REG=$FLAG_REG WHERE (ID_USER=$ID_USER);";
				$result = mysqli_query($db,$sql);
				if ($result == false)
					{ $codUscita=6; } // Errore sull'avanzamento della registrazione
				// SE E' UN VOLONTARIO E HA COMPLETATO LA REGISTRAZIONE, INVIO LA MAIL
				else if ($_SESSION['FLAG_PERSONA']=='V') {
					$mailDest = sLeggiMailID_USER($ID_USER,$db);
					if ($mailDest == "")
						{ $codUscita=7; } // Mail non trovata per l'utente con ID=$ID_USER"
					else
						{ sAccodaMail($mailDest, "", "0",$db); }
				}
//echo ("</br> ID_USER=" . $ID_USER);
//echo ("</br> sql=" . $sql);
//echo "</br> result=" . $result;
//echo ("</br>SONO QUA!");
			}
			mysqli_close($db);
		}
	}

//echo ("</br> SESSION['FLAG_REG']=" . $_SESSION['FLAG_REG']);
	if ($codUscita==0) {
		// CASO DI MODIFICA DATI
		if ($_SESSION['FLAG_PERSONA']=='V') { 
			if ($bInserimento) {
				// CASO DI PRIMA REGISTRAZIONE
				$_SESSION['INVIO_MAIL']=1;
				header("location: ../invio-mail.php");
			} else {
				header("location: ../indexlog.php");
			}
		} else {
			header("location: neg_ass.php");
		}
	} elseif ($codUscita < 0) {
		$codUscita = -$codUscita;
		if (($codUscita & 1) == 1) { echo ("</br>Errore: il nome e il cognome devono avere una lunghezza fra 2 e 30 caratteri."); }
		if (($codUscita & 16) == 16) { echo ("</br>Errore: inserire una provincia valida."); }
		if (($codUscita & 32) == 32) { echo ("</br>Errore: il nome del comune di domicilio deve avere una lunghezza fra 3 e 30 caratteri. Deve essere scritto per esteso."); }
		if (($codUscita & 64) == 64) { echo ("</br>Errore: inserire un CAP valido"); }		
		if (($codUscita & 128) == 128) { echo ("</br>Errore: inserire un numero di cellulare valido"); }		
	}
	elseif ($codUscita==3) { echo ("</br>Errore: nome utente gi&agrave; registrato."); }
	elseif ($codUscita==4) { echo ("</br>Errore sul salvataggio user/pwd."); }
	elseif ($codUscita==5) { echo ("</br>Errore sul salvataggio mail."); }
	elseif ($codUscita==6) { echo ("</br>Errore sull'avanzamento della registrazione."); }
	elseif ($codUscita==7) { echo ("</br>Mail non trovata per l'utente con ID=$ID_USER"); }

	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
//echo ("</br> sql=" . $sql);
	if ($codUscita!=0) {
		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
/*
delete from TB_MAIL where MAIL='torresin@tiscali.it';
delete from TB_CELLULARI where CELL='3282740344';
delete from TB_USER WHERE USER='Lore74';
delete from TB_PERSONA where NOME='Lorenzo' AND COGNOME='Torresin';
*/
?>
	</div>
	</body>
</html>