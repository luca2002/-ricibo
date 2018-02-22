<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
		<!-- head google mapS -->
		<link href="https://developers.google.com/maps/documentation/javascript/examples/default.css" rel="stylesheet">
		<!--
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
		
		AIzaSyCsHvf0r24pgRZgSWeh_-7Ls1G0Iks6b1s
		-->
		
		 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsHvf0r24pgRZgSWeh_-7Ls1G0Iks6b1s&callback=initMap"
  type="text/javascript"></script>
  

		<script>
			var geocoder;
			var map;
			var mapOptions = {
					zoom: 17,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
			var marker;
			function initialize() {
				geocoder = new google.maps.Geocoder();
				map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
				codeAddress();
			}
			function codeAddress() {
				document.getElementById('address').value = document.getElementById('INDIRIZZO_SEDE').value + ' ' + document.getElementById('CAP_SEDE').value + ' ' + document.getElementById('COMUNE_SEDE').value;
				var address = document.getElementById('address').value;

				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						map.setCenter(results[0].geometry.location);
						if(marker)
							marker.setMap(null);
						marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location,
							draggable: true
						});
						setTimeout('', 2000);
						google.maps.event.addListener(marker, "dragend", function() {
							document.getElementById('GPS_X').value = marker.getPosition().GPS_X();
							document.getElementById('GPS_Y').value = marker.getPosition().GPS_Y();
							alert("SONO QUA1 - STATUS: " + status);
						});
						setTimeout('', 2000);
						document.getElementById('GPS_X').value = marker.getPosition().GPS_X();
						document.getElementById('GPS_Y').value = marker.getPosition().GPS_Y();
					} else {
						alert("Geocode was not successful for the following reason: " + status);
					}
					alert("ESCO!");
				});
				alert(address);
			}
		</script>
	</head>
<body bgcolor="white">
<?php include "../menu.php"; ?>
	<form method="post" action="neg_ass_salva.php">
		</BR></BR>
	    <div class="container"></BR></BR>
<?php
	$codUscita = 0;
	include "../funzioni/oDBConn.php";
	// include "../funzioni/sCreaComboDaDB.php";
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) {
		if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
		elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
	} 
	else {
		$db = $codUscita;
		//RESET DELLE VARIABILI CON I DATI DEL FORM
		$FLAG_NEG_PRI_SEC="";
		$NOME="";
		$PARTITA_IVA="";
		$INDIRIZZO_SEDE="";
		$CAP_SEDE="";
		$COMUNE_SEDE="";
		$PROV_SEDE="";
		$STATO_SEDE="Italia";
		$TELEFONO_STRUTTURA="";
		$GPS_X="";
		$GPS_Y="";
		$MAIL="";
		// LETTURA DALLA SESSIONE DEL CAMPO ID PER I DATI DI QUESTA TABELLA
		if (isset($_SESSION['ID_NEG_ASS'])) { $ID_NEG_ASS = $_SESSION['ID_NEG_ASS']; } else { $ID_NEG_ASS = ""; }
		// TESTO SE L'UTENTE E' NEL PRIMO INSERIMENTO DI REGISTRAZIONE O DI MODIFICA
		if (((isset($_SESSION['FLAG_REG'])) AND ($_SESSION['FLAG_REG'] == 0)) AND ($ID_NEG_ASS != "")) {
			// SE HO IL SUO ID_NEG_ASS LEGGO I DATI DAL DB PER LA MODIFICA
			$sql = "SELECT * FROM TB_NEG_ASS WHERE (ID_NEG_ASS='$ID_NEG_ASS')";
			$risultato_query = mysql_query($sql, $db);
			if ($risultato_query) {	
				while ($riga=mysql_fetch_array($risultato_query)) {
					$FLAG_NEG_PRI_SEC=$riga['FLAG_NEG_PRI_SEC'];
					$NOME=$riga['NOME'];
					$PARTITA_IVA=$riga['P_IVA'];
					$INDIRIZZO_SEDE=$riga['INDIRIZZO_SEDE'];
					$CAP_SEDE=$riga['CAP_SEDE'];
					$COMUNE_SEDE=$riga['COMUNE_SEDE'];
					$PROV_SEDE=$riga['PROV_SEDE'];
					$STATO_SEDE=$riga['STATO_SEDE'];
					$TELEFONO_STRUTTURA=$riga['TELEFONO_STRUTTURA'];
					$GPS_X=$riga['GPS_X'];
					$GPS_Y=$riga['GPS_Y'];
					$MAIL=$riga['MAIL'];
				}
			}			
		} else{
			//PRIMA REGISTRAZIONE: SE IN SVILUPPO IMPOSTO I DATI TEST
			if ($_SESSION['FLAG_SVILUPPO']) {
				$FLAG_NEG_PRI_SEC="";
				$NOME="Lorenzo";
				$PARTITA_IVA="PIVA5678901";
				$INDIRIZZO_SEDE="via mariani, 1";
				$CAP_SEDE="20092";
				$COMUNE_SEDE="Cinisello Balsamo";
				$PROV_SEDE="MI";
				$STATO_SEDE="Italia";
				$TELEFONO_STRUTTURA="0261234567";
				$GPS_X="11,1111";
				$GPS_Y="22,2222";
				$MAIL="torresin7@gmail.com";
			}
		}
		// LETTURA ANDATA A BUON FINE, CHIUDO LA CONNESSIONE
		mysql_close($codUscita);
		$codUscita = 0;
	}
