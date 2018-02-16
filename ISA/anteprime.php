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
	
	$output .=  '<a class="c-card" onclick="opencard('.$i.')">'.
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
	<!--
	<div class="container">
	<div class="col s12 m6">
	<div class="card light-blue darken-2" align="center"><font size="4">
		<div style="width:92%; text-align: justify; text-justify: inter-word;" class="card-content white-text">
		<CENTER><H3>Anteprime dei loghi in concorso</H3></CENTER>
		Da Settembre, con la ripresa della scuola, sar&agrave attivata la possibilit&agrave di vedere il logo in dettaglio, leggere la motivazione che ha portato alla sua realizzazione e di esprimere i propri voti.
		<HR size="98%">
		</div>
		<div style="width:92%; text-align: left;" class="card-content white-text">
		<img src="img\01-logo.png" width="188">
		<img src="img\02-logo.png" width="188">
		<img src="img\03-logo.png" width="188">
		<img src="img\04-logo.png" width="188">
		<img src="img\05-logo.png" width="188">
		<img src="img\06-logo.png" width="188">
		<img src="img\07-logo.png" width="188">
		<img src="img\08-logo.png" width="188">
		<img src="img\09-logo.png" width="188">
		<img src="img\10-logo.png" width="188">
		<img src="img\11-logo.png" width="188">
		<img src="img\12-logo.png" width="188">
		<img src="img\13-logo.png" width="188">
		<img src="img\14-logo.png" width="188">
		<img src="img\15-logo.png" width="188">
		<img src="img\16-logo.png" width="188">
		<img src="img\17-logo.png" width="188">
		<img src="img\18-logo.png" width="188">
		<img src="img\19-logo.png" width="188">
		<img src="img\20-logo.png" width="188">
		<img src="img\21-logo.png" width="188">
		<img src="img\22-logo.png" width="188">
		</div>
	</font>
	</div>
	</div>
	</div>
	-->
</body>
</html>
