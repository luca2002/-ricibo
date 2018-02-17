<?php
function sAccodaMail($Destinatario, $Soggetto, $Testo,$db) {
// PARAM: mail-destinatario, Soggetto-mail, testo-mail con codifica numerica
// VUOLE LA CONNESSIONE AL DB APERTA
// L'INVIO MAIL DAL SITO LTSWEB HA UN LIMITE DEI 4 CAMPI DI CIRCA 2000 CARATTERI, LIMITARE I TESTI
// ATTENZIONE!!! AI CARATTERI CHE SI SCRIVONO NELLA MAIL, SE NON VIENE SPEDITA, MOLTO PROBABILMENTE E' PER QUELLO

$ID_USER=$_SESSION['ID_USER'];
$Mittente = "ricibo@hensemberger.it";
switch ($Testo) {
case '0':	// MAIL PER CONFERMA REGISTRAZIONE
	// echo ("caso $Testo</BR>");
	$Soggetto = "Ricibo - Conferma di registrazione";
	$Testo = "La preghiamo di confermare la propria registrazione aprendo il seguente link:  http://www.hensemberger.it/";
	if ($_SESSION['FLAG_SVILUPPO']) { $Testo = $Testo . "~"; }
	$Testo = $Testo . "ricibo/registr/check_registr.php?ID=$ID_USER";
	break;
case '1':	// REGISTRAZIONE COMPLETATA PER NEG/ASS O PER VOLONTARI E INVIO LINK DOWNLOAD APP
	// echo ("caso $Testo</BR>");
	$Soggetto = "Ricibo - Avvenuta di registrazione";
/*
	if ($_SESSION['FLAG_PERSONA'] == 'V') {
		$Testo = "Le confermiamo la registrazione a RiCibo. Accedendo al sito potra' modificare i propri dati inseriti in fase di registrazione e dalla sezione download scaricare l'app  http://www.hensemberger.it/";
		
	} else {}
*/
	$Testo = "Le confermiamo la registrazione a RiCibo. Accedendo al sito potra\' modificare i propri dati inseriti in fase di registrazione   http://www.hensemberger.it/";
	if ($_SESSION['FLAG_SVILUPPO']) { $Testo = $Testo . "~"; }
	$Testo = $Testo . "ricibo";
	break;
}
$sql = "INSERT INTO TB_MAIL_INVIATE(MITTENTE, DESTINATARIO, SOGGETTO, TESTO) VALUES ('$Mittente', '$Destinatario', '$Soggetto', '$Testo');
";
// echo "</br> Mittente >" . $Mittente . "<</br>";
// echo "</br> Destinatario >" . $Destinatario . "<</br>";
// echo "</br> Soggetto >" . $Soggetto . "<</br>";
// echo "</br> Testo >" . $Testo . "<</br>";
// echo "</br> sql >" . $sql . "<</br>";
$result = mysqli_query($db,$sql);
}
?>
