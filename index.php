<!DOCTYPE html>
<html>
	<head>
		<?php include 'menuHead.php'; ?>
	</head>
<body bgcolor="white">
	<?php include 'menu.php'; ?>
	</br></br>
	<div class="container">
	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center"><font size="4">
		<div style="width:92%; height:50%; text-align: justify; text-justify: inter-word;" class="card-content white-text">
			<table><tr><td>
			<img hspace="14" src="./img/logo-trasparente.jpg"></BR>
			</td><td valign="top">
			RiCibo vuole essere di aiuto alle associazioni, ai negozianti e ai volontari che sono attivi nella lotta allo spreco di cibo o intendono diventarlo.
			</td></tr>
			</table>
			Il servizio si pu&ograve; attivare in aree distinte cos&igrave; da raggruppare negozi e associazioni vicine per ottimizzare i km da percorrere.</BR>
			Questa attivazione &egrave; fatta da un'associazione che diventa la responsabile dell'area.</BR>
			All'interno delle aree che si creano, si possono registrare i negozianti che vogliono donare, i volontari disponibili al trasporto e le associazioni che beneficiano del cibo raccolto.</BR></BR>
			<div style="margin-left: 8%;">
				<a href="ISA\ISA.php"><font color="#FFFF66"><U>VOTA IL NUOVO LOGO CREATO DAGLI STUDENTI DEL LICEO NANNI VALENTINI</U></font></a></BR></BR>
				<a href="info-aree.php"><font color="#FFFF66"><U>MAPPA ED ELENCO DELLE AREE ATTIVE</U></font></a></BR></BR>
				<a href="visual-volontari.php"><font color="#FFFF66"><U>MAPPA DEI COMUNI CON I VOLONTARI REGISTRATI</U></font></a></BR></BR>
<?php if (!isset($_SESSION['USER'])) { // CHECK SE L'UTENTE E' LOGGATO ?>
				<a href="registrazioni.php"><font color="#FFFF66"><U>REGISTRATI !</U></font></a>
<?php } ?>
			</div>
		</div>
 	</font>
	</div>
	</div>
	</div>
	</br>
</body>
</html>
