<?php
function sMap1($Tipo, $ID_AREA) {
// 1 = VISUALIZZAZIONE DI TUTTE LE AREE ATTIVATE
// 2 = VISUALIZZAZIONE DI UN'AREA CON NEGOZI E ASSOCIAZIONI REGISTRATE
// 3 = VISUALIZZAZIONE DEI COMUNI CON I VOLONTARI REGISTRATI

	if ($Tipo == 1) {
		$sql = "SELECT NA.ID_AREA AS ID, NA.COMUNE_SEDE AS NOME, COUNT(*) AS CONT, X.GPS_X, Y.GPS_Y FROM TB_NEG_ASS NA
					LEFT JOIN (SELECT COMUNE_SEDE, AVG(GPS_X) AS GPS_X FROM TB_NEG_ASS WHERE ((GPS_X IS NOT NULL) AND (GPS_X <> 0)) GROUP BY COMUNE_SEDE) X ON (NA.COMUNE_SEDE = X.COMUNE_SEDE)
					LEFT JOIN (SELECT COMUNE_SEDE, AVG(GPS_Y) AS GPS_Y  FROM TB_NEG_ASS WHERE ((GPS_Y IS NOT NULL) AND (GPS_Y <> 0)) GROUP BY COMUNE_SEDE) Y ON (NA.COMUNE_SEDE = Y.COMUNE_SEDE)
				GROUP BY NA.ID_AREA, NA.COMUNE_SEDE ORDER BY NA.COMUNE_SEDE;";
	} elseif ($Tipo == 2) {
		$sql = "SELECT ID_NEG_ASS AS ID, FLAG_AREA_NEG_ASS, NOME, GPS_X, GPS_Y FROM TB_NEG_ASS WHERE ((ID_AREA = $ID_AREA) AND (FLAG_AREA_NEG_ASS IN ('N', 'A'))) ORDER BY FLAG_AREA_NEG_ASS DESC, ID_NEG_ASS;";
	} elseif ($Tipo == 3) {
/*	$sql = "SELECT P.COMUNE_DOM AS NOME, COUNT(*) AS CONT FROM TB_PERSONA P
	LEFT JOIN TB_USER U ON (P.ID_PERSONA = U.ID_PERSONA)
	WHERE (U.FLAG_PERSONA = 'V')
	GROUP BY P.COMUNE_DOM;";*/
		$sql = "SELECT P.COMUNE_DOM AS NOME, COUNT(*) AS CONT FROM TB_PERSONA P
	LEFT JOIN TB_USER U ON (P.ID_PERSONA = U.ID_PERSONA)
	WHERE (U.FLAG_PERSONA = 'V')
	GROUP BY P.COMUNE_DOM ORDER BY COUNT(*) DESC, P.COMUNE_DOM LIMIT 10;";
	} 
//echo "\n sql: $sql</BR>";
	$result = mysql_query($sql);
	// CICLO DI CREAZIONE DEI MAKER DA VISUALIZZARE NELLA MAPPA
	$HTML1 = "";
	$HTML2 = "";
	$max_X = -999;
	$min_X = 999;
	$max_Y = -999;
	$min_Y = 999;
	if ($Tipo == 3) { $HTML1 = "var loc = ["; }

	while ($riga=mysql_fetch_array($result)) {
		$NOME = trim($riga['NOME']);
		if ($Tipo != 3) {
			$GPS_X = $riga['GPS_X'];
			$GPS_Y = $riga['GPS_Y'];
		}
		if (($Tipo == 1) OR ($Tipo == 3)) {
			if ($Tipo == 1) { $ID = $riga['ID']; }
			$NOME = str_ireplace(' ', '_', trim($riga['NOME']));
			$ICONA = "";
			if ($Tipo == 1) { $NOME .= " - " . $riga['CONT'] . " registrazioni"; }
			//else if ($Tipo == 3) { $NOME .= " - " . $riga['CONT'] . " volontari"; }
		} elseif ($Tipo == 2) {
			$ID = $riga['ID'];
			$FLAG = $riga['FLAG_AREA_NEG_ASS'];
			$ICONA = " icon: img$FLAG,";
		}
		if ($Tipo == 3) {
			// $tmp = str_ireplace("- 1 volontari,", "- 1 volontario,", $NOME);
			// $HTML1 .= "\n'$tmp, Italia',"; 
			$HTML1 .= "\n'$NOME, Italia',"; 
		} else {
			$HTML1 .= "var latlng$ID = new google.maps.LatLng($GPS_X,$GPS_Y);\n";
			$HTML2 .= "var marker$ID = new google.maps.Marker({ position: latlng$ID, map: map,$ICONA title: '$NOME'});\n";
			if ($Tipo == 1) {
				$HTML2 .= "google.maps.event.addListener(marker$ID, 'click', function() { window.location.href = 'visual-area.php?ID=$ID'; })\n";
			}
		}
		if ($Tipo != 3) {
			// CALCOLO COORDINATE MAX E MIN PER LA MAPPA
			if (!is_null($GPS_X) AND ($GPS_X != 0)) {
				if ($GPS_X > $max_X) { $max_X = $GPS_X; }
				if ($GPS_X < $min_X) { $min_X = $GPS_X; }
			}
			if (!is_null($GPS_Y) AND ($GPS_Y != 0)) {
				if ($GPS_Y > $max_Y) { $max_Y = $GPS_Y; }
				if ($GPS_Y < $min_Y) { $min_Y = $GPS_Y; }
			}
		}
	}
	// CHIUDO L'ARRAY
	if ($Tipo == 3) { $HTML1 = substr($HTML1, 0, (strlen($HTML1)-1)) . "\n];\n"; }

	// GESTIONE MANCANZA NEG/ASS
	if (($Tipo != 3) AND ($HTML1 != "")) {
		//echo "\n max_X: $max_X  - min_X: $min_X";
		//echo "\n max_Y: $max_Y  - min_Y: $min_Y";
		// TROVO IL CENTRO RISPETTO ALLE COORDINATE LETTE
		// RADDOPPIO LA LARGHEZZA PERCHE' LA MAPPA E' LARGA IL DOPPIO DELL'ALTEZZA
		$la = $max_X - $min_X;
		$al = $max_Y - $min_Y;
		$X = $min_X + $la / 2;
		$Y = $min_Y + $al / 2;
		//echo "\n la: $la  - al: $al";
		//echo "\n X: $X  - Y: $Y\n";
		// fornisce latitudine e longitudine per centrare la mappa
		//$HTML2 .= "var marker = new google.maps.Marker({ position: latlng, map: map, title: 'CENTRO'});\n";
		// TROVO LO ZOOM MIGLIORE PER QUESTA MAPPA
		// RADDOPPIO LA LARGHEZZA PERCHE' LA MAPPA E' LARGA IL DOPPIO DELL'ALTEZZA
		$la = $la*2;
		if ($la > $al) { $X2 = $la; } else { $X2 = $al; }
		//echo "\n X2: $X2";
		// SE C'E' SOLO UNA COORDINATA, LA
		if ($X2 == 0) {
			if ($Tipo == 2) { $ZOOM = 16; }	else  { $ZOOM = 9; }
		} else {
			$DIFF=10;
			$ZOOM=5;
			while ($DIFF > $X2) {
				$ZOOM++;
				$DIFF = $DIFF /2;
				//echo "\n ZOOM: $ZOOM  - DIFF: $DIFF";
			}
		}
	} else {
		$X = 42.738230;
		$Y = 12.563431;
		$ZOOM = 5;
	}
	$HTML1 .= "var latlng = new google.maps.LatLng($X,$Y);\n";
	// crea l'oggetto mappa e imposta le opzioni di visualizzazione
?>
	<script type="text/javascript">
	var initialize = function() {
<?php	echo $HTML1; ?>
	var options = { zoom: <?php	echo $ZOOM; ?>,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP};
	var map = new google.maps.Map(document.getElementById('map'), options);
<?php
	if ($Tipo == 2) {
?>
	var imgN = './img/marker-N-verde.png';
	var imgA = './img/marker-A-azzurro.png';
<?php
	} else if ($Tipo == 3) {
?>
    geocoder = new google.maps.Geocoder();
	var marker = new Array(google.maps.Marker);
	for (i = 0; i < loc.length ; i++) {
		geocoder.geocode( { 'address': loc[i]}, function(results, status) {
			if (status == 'OK') {
				var paese = results[0].address_components[0].short_name;
				var prov = results[0].address_components[1].short_name;
				if (prov.length == 2) { paese = paese + ' (' + prov + ')'; }
				else {
					var prov = results[0].address_components[2].short_name;
					if (prov.length == 2) { paese = paese + ' (' + prov + ')'; }
				}
				marker.push(new google.maps.Marker({
					position: results[0].geometry.location,
					map: map,
					title: paese
				}));
			} else {
				alert("Geocode ha ritornato il seguente errore: " + status);
			}
		});
	}	
<?php
//			} else {
//				alert("Geocode ha ritornato il seguente errore: " + status);
	}
	echo $HTML2;
?>
}
	window.onload = initialize;
	</script>
<?php
}

