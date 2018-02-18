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
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY
  numero INT NOT NULL,
  voti_artistici_ricevuti INT NOT NULL,
  voti_comunicativi_ricevuti INT NOT NULL,
  voti_adattabili_ricevuti INT NOT NULL
);


*/
include '../funzioni/oDBConn.php';

$codUscita = oDBConn();
if (is_numeric($codUscita)){
	if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
	elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
}
else{//il database è connesso
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
				echo 'votazione andata a buon fine. clicca sul link inviato al tuo indirizzo mail per completare<br>';
				echo "contenuto mail: $codiceConferma $voto0 $voto1 $voto2";
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
				echo 'mail gia utilizzata ma non verificata <br> reinvia mail di conferma';
			}else{
				echo 'mail gia utilizzata';
			}
			
		}
	//caso 2: la pagina riceve i dati get da se stessa che chiedono il rinivio della mail
	}else if(isset($_GET['resend'])){
		$email = filter_var($_GET['resend'], FILTER_SANITIZE_EMAIL);
		$email = $db->real_escape_string($email);
		//TODO
		echo 'ok, mail reinviata';
	}
	//caso 3: la pagina non riceve nessun dato -> reindirizzamento a anteprime.php
	else{
		header("location: anteprime.php");
	}

}

/* $controlloMail = mysqli_query('SELECT * FROM CONCORSOLOGO_VOTANTI WHERE email='.$email);
//generare casualmente l ID
$ID = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
//aggiungere il nome della pagina che salvera i dati dopo la conferma mail
$linkDiConferma = 'conferma.php?ID='.$ID;
//inserire i vari valori appena si ricevono i dati del server
$nomeMittente = 'Ricibo';
$emailMittente = 'email@server.com';
$emailOggetto = 'Conferma voto del logo ricibo';
$emailCorpo = 'Per confermare il tuo voto clicca sul seguente link: '.$linkDiConferma;
$emailHeader = 'From: '.$nomeMittente.' <' .  $mailMittente . '>\r\n Reply-To: ' .  $mailMittente . '\r\n X-Mailer: PHP/' . phpversion(); */
?>
