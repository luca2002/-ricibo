<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
		<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.clockpicker.css" media="screen,projection" />
		<script src="/~ricibo/js/materialize.clockpicker.js"></script>
	</head>
<body bgcolor="white">
	<?php include "../menu.php"; ?>
	<form action="apertura_salva.php" METHOD="POST">
		</br></br>
		<div class="container">
<?php
	$codUscita = 0;
	include "../funzioni/oDBConn.php";
	include "../funzioni/sCheckOra.php";
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) {
		if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
		elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
	}
	else {
		$db = $codUscita;
		//RESET DELLE VARIABILI CON I DATI DEL FORM
		$LUN_ORA1_APER = "";
		$LUN_ORA1_CHIU = "";
		$LUN_ORA2_APER = "";
		$LUN_ORA2_CHIU = "";
		$MAR_ORA1_APER = "";
		$MAR_ORA1_CHIU = "";
		$MAR_ORA2_APER = "";
		$MAR_ORA2_CHIU = "";
		$MER_ORA1_APER = "";
		$MER_ORA1_CHIU = "";
		$MER_ORA2_APER = "";
		$MER_ORA2_CHIU = "";
		$GIO_ORA1_APER = "";
		$GIO_ORA1_CHIU = "";
		$GIO_ORA2_APER = "";
		$GIO_ORA2_CHIU = "";
		$VEN_ORA1_APER = "";
		$VEN_ORA1_CHIU = "";
		$VEN_ORA2_APER = "";
		$VEN_ORA2_CHIU = "";
		$SAB_ORA1_APER = "";
		$SAB_ORA1_CHIU = "";
		$SAB_ORA2_APER = "";
		$SAB_ORA2_CHIU = "";
		$DOM_ORA1_APER = "";
		$DOM_ORA1_CHIU = "";
		$DOM_ORA2_APER = "";
		$DOM_ORA2_CHIU = "";

		// LETTURA DALLA SESSIONE DEL CAMPO ID PER I DATI DI QUESTA TABELLA
	if (isset($_SESSION['ID_NEG_ASS'])) { $ID_NEG_ASS = $_SESSION['ID_NEG_ASS']; } else { $ID_USER = ""; }
		// TESTO SE L'UTENTE E' NEL PRIMO INSERIMENTO DI REGISTRAZIONE O DI MODIFICA
		if (((isset($_SESSION['FLAG_REG'])) AND ($_SESSION['FLAG_REG'] == 0)) AND ($ID_NEG_ASS != "")) {
			// SE HO IL SUO ID_NEG_ASS LEGGO I DATI DAL DB PER LA MODIFICA
			$sql = "SELECT ORA1_APER, ORA1_CHIU, ORA2_APER, ORA2_CHIU FROM TB_APERTURA WHERE (ID_NEG_ASS=$ID_NEG_ASS) ORDER BY GIORNO_SETTIMANA";
			$result = mysqli_query($db,$sql);
		if ($result) {
				$riga = mysqli_fetch_array($result);
				$LUN_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$LUN_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$LUN_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$LUN_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$MAR_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$MAR_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$MAR_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$MAR_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$MER_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$MER_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$MER_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$MER_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$GIO_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$GIO_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$GIO_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$GIO_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$VEN_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$VEN_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$VEN_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$VEN_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$SAB_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$SAB_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$SAB_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$SAB_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
				$riga = mysqli_fetch_array($result);
				$DOM_ORA1_APER = sCheckOra($riga['ORA1_APER']);
				$DOM_ORA1_CHIU = sCheckOra($riga['ORA1_CHIU']);
				$DOM_ORA2_APER = sCheckOra($riga['ORA2_APER']);
				$DOM_ORA2_CHIU = sCheckOra($riga['ORA2_CHIU']);
			}
		} else {
			//PRIMA REGISTRAZIONE: SE IN SVILUPPO IMPOSTO I DATI TEST
			$LUN_ORA1_APER = "01:00";
			$LUN_ORA1_CHIU = "02:00";
			$LUN_ORA2_APER = "03:00";
			$LUN_ORA2_CHIU = "04:00";
			$MAR_ORA1_APER = "05:00";
			$MAR_ORA1_CHIU = "06:00";
			$MAR_ORA2_APER = "07:00";
			$MAR_ORA2_CHIU = "08:00";
			$MER_ORA1_APER = "09:00";
			$MER_ORA1_CHIU = "10:00";
			$MER_ORA2_APER = "11:00";
			$MER_ORA2_CHIU = "12:00";
			$GIO_ORA1_APER = "13:00";
			$GIO_ORA1_CHIU = "14:00";
			$GIO_ORA2_APER = "15:00";
			$GIO_ORA2_CHIU = "16:00";
			$VEN_ORA1_APER = "17:00";
			$VEN_ORA1_CHIU = "18:00";
			$VEN_ORA2_APER = "19:00";
			$VEN_ORA2_CHIU = "20:00";
			$SAB_ORA1_APER = "21:00";
			$SAB_ORA1_CHIU = "22:00";
			$SAB_ORA2_APER = "23:00";
			$SAB_ORA2_CHIU = "23:59";
			$DOM_ORA1_APER = "01:01";
			$DOM_ORA1_CHIU = "02:02";
			$DOM_ORA2_APER = "03:03";
			$DOM_ORA2_CHIU = "04:04";
		}
		// LETTURA ANDATA A BUON FINE, CHIUDO LA CONNESSIONE
		mysqli_close($codUscita);
		$codUscita = 0;
	}
