<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php";
	echo "</br></br><div class=\"container\">";

	if (isset($_POST['ID_AREA'])) { $ID_AREA = htmlspecialchars($_POST['ID_AREA']); } else { $ID_AREA = ""; }
// if (isset($ID_AREA)) { echo("OK"); } else { echo("NO"); }
// echo "</br> ID_AREA >" . $ID_AREA ."<</br>";
	$USER = htmlspecialchars($_POST['USER']);
	$PWD = htmlspecialchars($_POST['PWD']);
	$PWD2 = htmlspecialchars($_POST['PWD2']);
	$MAIL = htmlspecialchars($_POST['MAIL']);
	$MAIL2 = htmlspecialchars($_POST['MAIL2']);
	$ID_PERMESSO = 4;
	$codUscita=0;
	$sql="";
	
	// CONTROLLO LA SELEZIONE DELL'AREA DI ATTIVITA'
	if ($ID_AREA == "") { $codUscita = -6; }
	// CONTROLLO LUNGHEZZA PWD >6 CHAR
	if ($PWD != $PWD2) { $codUscita=-1; }
	else {  // Errore: le password inserite non risultano uguali
		if ((strlen($PWD) < 6) OR (strlen($PWD) > 12)) { $codUscita=-2; } // Errore: la password deve avere una lunghezza fra 6 e 12 caratteri
	}
// echo "</br> MAIL=" . $MAIL;
// echo ("</br> codUscita=" . $codUscita);	
	if ($codUscita==0) {
		// CONTROLLO LUNGHEZZA MAIL <= 50 CHAR
		if ($MAIL != $MAIL2) { $codUscita=-3; } // Errore: le mail inserite non risultano uguali
		else {
			if (strlen($MAIL) < 8 OR strlen($MAIL) > 50) {
				$codUscita=-5;  // Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri
			} else { // CONTROLLO CORRETTEZZA SINTASSI MAIL
				$i=stripos($MAIL, '@');
				$i2=strrpos($MAIL, '.', $i);
				$l=strlen($MAIL);
// echo "</br> i=" . $i;
// echo "</br> i2=" . $i2;
// echo "</br> l=" . $l;
				$codUscita=-4; // Errore: la mail ha una sintassi errata
				if ($i>2) { if ($i2>($i+2)) { if ($l>$i2+2) { $codUscita=0; } } }
			}  
		}
	}

	// CONNESSIONE AL DB, CON INCLUDE DELLE FUNZIONI
	if ($codUscita == 0) {
		include "../funzioni/oDBConn.php";
		$codUscita = oDBConn();
	// echo ("</br> codUscita=" . $codUscita);
		if (is_numeric($codUscita)) { 
			if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
			elseif ($codUscita == 2 ) {
				echo("</br>Errore: DB non trovato.");
				mysql_close($codUscita );
			}
		} else {
			// SE TUTTO OK, SALVO LA CONNESSIONE AL DB
			$db = $codUscita;
			$codUscita = 0;
			// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
			$bInserimento = !(isset($_SESSION['FLAG_REG']));
			if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
// echo("</br>bInserimento>" . $bInserimento . "<</br>");

			// SOLO SE C'E' UN INSERIMENTO CONTROLLO SE NON ESISTA UN UTENTE
			if ($bInserimento) {
				// CONTROLLO SE C'E' UN USER CON QUESTO NOME
				$sql = "SELECT * FROM TB_USER WHERE (USER='$USER')";
				$result = mysql_query($sql);
				$i=0;
				if ($result != false) {
					while ($riga = mysql_fetch_array($result)) { ++$i; }
				} else { $codUscita=8; } // ERRORE NELLA RICERCA DELL'UTENTE SUL 
			} else { $i=0; }
	// echo ("</br> i=" . $i);
			
			if ($i>0) { // AVVISO PRESENZA DI UN USER GIA' INSERITO
				$codUscita=3; // Errore: nome utente gia' registrato
				// $sql = ""; // SVUOTO LA SQL
			} else { // INSERIMENTO USER E SUOI DATI

				$stmp = $_SESSION['FLAG_PERSONA'];
				// GESTIONE INSERIMENTO X NUOVO O AGGIORNAMENTO X REGISTRATO
				if ($bInserimento) {
					$sql1 = "INSERT INTO TB_USER(ID_AREA, ID_PERMESSO, FLAG_PERSONA, USER, PWD, FLAG_REG)";
					$sql2 = " VALUES ($ID_AREA, $ID_PERMESSO, '$stmp', '$USER', '$PWD', 1);";
					$sql = $sql1 . $sql2;
					$result = mysql_query($sql, $db);
					$_SESSION['ID_USER']=mysql_insert_id();
				} else {
					$ID_USER = $_SESSION['ID_USER'];
					$sql = "UPDATE TB_USER SET ID_AREA=$ID_AREA, USER='$USER', PWD='$PWD' WHERE (ID_USER=$ID_USER)";
					$result = mysql_query($sql, $db);
				}
// echo("</br>sql>$sql<</br>");
// echo "</br> result=" . $result;
// echo("</br>ID_USER>" . $_SESSION['ID_USER'] . "<</br>");

				if ($result == false) {
					$codUscita=7; // Errore: inserimento utente fallito
				} else {
					// GESTIONE INSERIMENTO X NUOVO O AGGIORNAMENTO X REGISTRATO
					if ($bInserimento) {
/* VALUTARE SE NON ACCETTARE MAIL DOPPIE					
						// CONTROLLO SE C'E' UN USER CON QUESTO NOME
						$sql = "SELECT * FROM TB_MAIL WHERE (MAIL='$MAIL')";
						$result = mysql_query($sql);
						$i=0;
						if ($result != false) {
							while ($riga = mysql_fetch_array($result)) { ++$i; }
						} else { $codUscita=9; } // ERRORE NELLA RICERCA DELLA MAIL SUL DB
						if ($i>0) { // AVVISO PRESENZA DI UN USER GIA' INSERITO
							$codUscita=10; // Errore: mail gia' registrata
						} else { // INSERIRE I 2 MESSAGGI DI ERRORE ALLA FINE
						}
*/				
						// FARE: INSERIRE NELLA TB_MAIL LA MAIL ANCHE PER LA CONFERMA ID REGISTRAZIONE
						$sql1 = "INSERT INTO TB_MAIL(ID_AREA, ID_USER, MAIL)";
						$ID_USER= $_SESSION['ID_USER'];
						$sql2 = " VALUES ($ID_AREA, $ID_USER, '$MAIL');";
						$sql = $sql1 . $sql2;
						$result = mysql_query($sql);
					} else {
						// AGGIORNO LE INFO DI SESSIONE PRIMA MODIFICATE
						$_SESSION['USER'] = $USER;
						// AGGIORNO LA MAIL
						$sql = "UPDATE TB_MAIL SET MAIL='$MAIL' WHERE (ID_USER=$ID_USER)";
						$result = mysql_query($sql, $db);
					}			
// echo("</br>sql>$sql<</br>");
// echo "</br> result=" . $result;
					if ($result == false) { $codUscita=5; } // Errore sul salvataggio mail
				}
				// SE LA REGISTRAZIONE MAIL E' OK, AGGIORNO LO STATO DI REGISTRAZIONE
				if (($codUscita==0) AND ($bInserimento)) {
					$sql = "UPDATE TB_USER SET FLAG_REG=2 WHERE (ID_USER=$ID_USER);";
					$result = mysql_query($sql);
					if ($result == false) { $codUscita=6; } // Errore sull'avanzamento della registrazione
				}
			}
			mysql_close($db);
		}
	}
