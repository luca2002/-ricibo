<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
<body bgcolor="white">
<?php include "../menu.php"; ?>
	</BR></BR>
	<div class="container"></BR></BR>
<?php if($_SESSION['FLAG_PERSONA'] != 'V') { ?>
	La registrazione non &egrave; ancora completa, ricever&agrave; una mail appena pronte le successive pagine di registrazione.</BR>
	Grazie per la registrazione.
<?php } else { ?>
	Registrazione completata!</BR>Siamo in fase di test dell'app, appena pronta per il rilascio, ricever&agrave; una mail con un link per scaricarla sul suo smartphone.</BR>
<?php } ?>
	</div>
</body>
</html>
