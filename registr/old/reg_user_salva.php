<?php
session_start();
// echo "parametroT >" . $_SESSION['FLAG_PERSONA'] . "<</br>";
?>
<!DOCTYPE html>
<html>
  <body bgcolor="white">
    <?php
	// include "../menu.php"

	$PWD = htmlspecialchars($_POST['PWD']);
	$USER = htmlspecialchars($_POST['USER']);
	$PWD2 = htmlspecialchars($_POST['PWD2']);
	$ID_AREA = htmlspecialchars($_POST['ID_AREA']);
	$MAIL = htmlspecialchars($_POST['MAIL']);
	$MAIL2 = htmlspecialchars($_POST['MAIL2']);
	$ID_PERMESSO = 4;

	$codUscita=0;
	$sql="";
	// CONTROLLO LUNGHEZZA PWD >6 CHAR
	if(strlen($PWD) >= 6 && strlen($PWD) <= 12) {
		if($PWD != $PWD2) {	$codUscita=-1; } // Errore: le password inserite non risultano uguali
	} else { $codUscita=-2;} // Errore: la password deve avere una lunghezza fra 6 e 12 caratteri

// echo "</br> MAIL=" . $MAIL;
	
	if ($codUscita==0) {
		// CONTROLLO LUNGHEZZA MAIL <= 50 CHAR
		if (strlen($MAIL) >= 8 && strlen($MAIL) <= 50) {
			if($MAIL != $MAIL2) { $codUscita=-3; } // Errore: le mail inserite non risultano uguali
			else { // CONTROLLO CORRETTEZZA SINTASSI MAIL
				$i=stripos($MAIL, '@');
				$i2=strrpos($MAIL, '.', $i);
				$l=strlen($MAIL);
// echo "</br> i=" . $i;
// echo "</br> i2=" . $i2;
// echo "</br> l=" . $l;
				$codUscita=-4; // Errore: la mail ha una sintassi errata
				if ($i>2) { if ($i2>(i+2)) { if ($l>$i2+2) { $codUscita=0; } } }
			}
		} else { $codUscita=-5; } // Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri
	}


	if ($codUscita==0) {
		// INFO DB
		$DBhost = "localhost";
		$DBuser = "ricibo";
		$DBpass = "pwd-cibo17";
		$DBName = "ricibo";
		$DBtable = "TB_USER";
		$db = mysql_connect($DBhost, $DBuser, $DBpass);
		if (!$db) { $codUscita=1; } // Errore: connessione al DB fallita
		$ris = mysql_select_db($DBName);
		if (!$ris) { $codUscita=2; } // Errore: DB non trovato
// echo "</br> USER=" . $USER;
		// CONTROLLO SE C'E' UN USER CON QUESTO NOME
		$sql = "SELECT * FROM TB_USER WHERE (USER='$USER')";
// echo "</br> sql=" . $sql;
		$result = mysql_query($sql);
		$i=0;
// echo "</br> result=" . $result;

		if ($result != false) {
			while ($riga = mysql_fetch_array($result)) { ++$i; }
		} else { $codUscita=8; } // ERRORE NELLA RICERCA DELL'UTENTE SUL 
// echo ("</br> i=" . $i);


		if ($i>0) { // AVVISO PRESENZA DI UN USER GIA' INSERITO
			$codUscita=3; // Errore: nome utente gia' registrato
		} else { // INSERIMENTO USER E SUOI DATI

			$sql1 = "INSERT INTO TB_USER(ID_AREA, ID_PERMESSO, USER, PWD, FLAG_REG)";
			$sql2 = " VALUES ($ID_AREA, $ID_PERMESSO, '$USER', '$PWD', 1);";
			$sql = $sql1 . $sql2;
// echo("</br>sql>$sql<</br>");
			$result = mysql_query($sql, $db);
// echo "</br> result=" . $result;

			if ($result == false) {
				$codUscita=7; // Errore: inserimento utente fallito
			} else {
				// FARE: LETTURA ID USER APPENA INSERITO PER INSERIRLO NELLA SESSION[]
				$sql = "SELECT * FROM TB_USER WHERE (ID_AREA=$ID_AREA) AND (ID_PERMESSO=$ID_PERMESSO) AND (USER='$USER') AND (PWD='$PWD');";
// echo("</br>sql>$sql<</br>");
				$result = mysql_query($sql);
// echo "</br> result=" . $result;
				$codUscita=4; // Errore sul salvataggio user/pwd
				if($result != false){
					while($riga=mysql_fetch_array($result)){
						$_SESSION['ID_USER']=$riga['ID_USER'];
						$codUscita=0;
					}
				}
// echo("</br>ID_USER>" . $_SESSION['ID_USER'] . "<</br>");
				if ($codUscita==0) {
					// FARE: INSERIRE NELLA TB_MAIL LA MAIL ANCHE PER LA CONFERMA ID REGISTRAZIONE
					$sql1 = "INSERT INTO TB_MAIL(ID_AREA, ID_USER, MAIL)";
					$tmp = $_SESSION['ID_USER'];
					$sql2 = " VALUES ($ID_AREA, $tmp, '$MAIL');";
					$sql = $sql1 . $sql2;
// echo("</br>sql>$sql<</br>");
					$result = mysql_query($sql);
// echo "</br> result=" . $result;
					if($result == false) { $codUscita=5; } // Errore sul salvataggio mail
				}
				// SE LA REGISTRAZIONE MAIL E' OK, AGGIORNO LO STATO DI REGISTRAZIONE
				if ($codUscita==0) {
					$sql = "UPDATE TB_USER SET FLAG_REG=1 WHERE (ID_USER=$tmp);";
					$result = mysql_query($sql);
					if ($result == false) { $codUscita=6; } // Errore sull'avanzamento della registrazione
					echo ("SONO QUA!");
				}
			}
		}
		mysql_close($db);
	}
// echo ("</br> codUscita=" . $codUscita);
// echo ("</br> FLAG_PERSONA=" . $_SESSION['FLAG_PERSONA']);

	if ($codUscita==0) {
		if ($_SESSION['FLAG_PERSONA']=='V')
			{ header("location: reg_vettore.php"); }
		if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R'))
			{ header("location: reg_ass_neg.php"); }
	}
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

	if (($codUscita!=0) AND ($sql!="")) { echo("</br>sql >$sql<</br>"); }

/*
delete from TB_MAIL where MAIL='torresin7@gmail.com';
delete from TB_USER WHERE (ID_USER>30);
*/
// echo "</br>FINE PAGINA!";
?>
  </body>
</html>
