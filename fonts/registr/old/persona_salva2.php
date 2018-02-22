<?php
session_start();
// echo "parametroT >" . $_SESSION['FLAG_PERSONA'] . "<</br>";
?>
 <!DOCTYPE html>
  <html>
    <head>
		<!--Import Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.min.css"  media="screen,projection"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body bgcolor="white">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $_SESSION['PATH'];?>/js/materialize.min.js"></script>
	<script type="text/javascript" src="<?php echo $_SESSION['PATH'];?>/js/init.js"></script>
	<?php
	
	
	include "../menu.php";
	echo "</br></br><div class=\"container\">";

	$NOME = htmlspecialchars($_POST['NOME']);
	$COGNOME = htmlspecialchars($_POST['COGNOME']);
	$DATA_NASCITA = date('Y-m-d',strtotime($_POST['DATA_NASCITA']));
	
	//$DATA_NASCITA = htmlspecialchars($_POST['DATA_NASCITA']);
	$STATO_NASCITA = htmlspecialchars($_POST['STATO_NASCITA']);
	$COMUNE_NASCITA = htmlspecialchars($_POST['COMUNE_NASCITA']);
	$STATO_RESIDENZA = htmlspecialchars($_POST['STATO_RESIDENZA']);
	$PROV_RESIDENZA = htmlspecialchars($_POST['PROV_RESIDENZA']);
	$COMUNE_RESIDENZA = htmlspecialchars($_POST['COMUNE_RESIDENZA']);
	$CAP = htmlspecialchars($_POST['CAP']);
	if(!isset($_SESSION['ID_AREA']) AND !isset($_SESSION['ID_USER']) AND !isset($_SESSION['ID_PERMESSO']) AND !isset($_SESSION['FLAG_REG'])) 
	{
		echo ("Errore</br>");
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
	
	
	echo ("$DATA_NASCITA<</br>");	
	$codUscita=0;
	$sql="";
	
	
	if ($codUscita==0) {
		// INFO DB
		$DBhost = "localhost";
		$DBuser = "ricibo";
		$DBpass = "pwd-cibo17";
		$DBName = "ricibo";
		$DBtable = "TB_PERSONA";
		$db = mysql_connect($DBhost, $DBuser, $DBpass);
		if (!$db) { $codUscita=1; } // Errore: connessione al DB fallita
		$ris = mysql_select_db($DBName);
		if (!$ris) { $codUscita=2; } // Errore: DB non trovato
echo "</br> USER=" . $NOME; // CONTROLLO SE C'E' UN USER CON QUESTO NOME	
		$i=0;
		$sql1 = "INSERT INTO TB_PERSONA(NOME,COGNOME,DATA_NASCITA,STATO_NASCITA,COMUNE_NASCITA,STATO_RESIDENZA,PROV_RESIDENZA,COMUNE_RESIDENZA,CAP)";
		$sql2 = " VALUES (\"$NOME\",\"$COGNOME\", $DATA_NASCITA, \"$STATO_NASCITA\",\"$COMUNE_NASCITA\",\"$STATO_RESIDENZA\",\"$PROV_RESIDENZA\",\"$COMUNE_RESIDENZA\",\"$CAP\")";
		$sql = $sql1 . $sql2;
echo "</br> sql=" . $sql;
		$result = mysql_query($sql);
		// CARICO IN SESSIONE I DATI UTENTE
		$_SESSION['ID_PERSONA']=mysql_insert_id();
		//$_SESSION['FLAG_PRI_SEC']= ;		
echo "</br> result=" . $result;
		// SE LA REGISTRAZIONE E' OK, AGGIORNO LO STATO DI REGISTRAZIONE IN SESSIONE E TABELLA
		if (($codUscita==0) AND ($_SESSION['FLAG_REG']!=0)){
			if ($_SESSION['FLAG_PERSONA']=='V')
				{ $FLAG_REG = 0; }
			if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R'))
				{ $FLAG_REG = 3; }
			$_SESSION['FLAG_REG'] = $FLAG_REG;
			$stmp = $_SESSION['ID_PERSONA'];
			$stmp2 = $_SESSION['ID_USER'];
			$sql = "UPDATE TB_USER SET ID_PERSONA=$stmp, FLAG_REG=$FLAG_REG WHERE (ID_USER=$stmp2);";
echo ("</br> sql=" . $sql);
			$result = mysql_query($sql);
echo "</br> result=" . $result;
			if ($result == false) { $codUscita=6; } // Errore sull'avanzamento della registrazione
echo ("</br>SONO QUA!");
		}
		mysql_close($db);
	}
echo ("</br> codUscita=" . $codUscita);
echo ("</br> ID_USER=" . $ID_USER);

	if ($codUscita==0) {
		// CASO DI MODIFICA DATI
		if ($_SESSION['FLAG_REG']==0) {
			header("location: ../index.php");
		} else {
		// CASO DI PRIMA REGISTRAZIONE
			if ($_SESSION['FLAG_PERSONA']=='V')
				{ header("location: ../index.php"); }
			if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R'))
				{ header("location: ass_neg.php"); }
		}
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
	// SCRIVO L'ERRORE SQL SOLO SE SONO IN SVILUPPO O SE SONO UN ADMIN O SVILUPPATORE
echo ("</br> sql=" . $sql);
echo ("</br> SERVER['SCRIPT_NAME']=" . $_SERVER['SCRIPT_NAME']);
echo ("</br> SESSION['ID_PERMESSO']=" . $_SESSION['ID_PERMESSO']);
	if ($codUscita!=0) {
		if ($sql!="") {
			$NomeFile=$_SERVER['SCRIPT_NAME'];
			if (strlen($NomeFile)>8) {
				if((substr($NomeFile, 0, 9)=="/~ricibo/") OR ($_SESSION['ID_PERMESSO']==1) OR ($_SESSION['ID_PERMESSO']==2))
					{ echo ("</br> sql=" . $sql); }
			}
		}
		echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
	}
/*
delete from TB_MAIL where MAIL='torresin7@gmail.com';
delete from TB_USER WHERE (ID_USER>10);
delete from TB_PERSONA where NOME='Lorenzo' AND COGNOME='Torresin';
*/
?>
	</div>
	</body>
</html>