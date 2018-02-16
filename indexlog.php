<html>
	<head>
		<?php include 'menuHead.php'; ?>
	</head>
<body bgcolor="white">
<?php include 'menu.php'; ?>
</BR></BR></BR></BR>
	<div class="container">
	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center">
	<div class="card-content white-text">
		<font color="white">
		<span class="card-title">IL MIO ACCOUNT</span></BR>
		<span class="white-text">Da qui posso accedere ai servizi o alla visualizzazione/modifica dei seguenti dati:</span></BR>
		<span class="white-text">
<?php //echo($_SESSION["FLAG_PERSONA"] . "</BR>");
	$bRegistrato = false;
	if (isset($_SESSION["FLAG_REG"])) { $bRegistrato = ($_SESSION["FLAG_REG"] == 0); }
	if ($bRegistrato) { ?>
			<a href="./registr/user.php"><font color="white">- ACCOUNT</font></a></BR>
			<a href="./registr/persona.php"><font color="white">- DATI PERSONALI</font></a></BR>
<?php	if ($_SESSION["FLAG_PERSONA"] == "N") { ?>
			<a href="./registr/neg_ass.php"><font color="white">- NEGOZIO</font></a></BR>
			<a href="./registr/apertura.php"><font color="white">- RITIRO ORARIO SETTIMANALE</font></a></BR>
<?php
/*			
			<a href="./registr/chiusure_extra1.php"><font color="white">Chiusure extra</font></a></BR>
			<a href="./registr/aperture_extra1.php"><font color="white">Aperture extra</font></a></BR>
			<a href="./registr/tipo_cibo1.php"><font color="white">Tipologia cibo donato</font></a></BR>
			<a href="./registr/giacenza.php"><font color="white">Inserimento giacenza cibo</font></a></BR>
			<a href="./registr/report_cibo1.php"><font color="white">Report cibo donato</font></a></BR>
 */
		} elseif ($_SESSION["FLAG_PERSONA"] == "V"){ ?>
			<a href="./registr/download_list.php"><font color="white">- DOWNLOAD APP RICIBO (solo per smartphone)</font></a></BR>
<?php	} elseif ($_SESSION["FLAG_PERSONA"] == "A"){ ?>
			<a href="./registr/neg_ass.php"><font color="white">- ASSOCIAZIONE</font></a></BR>
			<a href="./registr/apertura.php"><font color="white">- CONSEGNA ORARIO SETTIMANALE</font></a></BR>
<?php
/*
			<a href="./registr/chiusure_extra3.php"><font color="white">Chiusure extra</font></a></BR>
			<a href="./registr/aperture_extra3.php"><font color="white">Aperture extra</font></a></BR>
			<a href="./registr/tipo_cibo3.php"><font color="white">Tipologia cibo che si consuma</font></a></BR>
			<a href="./registr/conferma_cibo.php"><font color="white">Conferma cibo ricevuto</font></a></BR>
			<a href="./registr/report_cibo3.php"><font color="white">Report cibo ricevuto</font></a></BR>
*/
		} 
	} else {
		echo ("La registrazione non &egrave ancora completa.</BR>Attendere l'invio della mail per completarla");
	}
?>
		</font>
		</span>
		</span>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
 