// echo("</BR> codUscita=" . $codUscita);

	if ($_SESSION['FLAG_PERSONA'] == 'N') {
		echo "</BR>Inserimento gli ordinari orari di apertura della settimana per il ritiro del cibo dalla vostra sede.";
	} else if ($_SESSION['FLAG_PERSONA'] == 'A') {
		echo "</BR>Inserimento gli ordinari orari di apertura della settimana per la consegna del cibo alla vostra sede.";
	}
?>
        </BR>
		Per inserire l'orario usare il formato HH:MM. &nbsp; Per esempio: &nbsp;  8:30, 12:00</BR>
		Se un turno o un giorno l'attivit&agrave; &egrave; chiusa lasciare il campo vuoto, risulter&agrave; 0:00 come orario di apertura e di chiusura.
        <table class="bordered">
		<thead>
			<tr>
			<th>Giorni</th>
			<th>Orario mattina</th>
			<th>Orario pomeriggio</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td>Luned&igrave</td>
			<td>
			<div class="input-field inline">
				<label for="LUN_ORA1_APER">Ora inizio</label>
				<input name="LUN_ORA1_APER" id="LUN_ORA1_APER" class="timepicker" <?php echo(" value=\"$LUN_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="LUN_ORA1_CHIU">Ora fine</label>
				<input name="LUN_ORA1_CHIU" id="LUN_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$LUN_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="LUN_ORA2_APER">Ora inizio</label>
				<input name="LUN_ORA2_APER" id="LUN_ORA2_APER" class="timepicker" <?php echo(" value=\"$LUN_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="LUN_ORA2_CHIU">Ora fine</label>
				<input name="LUN_ORA2_CHIU" id="LUN_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$LUN_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Marted&igrave</td>
			<td>
			<div class="input-field inline">
				<label for="MAR_ORA1_APER">Ora inizio</label>
				<input name="MAR_ORA1_APER" id="MAR_ORA1_APER" class="timepicker" <?php echo(" value=\"$MAR_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="MAR_ORA1_CHIU">Ora fine</label>
				<input name="MAR_ORA1_CHIU" id="MAR_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$MAR_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="MAR_ORA2_APER">Ora inizio</label>
				<input name="MAR_ORA2_APER" id="MAR_ORA2_APER" class="timepicker" <?php echo(" value=\"$MAR_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="MAR_ORA2_CHIU">Ora fine</label>
				<input name="MAR_ORA2_CHIU" id="MAR_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$MAR_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Mercoled&igrave</td>
			<td>
			<div class="input-field inline">
				<label for="MER_ORA1_APER">Ora inizio</label>
				<input name="MER_ORA1_APER" id="MER_ORA1_APER" class="timepicker" <?php echo(" value=\"$MER_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="MER_ORA1_CHIU">Ora fine</label>
				<input name="MER_ORA1_CHIU" id="MER_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$MER_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="MER_ORA2_APER">Ora inizio</label>
				<input name="MER_ORA2_APER" id="MER_ORA2_APER" class="timepicker" <?php echo(" value=\"$MER_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="MER_ORA2_CHIU">Ora fine</label>
				<input name="MER_ORA2_CHIU" id="MER_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$MER_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Gioved&igrave</td>
			<td>
			<div class="input-field inline">
				<label for="GIO_ORA1_APER">Ora inizio</label>
				<input name="GIO_ORA1_APER" id="GIO_ORA1_APER" class="timepicker" <?php echo(" value=\"$GIO_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="GIO_ORA1_CHIU">Ora fine</label>
				<input name="GIO_ORA1_CHIU" id="GIO_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$GIO_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="GIO_ORA2_APER">Ora inizio</label>
				<input name="GIO_ORA2_APER" id="GIO_ORA2_APER" class="timepicker" <?php echo(" value=\"$GIO_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="GIO_ORA2_CHIU">Ora fine</label>
				<input name="GIO_ORA2_CHIU" id="GIO_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$GIO_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Venerd&igrave</td>
			<td>
			<div class="input-field inline">
				<label for="VEN_ORA1_APER">Ora inizio</label>
				<input name="VEN_ORA1_APER" id="VEN_ORA1_APER" class="timepicker" <?php echo(" value=\"$VEN_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="VEN_ORA1_CHIU">Ora fine</label>
				<input name="VEN_ORA1_CHIU" id="VEN_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$VEN_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="VEN_ORA2_APER">Ora inizio</label>
				<input name="VEN_ORA2_APER" id="VEN_ORA2_APER" class="timepicker" <?php echo(" value=\"$VEN_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="VEN_ORA2_CHIU">Ora fine</label>
				<input name="VEN_ORA2_CHIU" id="VEN_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$VEN_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Sabato</td>
			<td>
			<div class="input-field inline">
				<label for="SAB_ORA1_APER">Ora inizio</label>
				<input name="SAB_ORA1_APER" id="SAB_ORA1_APER" class="timepicker" <?php echo(" value=\"$SAB_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="SAB_ORA1_CHIU">Ora fine</label>
				<input name="SAB_ORA1_CHIU" id="SAB_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$SAB_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="SAB_ORA2_APER">Ora inizio</label>
				<input name="SAB_ORA2_APER" id="SAB_ORA2_APER" class="timepicker" <?php echo(" value=\"$SAB_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="SAB_ORA2_CHIU">Ora fine</label>
				<input name="SAB_ORA2_CHIU" id="SAB_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$SAB_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		<tr>
			<td>Domenica</td>
			<td>
			<div class="input-field inline">
				<label for="DOM_ORA1_APER">Ora inizio</label>
				<input name="DOM_ORA1_APER" id="DOM_ORA1_APER" class="timepicker" <?php echo(" value=\"$DOM_ORA1_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="DOM_ORA1_CHIU">Ora fine</label>
				<input name="DOM_ORA1_CHIU" id="DOM_ORA1_CHIU" class="timepicker" <?php echo(" value=\"$DOM_ORA1_CHIU\""); ?>>
			</div>
			</td>
			<td>
			<div class="input-field inline">
				<label for="DOM_ORA2_APER">Ora inizio</label>
				<input name="DOM_ORA2_APER" id="DOM_ORA2_APER" class="timepicker" <?php echo(" value=\"$DOM_ORA2_APER\""); ?>>
			</div>
			<div class="input-field inline">
				<label for="DOM_ORA2_CHIU">Ora fine</label>
				<input name="DOM_ORA2_CHIU" id="DOM_ORA2_CHIU" class="timepicker" <?php echo(" value=\"$DOM_ORA2_CHIU\""); ?>>
			</div>
			</td>
		</tr>
		</tbody>
		</table></br>
		<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
			<i class="material-icons right">send</i>
		</button>
		</br></br>
		</div>
	</form>
</body>
</html>
