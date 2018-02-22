<!DOCTYPE html>
<html>
	<head>
		<?php include "menuHead.php"; ?>
    </head>
<body bgcolor="white">
<?php include "menu.php"; ?>
	<div class="input-field col s12"></BR>
<?php include "./funzioni/oDBConn.php";
	$codUscita = 0;
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) { // APERTURA CONNESSIONE AL DB
		if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
		elseif ($codUscita == 2 ) {
			echo("</br>Errore: DB non trovato.");
			mysql_close($codUscita );
		}
	} else {
		// SE TUTTO OK, SALVO LA CONNESSIONE AL DB
		$db = $codUscita;
		$codUscita = 0;
		// CICLO SULLA MAIL DA INVIARE
		$sql = "SELECT * FROM TB_MAIL_INVIATE WHERE (FLAG_SPEDITA<>'S') OR (ISNULL(FLAG_SPEDITA));";
//echo ("</br>sql>" . $sql);
		$risultato_query = mysql_query($sql, $db);
		
// if ($risultato_query) { echo("vero</BR>"); } else {  echo("false</BR>"); }
// echo ("</br>risultato_query>" . $risultato_query);
		
		if (!$risultato_query) {
// echo ("</br>no record");
			// NESSUN RECORD TROVATO
			header("location: index.html");
		} else {
// echo ("</br>si record");
// if ($riga = mysql_fetch_array($risultato_query)) { echo("vero</BR>"); } else {  echo("false</BR>"); }
			while ($riga = mysql_fetch_array($risultato_query)) {
// echo ("</br>si record2");
				// CREAZIONE PWD			
				$i = date("w");
				// GESTISCO IL CORRETTIVO SULLA DIFFERENZA DEL GIORNO DELLA SETTIMANA INGLESE/INTERNAZIONALE
				if ($i==6) { $i=0; } else { $i++; }
				// $sCod = "S" . date("n") . date("j") . $i;
				// echo  "sCod1 >" . $sCod . "<</br>";
				$sCod = "S" . chr(65+date("n")) . chr(65+date("j")) . chr(65+$i);
				// echo  "sCod2 >" . $sCod . "<</br>";
				if(isset($_SESSION['INVIO_MAIL'])) { $sCod = $sCod . $_SESSION['INVIO_MAIL']; }
				$_SESSION['INVIO_MAIL']="";
				$ID_MAIL=$riga['ID_MAIL'];
				$MITTENTE=$riga['MITTENTE'];
				$DESTINATARIO=$riga['DESTINATARIO'];
				$SOGGETTO=$riga['SOGGETTO'];
				$TESTO=$riga['TESTO'];
				$sPar="C=$sCod&M=$MITTENTE&D=$DESTINATARIO&S=$SOGGETTO&T=$TESTO";
				if (strlen($sPar) > 2048) { $sPar=substr($sPar, 0, 2048); }
// echo ("</br> sPar=" . $sPar);				
				$url = "http://www.ltsweb.it/RiCibo/RiCibo-invio.asp?". $sPar;
				// $url = htmlspecialchars($url);
// echo ("</br> url=" . $url);
				// echo("<script type=\"text/javascript\">window.open($url);</script>");
				// echo("<script>window.open($url);</script></BR>");
				$sql = "UPDATE TB_MAIL_INVIATE SET FLAG_SPEDITA='S' WHERE (ID_MAIL=$ID_MAIL);";
				$result = mysql_query($sql);
				header("location: $url");
				// sleep(1);
				// header("location: http://www.ltsweb.it/RiCibo/RiCibo-invio.asp?". $sPar);
			}
		}
		mysql_close($db);
	}
// http://www.hensemberger.it/~ricibo/invio-mail.php
?>
	</div>
	</body>
</html>
