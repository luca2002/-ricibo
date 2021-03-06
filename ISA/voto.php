<!DOCTYPE html>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
	</head>
	<body bgcolor="#f0f0f0">
		<?php include '../menu.php'; ?>
		</br></br>
		<div class="container" style="text-align:center">
        <!-- Page Content goes here -->

<?php

/*
per creare la tabella necessaria alle votazioni:

CREATE TABLE IF NOT EXISTS CONCORSOLOGO_VOTANTI (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email varchar(60) NOT NULL,
  voto_artistico int(3) DEFAULT NULL,
  voto_comunicativo int(3) DEFAULT NULL,
  voto_adattabile int(3) DEFAULT NULL,
  verificato int NOT NULL,
  codice_conferma varchar(60) NOT NULL
);

CREATE TABLE IF NOT EXISTS CONCORSOLOGO_CONCORRENTI (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  voti_artistici_ricevuti INT NOT NULL,
  voti_comunicativi_ricevuti INT NOT NULL,
  voti_adattabili_ricevuti INT NOT NULL
);

INSERT INTO concorsologo_concorrenti (voti_artistici_ricevuti,voti_comunicativi_ricevuti,voti_adattabili_ricevuti) VALUES (0,0,0);



*/
include '../funzioni/oDBConn.php';
include '../funzioni/inviaMail.php';

$codUscita = oDBConn();
	$db = $codUscita;
	
	//caso 1: la pagina riceve i dati della votazione, inviati da anteprime.php
	if(isset($_POST['email']) && isset($_POST['voto0']) && isset($_POST['voto1']) && isset($_POST['voto2']) ){
		//sanitizza l'email
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$email = $db->real_escape_string($email);
		//verifica se è presente la mail nel database
		$mailControllata = mysqli_query($db,"SELECT verificato FROM concorsologo_votanti WHERE email='$email'");
		if(mysqli_num_rows($mailControllata) == 0){//la mail non è presente nel database, si può aggiungere.
			//sanitizza gli altri input
			$options = array("options" => array("min_range"=>1, "max_range"=>22));
			$voto0 = filter_var($_POST['voto0'], FILTER_VALIDATE_INT,$options);
			$voto1 = filter_var($_POST['voto1'], FILTER_VALIDATE_INT,$options);
			$voto2 = filter_var($_POST['voto2'], FILTER_VALIDATE_INT,$options);
			//genera il codice di conferma di otto cifre
			$codiceConferma = rand(1,9);
			for($i=0; $i<7; $i++) {
				$codiceConferma .= rand(0,9);
			}
			$query = "INSERT INTO concorsologo_votanti ( email,voto_artistico,voto_comunicativo,voto_adattabile,verificato,codice_conferma ) VALUES ( '$email','$voto0','$voto1','$voto2','0','$codiceConferma' )";
			if(mysqli_query($db,$query)){
				echo '<h5>grazie per aver votato</h5>';
				echo '<p>clicca sul link inviato al tuo indirizzo mail per confermare il voto.</p>';
				echo '<p>se non hai ricevuto nessuna mail, controlla nella cartella spam oppure premi reinvia email</p>';
				echo '<p><a href="voto.php?resend='.$email.'">reinvia mail</a> <br> <a href="anteprime.php">indietro</a> </p>';
				//TODO: invio mail
				echo $codiceConferma;//debug
			}else{
				echo 'errore durante la registrazione del tuo voto';
			}

		}else{
			//controlla se la mail esistente è stata verificata
			//$verificato = mysqli_result($db,$mailControllata,0);
			while($row = mysqli_fetch_assoc($mailControllata)) {
				$verificato = $row['verificato'];
			}
			if($verificato == 0){
				echo '<h4>mail già utilizzata ma non verificata.</h4>';
				echo '<p>Clicca sul link che abbiamo mandato alla tua mail al momento della votazione per confermare la tua identità.</p>';
				echo '<p>se non hai ricevuto nessuna mail, controlla nella cartella spam o premi reinvia mail</p>';
				echo '<p><a href="voto.php?resend='.$email.'">reinvia mail</a> <br> <a href="anteprime.php">indietro</a> </p>';
			}else{
				echo '<h4>mail già utilizzata</h4>';
				echo '<p><a href="anteprime.php">indietro</a> </p>';
			}
			
		}
	//caso 2: la pagina riceve i dati get da se stessa che chiedono il rinivio della mail
	}else if(isset($_GET['resend'])){
		//sanitizza l'input
		$email = filter_var($_GET['resend'], FILTER_SANITIZE_EMAIL);
		$email = $db->real_escape_string($email);
		//controlla se effettivamente la mail esiste e non è verificata
		$controllo = mysqli_query($db,"SELECT verificato FROM concorsologo_votanti WHERE email='$email'");
		$verificato = 1;
		if(mysqli_num_rows($controllo) > 0){//la mail esiste
			while($row = mysqli_fetch_assoc($controllo)) {
				$verificato = $row['verificato'];
			}
			if($verificato == 0){//la mail non è registrata
				//genera il codice di conferma di otto cifre
				$codiceConferma = rand(1,9);
				for($i=0; $i<7; $i++) {
					$codiceConferma .= rand(0,9);
				}
				//aggiorna il codice di conferma nel db
				$query = "UPDATE concorsologo_votanti SET codice_conferma = '$codiceConferma' WHERE concorsologo_votanti.email = '$email'";
				if(mysqli_query($db,$query)){
					echo '<h4>mail reinviata</h4>';
					echo '<p>se non hai ricevuto nessuna mail, controlla nella cartella spam</p>';
					//TODO: invio mail
					echo $codiceConferma;//debug
				}else{
					echo 'errore durante il reinvio della mail';
				}	
			}else{
				echo 'votazione già confermata';
			}
		}else{
			echo 'mail non trovata';
		}
	}
	//caso 3: la pagina non riceve nessun dato -> reindirizzamento a anteprime.php
	else{
		header("location: anteprime.php");
	}


?>
      </div>
	</body>
</html>
