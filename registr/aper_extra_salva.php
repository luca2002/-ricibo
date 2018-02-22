<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
    <?php include "../menu.php";
    	echo "</br></br><div class=\"container\">";
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
    	}
	    // echo ("</br> SONO QUA0");
    	// SE IL CODICE <> 1 o 2 LO METTO A 0 PERCHE' IL VALORE E' LA CONNESSIONE AL DB
    	if ($codUscita == (1 || 2)) {
				$ID_NEG_ASS = 0;
				//$ID_NEG_ASS = $_SESSION['ID_NEG_ASS'];
				$DEL_DATA=$_GET['DEL_DATA'];
				if (isset($DEL_DATA)) {
	    	  $sql = "DELETE FROM TB_APER_EXTRA where ID_NEG_ASS = $ID_NEG_ASS AND GIORNO_APERTURA = '$DEL_DATA';";
	    	  $ris = mysql_query($sql, $db);
					echo("</BR>sql>$sql<");
	    	  if(!$ris) {
	    		  $codUscita = 3;
	    	  }
				}
				else {
	    		$codUscita = 0;
	        $ID_AREA = 0;
	    		//$ID_AREA = $_SESSION['ID_AREA'];
	    		$GIORNO_APERTURA = htmlspecialchars($_POST['DATA']);
	    		$ORARIO_APERTURA1 = htmlspecialchars($_POST['ORA1_APER']);
	    		$ORARIO_CHIUSURA1 = htmlspecialchars($_POST['ORA1_CHIU']);
	    		$ORARIO_APERTURA2 = htmlspecialchars($_POST['ORA2_APER']);
	    		$ORARIO_CHIUSURA2 = htmlspecialchars($_POST['ORA2_CHIU']);
		    	if($ORARIO_APERTURA1 != NULL && $ORARIO_CHIUSURA1 != NULL) {
		    		if($ORARIO_CHIUSURA1 == NULL && $ORARIO_APERTURA1 != NULL) {
		    		  $codUscita =  -1;
		    			$GIORNO_ERRORE = $GIORNO_SETTIMANA;
		    		}
		    		else if($ORARIO_APERTURA1 > $ORARIO_CHIUSURA1) {
		    			$codUscita =  -1;
		    			$GIORNO_ERRORE = $GIORNO_SETTIMANA;
		    		}
		    	}
		    	if($codUscita == 0) {
		    		if($ORARIO_APERTURA2 != NULL && $ORARIO_CHIUSURA2 != NULL) {
		    			if($ORARIO_CHIUSURA2 == NULL && $ORARIO_APERTURA2 != NULL) {
		    				$codUscita =  -1;
		    				$GIORNO_ERRORE = $GIORNO_SETTIMANA;
		    			}
		    			else if($ORARIO_APERTURA2 > $ORARIO_CHIUSURA2) {
		    				$codUscita =  -1;
		    				$GIORNO_ERRORE = $GIORNO_SETTIMANA;
		    			}
		    			else if($ORARIO_CHIUSURA1 != NULL) {
		    				if($ORARIO_APERTURA2 < $ORARIO_CHIUSURA1) {
		    					$codUscita =  -1;
		    					$GIORNO_ERRORE = $GIORNO_SETTIMANA;
		    				}
		    			}
		    		}
		    	}
		    	if($codUscita == 0) {
		    	  $sql = "";
		    	  $sql1 = "INSERT INTO TB_APER_EXTRA(ID_AREA, ID_NEG_ASS, GIORNO_APERTURA, ORA1_INIZIO, ORA1_FINE, ORA2_INIZIO, ORA2_FINE)";
		    	  $sql2 = "VALUES($ID_AREA, $ID_NEG_ASS, '$GIORNO_APERTURA', '$ORARIO_APERTURA1', '$ORARIO_CHIUSURA1', '$ORARIO_APERTURA2', '$ORARIO_CHIUSURA2');";
		    	  $sql = $sql1 . $sql2;
		    	  echo("</BR>sql>$sql<");
		    	  $ris = mysql_query($sql, $db);
		    	  if(!$ris) {
		    		  $codUscita = 3;
		    	  }
		    	}
		    	if (($codUscita==0) AND ($_SESSION['FLAG_REG']!=0)) {
		    		$FLAG_REG = $_SESSION['FLAG_REG'];
		    		if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R')) {
		    			$FLAG_REG = $FLAG_REG + 1;
		    		} else {
		    			$FLAG_REG = 0;
		    		}
		    		$_SESSION['FLAG_REG'] =  $FLAG_REG;
		    		$ID_USER = $_SESSION['ID_USER'];
		    		$sql = "UPDATE TB_USER SET FLAG_REG = $FLAG_REG WHERE ID_USER = $ID_USER;";
		    		$risultato_query = mysql_query($sql, $db);
		    		if ($risultato_query == false) {
		    			$codUscita=6;
		    		} // Errore sul salvataggio dati di collegamento
		        else {
		      	   mysql_close($db);
		        }
	    		}
				}
			}
    	//if ($codUscita == 0) {
    		/*if ($_SESSION['FLAG_REG'] == 0) {
    			header("location: ../index.php"); // CASO DI MODIFICA DATI
    		} else {*/
    		//	header("location: ./aper_extra.php");	// CASO DI PRIMA REGISTRAZIONE
    		//}
    	//}
    	elseif ($codUscita == -1) {
    		echo ("</br>Errore: orario non corretto nel giorno " . $GIORNO_ERRORE . ".</BR>Dati non salvati.");
    		$sql = "DELETE FROM TB_APER_EXTRA WHERE ID_NEG_ASS = $ID_NEG_ASS;";
    		$ris = mysql_query($sql, $db);
    		mysql_close($db);
    		if (!$ris) {
    			echo ("</BR>sql>$sql</br>Errore nella cancellazione dei campi corretti dal DB.");
    		}
    	}
    	elseif ($codUscita == 3) { echo ("</br>Errore: inserimento nel DB non corretto."); 	}
    	elseif ($codUscita == 6) { echo ("</br>Errore sull'avanzamento della registrazione."); }
    	elseif ($codUscita == 8) { echo ("</br>Errore nella ricerca dell'utente nel DB."); }
    	// echo ("</br> codUscita=" . $codUscita);
    	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
    	if ($codUscita!=0) {
    		if (($sql!="") AND ($_SESSION['FLAG_DEBUG'])) { echo("</br> sql=" . $sql); }
    		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
      }
    ?>
	 </div>
  </body>
</html>
