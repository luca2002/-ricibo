<?php
// TEST SE LA SESSION() E' ATTIVA ALTRIMENTI LA ISTANZIO
$bSession = false;
if (php_sapi_name() !== 'cli') {
	if (version_compare(phpversion(), '5.4.0', '>=') ) {
		$bSession = (session_status() == PHP_SESSION_ACTIVE);
		//echo ("session_status() >" . session_status() . "<</BR>");
	} else {
		$bSession = (session_id() != '');
		//echo ("session_id() >" . session_id() . "<</BR>");
	}
}
if (!$bSession) { session_start(); }
// VARIABILE DI SESSIONE CHE INDICA SE SIAMO IN SVILUPPO O PRODUZIONE E SE ATTIVARE IL DEBUG PER LA STAMPA DEI MESSAGGI
$bSviluppo = false;
$NomeFile=$_SERVER['SCRIPT_NAME'];
//echo("SCRIPT_NAME >$NomeFile<</BR>"); 
if (strlen($NomeFile)>8) {
/*
	$bSviluppo = (substr($NomeFile, 0, 9) == "/~ricibo/");
	if ($bSviluppo) {
		$PATH = "/~ricibo";
	} else {
		$PATH = "/~ricibo-prod";
	}
*/
	if (substr($NomeFile, 0, 9) == "/~ricibo/") {
		$bSviluppo = true;
		$PATH = "/~ricibo";
	} else if (substr($NomeFile, 0, 9) == "/~ricibo0") {
		$bSviluppo = true;
		$PATH = substr($NomeFile, 0, 10);
	} else if (substr($NomeFile, 0, 9) == "/~ricibo1") {
		$bSviluppo = true;
		$PATH = substr($NomeFile, 0, 10);
	} else if (substr($NomeFile, 0, 9) == "/~ricibo2") {
		$bSviluppo = true;
		$PATH = substr($NomeFile, 0, 10);
	} else if (substr($NomeFile, 0, 9) == "/~ricibo3") {
		$bSviluppo = true;
		$PATH = substr($NomeFile, 0, 10);
	} else if (substr($NomeFile, 0, 10) == "/~ricibo-p") {
		$bSviluppo = false;
		$PATH = "/~ricibo-prod";
	}
}
$_SESSION['PATH'] = $PATH;
$_SESSION['FLAG_SVILUPPO'] = $bSviluppo;
?>
<title> RiCibo </title>
<link rel="shortcut icon" href="<?php echo $_SESSION['PATH'];?>/img/favicon.ico" />
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="<?php echo $_SESSION['PATH'];?>/css/materialize.css"  media="screen,projection"/>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo $_SESSION['PATH'];?>/js/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo $_SESSION['PATH'];?>/js/init.js"></script>
<!--script type="text/javascript" src="/~ricibo/js/materialize.min.js"></script-->
<!--script type="text/javascript" src="/~ricibo/js/init.js"></script-->