//echo("</br> FLAG_NEG_PRI_SEC=" . $FLAG_NEG_PRI_SEC);
	// IN CASO DI ERRORE, NON VISUALIZZO IL FORM DI INSERIMENTO DATI
	if ($codUscita == 0) {
?>
		<center>
		<div class="input-field col s12">
			<i class="material-icons prefix">business</i>
			<select name="FLAG_NEG_PRI_SEC">
<?php
		// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
		$bInserimento = !(isset($_SESSION['FLAG_REG']));
		if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
// echo("</br>bInserimento>" . $bInserimento . "<</br>");
		$sPri = "principale";
		$sSec = "secondaria";
		if ($bInserimento) {
			echo ("<option value='P' selected>$sPri</option>");
		} elseif ($_SESSION['FLAG_PERSONA'] != ('V')) {
			if ($FLAG_NEG_PRI_SEC == 'P') { $pri = "selected"; }
			elseif ($FLAG_NEG_PRI_SEC == 'S') { $pri = "selected"; }
			else { $sel = "selected"; }
			echo ("<option value=\"\" disabled $sel>Selezionare se e' la sede $sPri o $sSec</option>");
			echo ("<option value='P' $pri>$sPri</option>");
			echo ("<option value='S' $sec>$sSec</option>");
		}
		echo ("</select>	<label>Sede $sPri/$sSec</label>");
?>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">persona</i>
			<input name="NOME" type="text" size="50" MAXLENGTH="50" <?php echo(" value=\"$NOME\""); ?>>
			<label>Nome Attivita'</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">picture_in_picture</i>
			<input name="P_IVA" type="text" size="11" MAXLENGTH="11" <?php echo(" value=\"$PARTITA_IVA\""); ?>>
			<label>Partita IVA</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">add_location</i>
			<input id="INDIRIZZO_SEDE" name="INDIRIZZO_SEDE" type="text" size="50" MAXLENGTH="50" <?php echo(" value=\"$INDIRIZZO_SEDE\""); ?>>
			<label>Indirizzo</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">add_location</i>
			<input id="CAP_SEDE" name="CAP_SEDE" type="text" size="5" MAXLENGTH="5" <?php echo(" value=\"$CAP_SEDE\""); ?>>
			<label>Cap</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">add_location</i>
			<input id="COMUNE_SEDE" name="COMUNE_SEDE" type="text" size="30" MAXLENGTH="30" <?php echo(" value=\"$COMUNE_SEDE\""); ?>>
			<label>Comune</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">add_location</i>
			<input name="PROV_SEDE" type="text" size="2" MAXLENGTH="2" <?php echo(" value=\"$PROV_SEDE\""); ?>>
			<label>Provincia</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">add_location</i>
			<input name="STATO_SEDE" type="text" size="30" MAXLENGTH="30" <?php echo(" value=\"$STATO_SEDE\""); ?>>
			<label>Stato</label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">phone</i>
			<input name="TELEFONO_STRUTTURA" type="text" size="14" MAXLENGTH="14" <?php echo(" value=\"$TELEFONO_STRUTTURA\""); ?>>
			<label>Telefono<label>
		</div>
		<div class="input-field col s12">
			<i class="material-icons prefix">mail</i>
			<input name="MAIL" type="text" size="50" MAXLENGTH="50" <?php echo(" value=\"$MAIL\""); ?>>
			<label>Mail</label>
		</div>
		</CENTER>
		<input id="address" name="address" type="hidden">
		<input id="GPS_X" name="GPS_X" type="hidden">
		<input id="GPS_Y" name="GPS_Y" type="hidden">

		<div align="right">
			<button class="btn waves-effect waves-light" type="submit" name="salva" onclick="codeAddress();">SALVA
			<i class="material-icons right">send</i>
			</button>
		</div>
<?php } ?>
	</div>
</body>
</html>
