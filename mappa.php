<!DOCTYPE html>
<?php
session_start();
?>
<html>
	<head>
		<?php include 'menuHead.php'; ?>
	</head>
<body bgcolor="white">
	<?php include 'menu.php'; ?>
	</br></br>
	<div class="container">
		<H1>Mappa del Sito</H1>
	<table>
	<tr>
	<td>&nbsp;</td>
	<td>Le pagine non linkate richiedo il login o l'accesso da un'altra pagina.
	<ul>
		<li><a href="index.php"><U>Home</U></a></li>
		<ol>
			<li><a href="ISA/ISA.php"><U>Regolamento per il concorso per trovare il nuovo logo del sito.</U></a></li>
			<li><a href="ISA/anteprime.php"><U>Anteprima dei lavori realizzati dal liceo artistico Nanni Valentini.</U></a></li>
			<li><a href="info-aree.php"><U>Aree attive (con la mappa di visualizzazione).</U></a></li>
			<ol>
				<li>Visualizzazione di un'area con negozi e associazioni registrate.</li>
			</ol>
			<li><a href="visual-volontari.php"><U>Mappa dei comuni con volontari registrati.</U></a></li>
		</ol>
		<li><a href="chisiamo.php"><U>Chi siamo</U></a></li>
		<li><a href="cosafacciamo.php"><U>Mission</U></a></li>
		<li><a href="registrazioni.php"><U>Registrati!</U></a></li>
		<ol>
			<li><a href="info-negozianti.php"><U>Negozianti informazioni</U></a></li>
			<li><a href="registr/user.php?T=N"><U>Negozianti registrazione</U></a></li>
			<li><a href="info-associazioni.php"><U>Volontari informazioni</U></a></li>
			<li><a href="registr/user.php?T=V"><U>Volontari registrazione</U></a></li>
			<li><a href="info-volontari.php"><U>Associazioni informazioni</U></a></li>
			<li><a href="registr/user.php?T=A"><U>Associazioni registrazione</U></a></li>
		</ol>
		<li><a href="mappa.php"><U>Mappa</U></a></li>
		<li><a href="stampa.php"><U>Stampa</U></a></li>
		<li><a href="contattaci.php"><U>Contattaci</U></a></li>
		<li><a href="login.php"><U>Login</U></a></li>
		<ol>
			<li>Negozianti</li>
			<ol>
				<li>Dati persona</li>
				<li>Dati negozio</li>
				<li>Apertura ordinaria</li>
				<li>Chiusure extra</li>
				<li>Aperture extra</li>
				<li>Tipologia cibo donato</li>
				<li>Inserimento giacenza cibo</li>
				<li>Report cibo donato</li>
			</ol>
			<li>Volontari</li>
			<ol>
				<li>Dati persona</li>
			</ol>
			<li>Associazioni</li>
			<ol>
				<li>Dati persona</li>
				<li>Dati associazione</li>
				<li>Apertura ordinaria</li>
				<li>Chiusure extra</li>
				<li>Aperture extra</li>
				<li>Tipologia cibo che si consuma</li>
				<li>Conferma cibo ricevuto</li>
				<li>Report cibo ricevuto</li>
			</ol>
		</ol>
	</ul>
	</td>
	<tr>
	<table>
	</div>
</body>
</html>
