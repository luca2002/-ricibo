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
	

  <!-- Modal Structure -->
  <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <p id="inner-description"> caricamento.. </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">chiudi</a>
      <a href="#!" class="waves-effect waves-green btn-flat ">vota</a>
    </div>
  </div>
	
	<div class="descrizione">
		<h2>votazione dei loghi</h2>
		<p>clicca su un logo per visualizzarne la descrizione o esprimerne un voto.</p>
		<p>è possibile votare fino a 3 immagini</p>
	</div>
	
  
<div class="c-container">
<div class="c-cards">	
<?php
//inserisce tutti i loghi presenti nella cartella img nell'html
$output = '';
//i loghi sono attualmente 20	
for($i=1;$i<=20;$i++){
	
	$url = 'img/'.sprintf("%02d", $i).'-logo.png';
	$autore = 'mario rossi';
	$descrizioneBreve = 'clicca per visualizzare la descrizione o per votare';
	//importante: file contententi apostrofi buggano la stringa quando viene eseguita da js.
	$descrizione = file_get_contents('img/'.sprintf("%02d", $i).'-logo.txt');
	$descrizione = json_encode(utf8_encode($descrizione));
    if ($descrizione === false || $descrizione == '') {
        $descrizione = 'nessuna descrizione trovata';
    }
	
	$output .=  "<a class='c-card' onclick='opencard(".$i.",".$descrizione.")'>".
			'<span class="card-header" style="background-image: url('.$url.');">'.
				'</span><span class="card-summary">'.
					'<span class="card-author">autore:'.$autore.'</span>'.
					'<i>'.$descrizioneBreve.'</i>'.
				//'<br></span><span class="card-meta">clicca per votare</span></a>';temporaneamente rimosso per conflitto con materialize
				'<br></span></a>';			
}
echo $output;
?>
		<a class="c-card" onclick="">
			<span class="card-header" style="background-image: url();">
			</span>
			<span class="card-summary">
				<span class="card-author">autore: nome cognome perona</span>
				<i>
					card aggiunta solo per simmetria. qweqweqweqweqweqwe
				</i>
				<br>
			</span>
		</a>
		
</div></div>
	
</body>
</html>
