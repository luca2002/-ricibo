<?php
require '../funzioni/oDBConn.php';
//verifico se è presente l id
if (isset($_GET['id'])){
	//verifico se l id è un int
	$verifica = filter_var($_GET['id'],FILTER_VALIDATE_INT);
	if(!$verifica){
		$codUscita = 2;
	}
	else {
		//stabilisco la connessione con il db
		$codUscita = oDBConn();
		$db = $codUscita;
		$sql='SELECT * FROM concorsologo_votanti where codice_conferma='.$_GET['id'];
		//cerco voti in sospeso dove codice_conferma == id 
		$cerca = mysqli_query($db,$sql);
		if (mysqli_num_rows($cerca) == 1){
			$dati_voto = mysqli_fetch_assoc($cerca);
			//verifichiamo se è stato verificato o meno
			if($dati_voto['verificato'] == 0){
				//salvo tutti i voti e metto verificato al campo verifica concorsologo_concorrenti
				$sql = 'UPDATE concorsologo_concorrenti SET voti_artistici_ricevuti = voti_artistici_ricevuti+1 WHERE  id ='.$dati_voto['voto_artistico'].'; UPDATE concorsologo_concorrenti SET voti_comunicativi_ricevuti = voti_comunicativi_ricevuti+1 WHERE id ='.$dati_voto['voto_comunicativo'].'; UPDATE concorsologo_concorrenti SET voti_adattabili_ricevuti = voti_adattabili_ricevuti+1 WHERE id ='.$dati_voto['voto_adattabile'].'; UPDATE concorsologo_votanti SET verificato = 1 WHERE codice_conferma='.$_GET['id'].';';																																																		
				$result = mysqli_multi_query($db,$sql);
				if (!$result){$codUscita = 5;}
				else{$codUscita = 6;}
			}
			else{
				$codUscita = 4;
			}
		}
		else{
			$codUscita = 3;
		}
	}
}
else{$codUscita = 1;}
/*qui ho predisposto uno switch per i vari testi da scrivere nei vari casi se vuoi toglilo e aggiungi i vari avvisi come piu preferisci ;)
i significati dei cod uscita sono subito dopo. */
switch($codUscita){
	case 1:
		$testo = '';
		break;
	case 2:
		$testo = '';
		break;
	case 3:
		$testo = '';
		break;
	case 4:
		$testo = '';
		break;
	case 5:
		$testo = '';
		break;
	case 6:
		$testo = '';
		break;
	default:
		$testo = '';
		break;

}
/*enciclopedia codUscita:
1:errore nessun id presente.
2:errore id non di tipo int.
3:l'id inserito non da risultati quindi è falso.
4:votazione gia confermata.
5:errore nel salvataggio del voto
6:votazione terminata con successo.
*/
?>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
		<link href="resources/style.css" rel="stylesheet" />
		<script src="resources/main.js"></script>
	</head>
	<body bgcolor="#f0f0f0">
		<?php include '../menu.php'; ?>
	</br></br>
	<?php
	echo $testo;
	?>
	</body>
</html>