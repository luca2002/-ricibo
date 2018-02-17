<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
		<link href="resources/style.css" rel="stylesheet" />
		<script src="resources/main.js"></script>
	</head>
<body bgcolor="#f0f0f0">
	<?php include '../menu.php'; ?>
	</br></br>
	

  <!-- Modalbox descrizione -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <p id="inner-description"> caricamento.. </p>
    </div>
	
    <div class="modal-footer">
      <a class="modal-action modal-close waves-effect waves-green btn-flat ">chiudi</a>
    </div>
  </div>
  
  
  <!-- Modalbox voto -->
  <div id="modal2" class="modal modal-fixed-footer">
    <div class="modal-content">
		<h5>valore estetico ed artistico</h5>
		<a onclick="vote(0)" class="waves-effect waves-red btn vote-bt">vota</a>
<h5>efficacia comunicativa</h5>
		<a onclick="vote(1)" class="waves-effect waves-red btn vote-bt">vota</a>
<h5>adattabilità e facilità di riproduzione</h5>
		<a onclick="vote(2)" class="waves-effect waves-red btn vote-bt">vota</a>

    </div>
	
    <div class="modal-footer">
      <a class="modal-action modal-close waves-effect waves-green btn-flat ">chiudi</a>
    </div>
  </div>
  
	
	<div class="descrizione">
		<h2>votazione dei loghi</h2>
		<p>È possibile votare un immagine per ciascuna delle seguenti categorie:	
			<div class="chip">valore estetico ed artistico</div>
			<div class="chip">efficacia comunicativa</div>
			<div class="chip">adattabilità e facilità di riproduzione</div>
 		</p>
		<p>una volta terminato, inserisci la tua mail e clicca invia per confermare la votazione</p>
				<div class="input-field inline">
            <input id="email" type="email" class="validate">
            <label for="email" data-error="wrong" data-success="right">Email</label>
		</div>
		<a class="waves-effect waves-light btn" onclick="sendForm()" id="send-bt"><i class="material-icons right">send</i>invia</a>
    </div>
		
	</div>
  
<div class="c-container">
<div class="c-cards">	
<?php
//inserisce tutti i loghi presenti nella cartella img nell'html
$output = '';
//i loghi sono attualmente 20	
for($i=1;$i<=22;$i++){
	
	$url = 'img/'.sprintf("%02d", $i).'-logo.png';
	$autore = 'mario rossi';
	//importante: file contententi apostrofi buggano la stringa quando viene eseguita da js.
	$descrizione = file_get_contents('img/'.sprintf("%02d", $i).'-logo.txt');
	$descrizione = json_encode(utf8_encode($descrizione));
    if ($descrizione === false || $descrizione == '') {
        $descrizione = 'nessuna descrizione trovata';
    }
	
	$output .=  '<div class="c-card" id="c-card-'.$i.'">'.
					'<span class="card-header" style="background-image: url('.$url.');"></span>'.
					'<span class="card-summary">'.
						//'<span class="card-author">autore:'.$autore.'</span>'.
					'<a onclick="openVote('.$i.')" class="waves-effect waves-red btn-flat "> vota </a> '.
					"<a onclick='openDescr(".$i.",".$descrizione.")' class='waves-effect waves-light btn-flat'>descrizione</a>".
						//'<br></span><span class="card-meta">clicca per votare</span></a>';temporaneamente rimosso per conflitto con materialize
				'<br></span></div>';
}
echo $output;
?>
		
</div></div>
	
</body>
</html>
