<?php
/*
pagina che riceve in get l'id associato ad una votazione nel db.
se esiste convferma la votazione fatta in precedenza.
*/



require '../funzioni/oDBConn.php';

//testo di default
$testo = '<h4>errore</h4><p>id non valido</p>';

//verifico se è presente l id
if (isset($_GET['id'])){
	//verifico se l id è un int
	$verifica = filter_var($_GET['id'],FILTER_VALIDATE_INT);
	if($verifica){
		//stabilisco la connessione con il db
		$codUscita = oDBConn();
		$db = $codUscita;
		//sanitizzazione. non dovrebbe servire, ma non si sa mai
		$verifica = $db->real_escape_string($verifica);
		$sql="

		UPDATE
			concorsologo_concorrenti,
			concorsologo_votanti
		SET
			concorsologo_concorrenti.voti_artistici_ricevuti = concorsologo_concorrenti.voti_artistici_ricevuti+1
		WHERE
			concorsologo_concorrenti.id = concorsologo_votanti.voto_artistico
			AND concorsologo_votanti.codice_conferma = '$verifica'
			AND concorsologo_votanti.verificato = 0;
			



		UPDATE
			concorsologo_concorrenti,
			concorsologo_votanti
		SET
			concorsologo_concorrenti.voti_comunicativi_ricevuti = concorsologo_concorrenti.voti_comunicativi_ricevuti+1
		WHERE
			concorsologo_concorrenti.id = concorsologo_votanti.voto_comunicativo
			AND concorsologo_votanti.codice_conferma = '$verifica'
			AND concorsologo_votanti.verificato = 0;
			
			
			
		UPDATE
			concorsologo_concorrenti,
			concorsologo_votanti
		SET
			concorsologo_concorrenti.voti_adattabili_ricevuti = concorsologo_concorrenti.voti_adattabili_ricevuti+1
		WHERE
			concorsologo_concorrenti.id = concorsologo_votanti.voto_adattabile
			AND concorsologo_votanti.codice_conferma = '$verifica'
			AND concorsologo_votanti.verificato = 0;

		SELECT verificato FROM concorsologo_votanti WHERE codice_conferma = '$verifica';
			
		UPDATE
			concorsologo_votanti
		SET
			verificato = 1
		WHERE
			codice_conferma = '$verifica'
			AND verificato = 0

		";
		//prova ad eseguire la query
		$operazione = mysqli_multi_query($db,$sql);

		if($operazione){
			//ottiene tutti i risultati della multiquery
			do{
				//memorizza primo risultato
				if ($result = mysqli_store_result($db)) {
				   while ($row = mysqli_fetch_row($result)) {
						$verificato = $row[0];
						if($verificato == 0){
							$testo = '<h4>votazione completata</h4><p>grazie per aver partecipato</p>';
						}else if($verificato = 1){
							$testo = '<h4>votazione già completata</h4><p>grazie per aver partecipato</p>';
						}
					}
				   mysqli_free_result($result);
			   }
			}while(mysqli_next_result($db));
		}
		
		
		
	}
}

?>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
	</head>
	<body bgcolor="#f0f0f0">
		<?php include '../menu.php'; ?>
	</br></br>
		<div class="container" style="text-align:center">
	<?php
	echo $testo;
	?>
		</div>
	</body>
</html>