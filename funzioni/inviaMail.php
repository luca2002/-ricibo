<?php
//questa funzione utilizza il servizio messo a disposizione da ltsweb /ricibo per inviare una mail.
function inviaMail($MITTENTE,$DESTINATARIO,$SOGGETTO,$TESTO) {

	//------------- codice copiato da invio-mail.php		
	$i = date("w");
	if ($i==6) { $i=0; } else { $i++; }
	$sCod = "S" . chr(65+date("n")) . chr(65+date("j")) . chr(65+$i);
	//-------------

	$sPar="C=$sCod&M=$MITTENTE&D=$DESTINATARIO&S=$SOGGETTO&T=$TESTO";
	if (strlen($sPar) > 2048) { $sPar=substr($sPar, 0, 2048); }		
	$url = "http://www.ltsweb.it/RiCibo/RiCibo-invio.asp?". $sPar;
	
	//TODO: controllare il supporto di curl sul server di produzione. 
	//temporaneamente file get contents dovrebbe sostituire in parte la funione
	$response = file_get_contents($url);
	return $response;
}
?>
