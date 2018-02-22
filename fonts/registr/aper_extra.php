<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
		<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.clockpicker.css" media="screen,projection" />
		<script src="<?php echo $_SESSION['PATH'];?>/js/materialize.clockpicker.js"></script>
	</head>
	<body bgcolor="white">
		<?php include "../menu.php"; ?>
	  <form action="aper_extra_salva.php" METHOD="POST">
		  </br></br>
	    <div class="container">
				<?php
					$codUscita = 0;
					include "../funzioni/oDBConn.php";
					$codUscita = oDBConn();
					if (is_numeric($codUscita)) {
						if ($codUscita == 1) {
							echo("</br>Errore: connessione al DB fallita.</br>");
						}
						elseif ($codUscita == 2) {
							echo("</br>Errore: DB non trovato.</br>");
						} // CONNESSIONE ESEGUITA, MA DB NON TROVATO
					} else {
						// FARE: INSERIRE LA LETTURA DEL RECORD PER LE MODIFICHE
						// CARICAMENTO VALORI DEL FORM X TEST O LEGGENDO DAL DB PER MODIFICA DATI - DA COMPLETARE
						if ($_SESSION['FLAG_SVILUPPO']) {
              $DATA = "1970-01-01";
							$ORA1_APER = "01:00";
							$ORA1_CHIU = "02:00";
							$ORA2_APER = "03:00";
							$ORA2_CHIU = "04:00";
						} elseif($_SESSION['FLAG_REG'] == 0) {
							$ID_NEG_ASS = $_SESSION['ID_NEG_ASS'];
							$sql = "SELECT GIORNO_SETTIMANA, ORA1_INIZIO, ORA1_FINE, ORA2_INIZIO, ORA2_FINE FROM TB_APER_EXTRA WHERE ID_NEG_ASS=$ID_NEG_ASS ORDER BY GIORNO_SETTIMANA";
							$result = mysql_query($sql);
							$riga = mysql_fetch_array($result);
              $DATA = $riga['GIORNO_SETTIMANA'];
							$ORA1_APER = $riga['ORA1_INIZIO'];
							$ORA1_CHIU = $riga['ORA1_FINE'];
							$ORA2_APER = $riga['ORA2_INIZIO'];
							$ORA2_CHIU = $riga['ORA2_FINE'];
						} else {
              $DATA = "";
							$ORA1_APER = "";
							$ORA1_CHIU = "";
							$ORA2_APER = "";
							$ORA2_CHIU = "";
						}
						// LETTURA ANDATA A BUON FINE, CHIUDO LA CONNESSIONE
						mysql_close($codUscita);
						$codUscita = 0;
					}
							// echo("</br> codUscita=" . $codUscita);
							// IN CASO DI ERRORE, NON VISUALIZZO IL FORM DI INSERIMENTO DATI
							//if ($codUscita == 0) { }
				?>
        </br>
        </br>
				I turni di chiusura vanno indicati inserendo 00:00 sia come orario di apertura che di chiusura.
        <table class="bordered">
          <thead>
            <tr>
              <th>Giorno</th>
              <th>Orario mattina</th>
              <th>Orario pomeriggio</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="input-field col s12">
                    <i class="material-icons prefix">today</i>
                    <input type="date" name="DATA" id="DATA" class="datepicker"<?php echo(" value=\"$DATA\""); ?>>
                    <label for="icon_prefix">Data</label>
                </div>
              </td>
              <td>
                <div class="input-field inline">
                    <label for="ORA1_APER">Ora inizio</label>
                    <input name="ORA1_APER" id="ORA1_APER" class="timepicker" <?php echo(" value=\"$ORA1_APER\""); ?>>
                </div>
                <div class="input-field inline">
                    <label for="ORA1_CHIU">Ora fine</label>
                    <input name="ORA1_CHIU" id="ORA1_CHIU" class="timepicker" <?php echo(" value=\"$ORA1_CHIU\""); ?>>
                </div>
              </td>
              <td>
                <div class="input-field inline">
                    <label for="ORA2_APER">Ora inizio</label>
                    <input name="ORA2_APER" id="ORA2_APER" class="timepicker" <?php echo(" value=\"$ORA2_APER\""); ?>>
                </div>
                <div class="input-field inline">
                    <label for="ORA2_CHIU">Ora fine</label>
                    <input name="ORA2_CHIU" id="ORA2_CHIU" class="timepicker" <?php echo(" value=\"$ORA2_CHIU\""); ?>>
                </div>
              </td>
            </tr>
            </tr>
          </tbody>
        </table>
        </br>
				<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
						<i class="material-icons right">send</i>
				</button>
			</br></br>
      </div>
	  </form>
  </body>
</html>