function sMap2($Tipo) {
// 1 = VISUALIZZAZIONE DI TUTTE LE AREE ATTIVATE
// 2 = VISUALIZZAZIONE DI UN'AREA CON NEGOZI E ASSOCIAZIONI REGISTRATE
// 3 = VISUALIZZAZIONE DEI COMUNI CON I VOLONTARI REGISTRATI
?>
	<div align="center"><B><font color="white">
<?php	if ($Tipo == 1) { ?>
		Mappa con tutti i comuni attivi. &nbsp;
		Portare il mouse sul segnaposto per avere pi&ugrave; informazioni.</B></BR>
		Cliccando il segnaposto, vedrete la mappa di quell'area</BR>
		Scorrendo la pagina, sotto la mappa &egrave; presente la lista di tutte le aree create, altrimenti potete</BR> 
		<a href="registr/user.php?T=R"><font color="white"><B>crearne una nuova.</B></font></a>		
		<div id="map" style="width:90%; height:50%"></div>
<?php	} elseif ($Tipo == 2) { ?>
		Mappa dell'area selezionata con tutti i negozi e associazioni registrate.</B></BR>
		Portare il mouse sul segnaposto per avere pi&ugrave; informazioni.</BR>
		<center>
		<img src="./img/marker-N-verde.png"> Negozio &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		<img src="./img/marker-A-azzurro.png"> Associazione</BR>
		</center>
		<div id="map" style="width:90%; height:60%"></div></BR>
		<font color="blue">
		<input type="button" value="Indietro" onclick="window.history.back()"/>
		</font>
		Per tornare alla lista delle associazioni
<?php	} elseif ($Tipo == 3) { ?>
		Mappa con tutti i comuni con volontari attivi. &nbsp;
		Portare il mouse sul segnaposto per conoscere il comune.</B></BR>
		<div id="map" style="width:90%; height:70%"></div>
<?php	} ?>
	</font></div>
<?php
}
?>