// echo ("</br> codUscita=" . $codUscita);
// echo ("</br> FLAG_PERSONA=" . $_SESSION['FLAG_PERSONA']);

	if ($codUscita==0) {
	// GESTIONE INSERIMENTO X NUOVO O AGGIORNAMENTO X REGISTRATO
//echo("</br>bInserimento>" . $bInserimento . "<</br>");
		if ($bInserimento) {
		// GESTIONE INSERIMENTO X NUOVO
		// SE TUTTO OK, VALORIZZO LE VARIABILI DI SESSIONE
			$_SESSION['ID_AREA'] = $ID_AREA;
			// 		   ID_USER			SALVATO PRIMA
			$_SESSION['ID_PERMESSO'] = 4; // 4 = UTENTE NORMALE
			//		  FLAG_PERSONA		SALVATO E INTERCETTATO DALLA PAGINA DI REGISTRAZIONE
			$_SESSION['USER'] = $USER;
			$_SESSION['FLAG_REG'] = 2;
			header("location: persona.php");
		} else {
			// GESTIONE AGGIORNAMENTO X REGISTRATO
			header("location: ../indexlog.php");
		}
	}
	elseif ($codUscita==-6) { echo("</br>Errore: non &egrave; stata selezionata l'area di attivit&agrave;."); }
	elseif ($codUscita==-1) { echo("</br>Errore: le password inserite non risultano uguali."); }
	elseif ($codUscita==-2) { echo("</br>Errore: la password deve avere una lunghezza fra 6 e 12 caratteri."); }
	elseif ($codUscita==-3) { echo("</br>Errore: le mail inserite non risultano uguali."); }
	elseif ($codUscita==-4) { echo("</br>Errore: la mail ha una sintassi errata."); }
	elseif ($codUscita==-5) { echo("</br>Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri."); }
	elseif ($codUscita==1) { echo("</br>Errore: connessione al DB fallita."); }
	elseif ($codUscita==2) { echo("</br>Errore: DB non trovato."); }
	elseif ($codUscita==3) { echo("</br>Errore: nome utente gi&agrave; registrato."); }
	elseif ($codUscita==4) { echo("</br>Errore sul salvataggio user/pwd."); }
	elseif ($codUscita==5) { echo("</br>Errore sul salvataggio mail."); }
	elseif ($codUscita==6) { echo("</br>Errore sull'avanzamento della registrazione."); }
	elseif ($codUscita==7) { echo("</br>Errore sull'inserimento dell'utente."); }
	elseif ($codUscita==8) { echo("</br>Errore nella ricerca dell'utente nel DB."); }
	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
// echo ("</br> sql=" . $sql);
	if ($codUscita!=0) {
		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}

/*
delete from TB_MAIL WHERE MAIL='torresin7@gmail.com';
delete from TB_USER WHERE USER='Lore74';
delete from TB_PERSONA WHERE NOME='Lorenzo' AND COGNOME='Torresin';
*/
// echo "</br>FINE PAGINA!";
?>
	</div>
	</body>
</html>
