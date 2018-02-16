<?php
session_start();
// if (isset($_SESSION["ID_USER"])) { echo ("SI</BR>"); } else  { echo ("NO</BR>"); }
// if (isset($_SESSION["FLAG_REG"])) { echo ("SI</BR>"); } else  { echo ("NO</BR>"); }
// echo ($_SESSION["ID_USER"] . "<</br>");
// echo ($_SESSION["FLAG_REG"] . "<</br>");
// SE L'UTENTE E' LOGGATO, LO RIDIREZIONI SULL'INDEX PER UTENTI
if (isset($_SESSION["ID_USER"])) {
	if ($_SESSION["ID_USER"] != "") { header("location: indexlog.php"); }
}
?>
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
	<div class="card light-blue darken-2" align="center">
		<div class="card-content white-text">
			<a href="info-aree.php"><font color="white">
				<span class="card-title">Aree</span></font></BR><font color="#FFFF66"><U>
				Attivazione di una nuova area (solo per associazioni) e visione della mappa con l'elenco delle aree in cui il servizio &egrave; attivo.</U></font>
			</a></BR>
		</div>
		<a href="registr/user.php?T=R"><font color="#FFFF66"><U>ATTIVA SUBITO UNA NUOVA AREA</U></font></a>
 	</div>
	<div>
	<div class="col s12 m6">
 	<div class="card light-blue darken-2" align="center">
 	<div class="card-content white-text">
		<a href="info-negozianti.php"><font color="white">
			<span class="card-title">Negozianti</span></font></BR><font color="#FFFF66"><U>
			Dona il tuo cibo invenduto, aiuterai le associazioni caritatevoli e potresti avere una riduzione sulla tassazione locale, la TARI, se prevista dal tuo comune. (clicca per pi&ugrave; informazioni)</U>
		</font></a></div>
		<!--v class="card-action" align="center"-->
		<a href="registr/user.php?T=N"><font color="#FFFF66"><U>REGISTRATI COME NEGOZIANTE</U></font></a>
 		<!--/div-->
 	</div>
	<div>
	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center">
		<div class="card-content white-text">
		<a href="info-volontari.php"><font color="white">
			<span class="card-title">Volontari</span></font></BR><font color="#FFFF66"><U>
			Aiutaci a trasportare il cibo alle associazioni riceventi. (clicca per pi&ugrave; informazioni)</U>
		</font></a></div>
		<!--v class="card-action" align="center"-->
		<a href="registr/user.php?T=V"><font color="#FFFF66"><U>REGISTRATI COME VOLONTARIO</U></font></a>
		<!--/div-->
 	</div>
 	</div>
 	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center">
		<a href="info-associazioni.php"><font color="white">
			<div class="card-content white-text">
			<span class="card-title">Associazioni</span></font></BR><font color="#FFFF66"><U>
			Associazioni o enti benefici che usufruiscono del cibo donato. (clicca per pi&ugrave; informazioni)
		</font></a></div>
		<!--v class="card-action" align="center"-->
		<a href="registr/user.php?T=A"><font color="#FFFF66"><U>REGISTRATI COME ASSOCIAZIONE</U></font></a>
 		<!--/div-->
 	</div>
 	</div>
	</div>
</body>
</html>
