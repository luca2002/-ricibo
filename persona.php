<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
    </head>
<body bgcolor="white">
<?php include "../menu.php"; ?>
	<FORM ACTION="persona_salva.php" METHOD="POST">
		</BR></BR>
	    <div class="container"></BR></BR>
<?php
	$codUscita = 0;
	include "../funzioni/oDBConn.php";
	include "../funzioni/sCreaComboDaDB.php";
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) {
		if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
		elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
	} else {
		$db=$codUscita;
		// CONTROLLO SE FLAG_REG E' IN SESSIONE E SE NON E' 0 (QUINDI SIAMO IN INSERIMENTO)
		$bInserimento = !(isset($_SESSION['FLAG_REG']));
		if (!$bInserimento) { $bInserimento = ($_SESSION['FLAG_REG'] != 0); }
// echo("</br>bInserimento>" . $bInserimento . "<</br>");
	
		// RESET DELLE VARIABILI CON I DATI DEL FORM
		$FLAG_PRI_SEC = "";
		$NOME = "";
		$COGNOME = "";
		$DATA_NASCITA = "";
		$PROV_DOM = "";
		$COMUNE_DOM = "";
		$CAP_DOM = "";
		$CELL = "";
		// LETTURA DALLA SESSIONE DEL CAMPO ID PER I DATI DI QUESTA TABELLA
		if (isset($_SESSION['ID_PERSONA'])) { $ID_PERSONA = $_SESSION['ID_PERSONA']; } else { $ID_PERSONA = ""; }
		// TESTO SE L'UTENTE E' NEL PRIMO INSERIMENTO DI REGISTRAZIONE O DI MODIFICA
		if (((isset($_SESSION['FLAG_REG'])) AND ($_SESSION['FLAG_REG'] == 0)) AND ($ID_PERSONA != "")) {
			// SE HO IL SUO ID USER LEGGO I DATI DAL DB PER LA MODIFICA
			$sql = "SELECT P.*, C.CELL FROM TB_PERSONA P LEFT JOIN TB_CELLULARI C ON (P.ID_PERSONA = C.ID_PERSONA) WHERE (P.ID_PERSONA=$ID_PERSONA)";
// echo("</br> sql=" . $sql);
			$risultato_query = mysqli_query($db,$sql);
// echo("</br> risultato_query=" . $risultato_query);
			if ($risultato_query) {
				while ($riga=@mysqli_fetch_array($risultato_query)) {
					$FLAG_PRI_SEC = $riga['FLAG_PRI_SEC'];
					$NOME = $riga['NOME'];
					$COGNOME = $riga['COGNOME'];
					$DATA_NASCITA = $riga['DATA_NASCITA'];
					$PROV_DOM = $riga['PROV_DOM'];
					$COMUNE_DOM = $riga['COMUNE_DOM'];
					$CAP_DOM = $riga['CAP_DOM'];
					$CELL  = $riga['CELL'];
				}
			}
		} else {
			// PRIMA REGISTRAZIONE: SE IN SVILUPPO IMPOSTO I DATI DI TEST
			if ($_SESSION['FLAG_SVILUPPO']) {
				$FLAG_PRI_SEC = "P";
				$NOME = "Lorenzo";
				$COGNOME = "Torresin";
				$DATA_NASCITA = "1974-04-03";
				$PROV_DOM="MI";
				$COMUNE_DOM="Cinisello Balsamo";
				$CAP_DOM="20092";
				$CELL  = "3282740344";
			}
		}
		// LETTURA ANDATA A BUON FINE, CHIUDO LA CONNESSIONE
		mysqli_close($codUscita);
		$codUscita = 0;
	}
// echo("</br> codUscita=" . $codUscita);
// echo("</br> DATA_NASCITA=" . $DATA_NASCITA);
// echo("</br> SESSION['FLAG_PERSONA']=" . $_SESSION['FLAG_PERSONA']);
	// IN CASO DI ERRORE, NON VISUALIZZO IL FORM DI INSERIMENTO DATI
	if ($codUscita == 0) {
?>
		<center>
<?php	// X I VOLONTARI NON VIENE RICHIESTO
		if ($_SESSION['FLAG_PERSONA'] != 'V') { ?>
		<div class="input-field col s12">
			<select name="FLAG_PRI_SEC">
<?php		// SE E' UNA PRIMA REGISTRAZIONE NEL SALVATAGGIO IMPOSTO FLAG_PRI_SEC=P
			if ($_SESSION['FLAG_PERSONA'] == ('R' || 'A')) { $sPri = "responsabile"; $sSec = "collaboratore"; }
			elseif ($_SESSION['FLAG_PERSONA'] == 'N') { $sPri = "principale";  $sSec = "dipendente"; }
			if ($bInserimento) {
				echo ("<option value='P'>$sPri</option>");
			} elseif ($_SESSION['FLAG_PERSONA'] == ('R' || 'A')) {
				if ($FLAG_PRI_SEC == 'P') { $pri = "selected"; }
				elseif ($FLAG_PRI_SEC == 'S') { $pri = "selected"; }
				else { $sel = "selected"; }
				echo ("<option value=\"\" disabled $sel>Selezionare se si &egrave; il $sPri o un $sSec</option>");
				echo ("<option value='P' $pri>$sPri</option>");
				echo ("<option value='S' $sec>$sSec</option>");
			}
			echo ("</select>\n	</div>\n	<label>$sPri/$sSec</label>");
		}
?>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="NOME" type="text" class="validate" MAXLENGTH="30"<?php echo(" value=\"$NOME\""); ?>>
          <label for="icon_prefix">Nome</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="COGNOME" type="text" class="validate" MAXLENGTH="30"<?php echo(" value=\"$COGNOME\""); ?>>
          <label for="icon_prefix">Cognome</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">today</i>
          <input type="date" id="data" name="DATA_NASCITA" class="datepicker"<?php echo(" value=\"$DATA_NASCITA\""); ?>>
          <label for="icon_prefix">Data di nascita (selezionare la data e premere CLOSE)</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="PROV_DOM" type="text" class="validate" MAXLENGTH="2"<?php echo(" value=\"$PROV_DOM\""); ?>>
          <label for="icon_prefix">Provicia domicilio (sigla di 2 lettere)</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="COMUNE_DOM" type="text" class="validate" MAXLENGTH="30"<?php echo(" value=\"$COMUNE_DOM\""); ?>>
          <label for="icon_prefix">Comune domicilio</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="CAP_DOM" type="text" class="validate" MAXLENGTH="5"<?php echo(" value=\"$CAP_DOM\""); ?>>
          <label for="icon_prefix">CAP domicilio</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">phone</i>
          <input name="CELL" type="tel" class="validate" MAXLENGTH="10"<?php echo(" value=\"$CELL\""); ?>>
          <label for="icon_telephone">Cellulare</label>
        </div>
		</center>
		<br>
		<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
			<i class="material-icons right">send</i>
		</button>
<?php } ?>
		</div>
	</form>
	</body>
</html>
