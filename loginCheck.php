<html>
<head>
	<?php include 'menuHead.php'; ?>
	<meta name="viewport" content="initial-scale=1.0, USER-scalable=no"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body bgcolor="white">
	<?php include "menu.php"; ?></br></br><center>
<?php
// TESTO SE IL FORM RENDE VALORI
if(!isset($_POST['PWD'])) { die("CAMPI NON LETTI!"); }
// LETTURA USER E PWD
$USER = $_POST['USER'];
$PWD = $_POST['PWD'];
// CONNESSIONE AL DB
include "funzioni/oDBConn.php";
$codUscita = oDBConn();
// echo ("</br> codUscita=" . $codUscita);
if (is_numeric($codUscita)) { 
	if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
	elseif ($codUscita == 2 ) {
		echo("</br>Errore: DB non trovato.");
		mysqli_close($codUscita );
	}
} else {
	$db = $codUscita;
	$sql  = "SELECT U.ID_AREA, U.ID_USER, U.ID_PERSONA, ID_PERMESSO, U.FLAG_PERSONA, USER, FLAG_REG, PE.FLAG_PRI_SEC, NA.ID_NEG_ASS, NA.FLAG_NEG_PRI_SEC";
	$sql .= " FROM TB_USER U";
	$sql .= " LEFT JOIN TB_PERSONA PE ON (U.ID_PERSONA=PE.ID_PERSONA)";
	$sql .= " LEFT JOIN TB_PERS_NEG_ASS PNA ON (PE.ID_PERSONA=PNA.ID_PERSONA)";
	$sql .= " LEFT JOIN TB_NEG_ASS NA ON (PNA.ID_NEG_ASS=NA.ID_NEG_ASS)";
	$sql .= " WHERE U.USER='$USER' AND U.PWD='$PWD';";
	// echo ("</BR> sql= > " . $sql . " <</BR>");

	// LETTURA DATI UTENTE
	$result = mysqli_query($db,$sql);	//order executes
	if($result != false){
		while($riga=@mysqli_fetch_array($result)){
			$_SESSION["ID_AREA"]=$riga['ID_AREA'];
			$_SESSION["ID_USER"]=$riga['ID_USER'];
			$_SESSION["ID_PERSONA"]=$riga['ID_PERSONA'];
			$_SESSION["ID_PERMESSO"]=$riga['ID_PERMESSO'];
			$_SESSION["FLAG_PERSONA"]=$riga['FLAG_PERSONA'];
			$_SESSION["USER"]=$riga['USER'];
			$_SESSION["FLAG_REG"]=$riga['FLAG_REG'];
//			$_SESSION["FLAG_AREA_NEG_ASS"]=$riga['FLAG_AREA_NEG_ASS']; // <-- NON SERVE, LEGGO DA FLAG_PERSONA
			$_SESSION["FLAG_PRI_SEC"]=$riga['FLAG_PRI_SEC'];
			$_SESSION["ID_NEG_ASS"]=$riga['ID_NEG_ASS'];
			$_SESSION["FLAG_NEG_PRI_SEC"]=$riga['FLAG_NEG_PRI_SEC'];
/*
echo ("</br> SESSION['ID_AREA']=" . $_SESSION['ID_AREA']);
echo ("</br> SESSION['ID_USER']=" . $_SESSION['ID_USER']);
echo ("</br> SESSION['ID_PERSONA']=" . $_SESSION['ID_PERSONA']);
echo ("</br> SESSION['ID_PERMESSO']=" . $_SESSION['ID_PERMESSO']);
echo ("</br> SESSION['USER']=" . $_SESSION['USER']);
echo ("</br> SESSION['FLAG_REG']=" . $_SESSION['FLAG_REG']);
echo ("</br> SESSION['FLAG_PERSONA']=" . $_SESSION['FLAG_PERSONA']);
echo ("</br> SESSION['FLAG_PRI_SEC']=" . $_SESSION['FLAG_PRI_SEC']);
echo ("</br> SESSION['FLAG_NEG_PRI_SEC']=" . $_SESSION['FLAG_NEG_PRI_SEC']);
*/
			mysqli_close($db);
// echo ("</br> SESSION['FLAG_REG']=" . $_SESSION['FLAG_REG']);
// if (is_numeric($_SESSION["FLAG_REG"])) { echo("isNumeric</BR>"); }
			// REDIRIGO SULLA PAGINA PER LA QUALE DEVE COMPLETARE LA REGISTRAZIONE
			switch ($_SESSION["FLAG_REG"]) {
				case 2 : header("location: registr/persona.php"); break;
				case 3 : header("location: registr/neg_ass.php"); break;
				case 4 : header("location: registr/apertura.php"); break;
				case 4 : header("location: registr/mess_registr.php"); break;
				case 5 : header("location: registr/chiusura.php"); break;
				case 6 : header("location: registr/aper_extra.php"); break;
				case 7 : header("location: registr/mess_registr.php"); break;
				case 9 : header("location: registr/mess_registr.php"); break;
				default : header("location: index.php"); break;
			}
		}
		mysqli_close($db);
		echo("UTENTE NON TROVATO O PASSWORD SBAGLIATA!");
	} else {
		echo("UTENTE NON TROVATO O PASSWORD SBAGLIATA!");
	}
}
?>	</br></br><input type="button" value="Indietro" onclick="window.history.back()"/>
</center>
</body>
</html>
