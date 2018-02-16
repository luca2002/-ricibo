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
		<script type="text/javascript" src="/~ricibo/js/materialize.min.js"></script>
		<script type="text/javascript" src="/~ricibo/js/init.js"></script>
  	<?php
			include "../menu.php";
			echo "</br></br><div class=\"container\">";
			/* FLAG_AREA_NEG_ASS CHAR LO LEGGO DALLA SESSIONE */
			//$ID_AREA = $_SESSION['ID_AREA'];
			$ID_AREA = 0;
			$FLAG_AREA_NEG_ASS = "T"; // TEST
			$FLAG_PRI_SEC = htmlspecialchars($_POST['FLAG_PRI_SEC']);
			$NOME = htmlspecialchars($_POST['NOME']);
			$COGNOME = htmlspecialchars($_POST['COGNOME']);
			$P_IVA = htmlspecialchars($_POST['P_IVA']);
			$STATO_SEDE = htmlspecialchars($_POST['STATO_SEDE']);
			$COMUNE_SEDE = htmlspecialchars($_POST['COMUNE_SEDE']);
			$PROVINCIA_SEDE = htmlspecialchars($_POST['PROVINCIA_SEDE']);
			$TIPO_ALIMENTI = htmlspecialchars($_POST['TIPO_ALIMENTI']);
			$TELEFONO_STRUTTURA = htmlspecialchars($_POST['TELEFONO_STRUTTURA']);
			$GPS_X = 12345;
			$GPS_Y = 67890;
			$MAIL = htmlspecialchars($_POST['MAIL']);
			$ID_PERMESSO = 4;
			$codUscita = 0;
			$sql="";
			if (strlen($NOME) < 2 || strlen($NOME) > 30) {
				$codUscita = 1;	//Errore: il nome e il cognome devono essere di almeno 2 caratteri
			}
			if (strlen($COGNOME) < 2 || strlen($COGNOME) > 30) {
				$codUscita = 1;
			}
			if (strlen($P_IVA) != 11) {
				$codUscita = 2; //Errore: la partita iva deve essere di 11 caratteri
			}
			if (strlen($STATO_SEDE) < 2 || strlen($STATO_SEDE) > 30) {
				$codUscita = 3;	//Errore: il nome dello stato deve essere compreso tra i 2 e i 30 caratteri
			}
			if (strlen($COMUNE_SEDE) < 2 || strlen($COMUNE_SEDE) > 30) {
				$codUscita = 4;	//Errore:il nome del comune deve essere compreso tra i 2 e i 30 caratteri
			}
			if (strlen($PROVINCIA_SEDE) != 2) {
				$codUscita = 5;	//Errore: inserire una provincia valida
			}
			if (strlen($TELEFONO_STRUTTURA) < 10 || strlen($TELEFONO_STRUTTURA) > 14 ) {
				$codUscita = 6;	//Errore: inserire un numero di telefono valido
			}
			if (strlen($MAIL) < 8 || strlen($MAIL) > 50) {
				$codUscita = 7;	//Errore: la mail deve avere una lunghezza fra 8 e 50 caratteri
			}
			if ($codUscita == 0){
		 		/*INFO DB*/
				$DBhost = "localhost";
				$DBuser = "ricibo";
				$DBpass = "pwd-cibo17";
				$DBName = "ricibo";
				$DBtable = "TB_NEG_ASS";
				$db = mysql_connect($DBhost, $DBuser, $DBpass);
				if(!$db) {
					echo "</BR>Connection to DB Failed.";
					return;
				} else {
					echo "</BR>Connection to DB OK!";
				}
				$ris = mysql_select_db($DBName);
				if(!$ris){
					echo("</BR>Error: Database not found");
					return;
				} else {
					echo "</BR>Database found!";
				}
				$sql1 = "INSERT INTO TB_NEG_ASS(ID_AREA, FLAG_AREA_NEG_ASS, FLAG_PRI_SEC, COGNOME, NOME, P_IVA, STATO_SEDE, COMUNE_SEDE, PROVINCIA_SEDE, TIPO_ALIMENTI, TELEFONO_STRUTTURA, GPS_X, GPS_Y, MAIL)";
				$sql2 = "VALUES($ID_AREA, '$FLAG_AREA_NEG_ASS', '$FLAG_PRI_SEC', \"$COGNOME\", \"$NOME\", \"$P_IVA\", \"$STATO_SEDE\", \"$COMUNE_SEDE\", \"$PROVINCIA_SEDE\", '$TIPO_ALIMENTI', \"$TELEFONO_STRUTTURA\", $GPS_X, $GPS_Y, \"$MAIL\");";
				$sql = $sql1 . $sql2;
				echo("</BR>sql>$sql<");
				$risultato_query = mysql_query($sql, $db);
				if($risultato_query) {
					echo("</BR>OK!");
				} else {
					echo "</BR>Error: " . mysql_error($db) . "</BR>sql>$sql<";
					return;
				}
				$ID_NEG_ASS = mysql_insert_id();
				//$ID_PERSONA = $_SESSION['ID_PERSONA'];
				$ID_PERSONA = 0;
				$sql1 = "INSERT INTO TB_PERS_NEG_ASS(ID_AREA, ID_NEG_ASS, ID_PERSONA)";
				$sql2 = "VALUES($ID_AREA, $ID_NEG_ASS, $ID_PERSONA);";
				$sql = $sql1 . $sql2;
				echo("</BR>sql>$sql<");
				$risultato_query = mysql_query($sql, $db);
				if($risultato_query) {
					echo("</BR>OK!");
				} else {
					echo "</BR>Error: " . mysql_error($db) . "</BR>sql>$sql<";
					return;
				}
				$_SESSION['FLAG_PERSONA'] = $FLAG_AREA_NEG_ASS;
				$_SESSION['FLAG_NEG_PRI_SEC'] = $FLAG_PRI_SEC;
				$_SESSION['FLAG_REG'] = 4;
				//$ID_USER = $_SESSION['ID_USER'];
				$ID_USER = 6;
				$sql1 = "UPDATE TB_USER SET FLAG_REG = 4 WHERE ID_USER = $ID_USER;";
				$sql = $sql1;
				echo("</BR>sql>$sql<");
				$risultato_query = mysql_query($sql, $db);
				if($risultato_query) {
					echo("</BR>OK!");
				} else {
					echo "</BR>Error: " . mysql_error($db) . "</BR>sql>$sql<";
					return;
				}
				mysql_close($db);
			}
			if ($codUscita==0) {
				if ($_SESSION['FLAG_PERSONA']=='V') {
					header("location: vettore.php");
				}
				if (($_SESSION['FLAG_PERSONA']=='N') OR ($_SESSION['FLAG_PERSONA']=='A') OR ($_SESSION['FLAG_PERSONA']=='R')) {
					header("location: ass_neg.php");
				}
			}
			elseif ($codUscita == 1) {
				echo("</br>Errore: il nome e il cognome devono essere di almeno 2 caratteri.");
			}
			elseif ($codUscita == 2) {
				echo("</br>Errore: la partita iva deve essere di 11 caratteri.");
			}
			elseif ($codUscita == 3) {
				echo("</br>Errore: il nome dello stato deve essere compreso tra i 2 e i 30 caratteri.");
			}
			elseif ($codUscita == 4) {
				echo("</br>Errore: il nome del comune deve essere compreso tra i 2 e i 30 caratteri.");
			}
			elseif ($codUscita == 5) {
				echo("</br>Errore: inserire una provincia valida.");
			}
			elseif ($codUscita == 6) {
			 echo("</br>inserire un numero di telefono valido.");
			}
			elseif ($codUscita == 7) {
				echo("</br>la mail deve avere una lunghezza fra 8 e 50 caratteri.");
			}
			if ($codUscita != 0) {
				if ($sql != "") {
					$NomeFile = $_SERVER['SCRIPT_NAME'];
					if (strlen($NomeFile) > 7) {
						if((substr($NomeFile, 0, 8) == "/~ricibo") OR ($_SESSION['ID_PERMESSO'] == 1) OR ($_SESSION['ID_PERMESSO'] == 2)) {
							echo ("</br> sql=" . $sql);
						}
					}
				}
				echo ("</br></br><input type=\"button\" value=\"Indietro\" onclick=\"window.history.back()\"/>");
			}
		?>
	</div>
	</body>
</html>
