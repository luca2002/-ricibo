<html>
<head>
	<?php include 'menuHead.php'; ?>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCVAsE3l5qdpdF-Sm3zHZN9-Cf6NsxP9aQ"></script>
<?php
	include "funzioni/oDBConn.php"; 
	include "funzioni/FunctionsMaps.php"; 
	$codUscita = 0;
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) { 
		if ($codUscita == 1 ) { echo("</br>Errore: connessione al DB fallita."); }
		elseif ($codUscita == 2 ) { echo("</br>Errore: DB non trovato."); }
	} else {
		// SE TUTTO OK, SALVO LA CONNESSIONE AL DB
		$db = $codUscita;
		$codUscita = 0;
		sMap1(1, -1);
	}
?></head>
<body bgcolor="white">
<?php include 'menu.php'; ?></br></br>
<div class="container">	
	<div class="row">
	<div class="col s12">
	<div class="card light-blue darken-2">
	<div class="card-content white-text" align="center">
	
	<div id="squadre" align="center">
	<?php sMap2(1); ?>
	</div>
	<?php
	if ($codUscita == 0) {
		// SELECT DEI CONTEGGI DELLE REGISTRAZIONI AL SITO X TUTTE LE AREE
		$sql = "SELECT A.*, IFNULL(CONT_NEG, 0) AS CONT_NEG, IFNULL(CONT_ASS, 0) AS CONT_ASS, IFNULL(CONT_VOL, 0) AS CONT_VOL  FROM TB_AREA A 
		LEFT JOIN (SELECT ID_AREA, COUNT(*) AS CONT_NEG FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS='N') NE ON (A.ID_AREA=NE.ID_AREA)
		LEFT JOIN (SELECT ID_AREA, COUNT(*) AS CONT_ASS FROM TB_NEG_ASS WHERE FLAG_AREA_NEG_ASS='A') NA ON (A.ID_AREA=NA.ID_AREA)
		LEFT JOIN (SELECT U.ID_AREA, COUNT(*) AS CONT_VOL FROM TB_USER U LEFT JOIN TB_PERSONA P ON (P.ID_PERSONA=U.ID_PERSONA) WHERE FLAG_PERSONA='V') VE ON (A.ID_AREA=VE.ID_AREA)
		ORDER BY A.NAZIONE, A.PROV, A.CAP, A.ASSOC_SIGLA";
// echo ("</br>sql>" . $sql);
		$risultato_query = @mysqli_query($sql, $db);
		if (!$risultato_query) {	
			// echo 'Non riesco a prendere i dati';
			$descr="NON SONO STATE TROVATE AREE ATTIVE";
			$cont_neg=0;
			$cont_ass=0;
			$cont_vol=0;
		} else {
			$i=0;
			while ($riga=mysql_fetch_array($risultato_query)) {
				$ID_AREA=$riga['ID_AREA'];
				$ASS = $riga['ASSOC_SIGLA'] . " - " . $riga['COMUNE'] . " - " . $riga['PROV'] ;
				$descr=$riga['DESCR'];
				$cont_neg=$riga['CONT_NEG'];
				$cont_ass=$riga['CONT_ASS'];
				$cont_vol=$riga['CONT_VOL'];
				$cont=$cont_neg+$cont_ass+$cont_vol;
				$i++;
// echo ("$ASS - cont: " . $cont . "<</BR>");
?></BR>
		<?php // if ($i>1) { echo "<hr size=\"95%\">"; }
			echo "<hr size=\"95%\">";		?>
		<span class="card-title"><?php echo $ASS ?></BR></span>
		<?php echo $descr; ?> </BR>
		<a href="registr/user.php?A=<?php echo $ID_AREA; ?>"><font color="white"><B>REGISTRARTI IN QUESTA AREA</B></font></a>
		<div class="card-action">
<?php	if (($cont_neg>0) && ($cont_vol>0) && ($cont_ass>0)) { ?>
			<div class="col s4"><span class="card-title">Negozianti:<?php echo $cont_neg; ?></div>
			<div class="col s4"><span class="card-title">Volontari:<?php echo $cont_vol; ?></div>
			<div class="col s4"><span class="card-title">Associazioni:<?php echo $cont_ass; ?></div>
<?php	} else { ?>
		<div class="col s12"><span class="card-title">Servizio in via di attivazione <font size="-1">
<?php if ($cont > 0) { if ($cont == 1) { echo(" (1 registrazione)"); } else { echo(" ($cont registrazioni)"); }} ?></font></span></div>
<?php	} 
	if (($cont_neg > 0) AND ($cont_ass)) { ?>
		<a href="visual-area.php?ID=<?php echo $ID_AREA; ?>"><font color="white"><B>VISUALIZZA LA MAPPA CON NEGOZI E ASSOCIAZIONI PER: <?php echo $ASS; ?></B></font></a>
<?php } ?></BR>
		</div>
<?php
			} // FINE CICLO WHILE
		} // FINE ELSE
		mysqli_close($db);
	} // FINE PRIMO IF
?>	</div>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
