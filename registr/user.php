<?php
session_start();
/* INTERCETTO DA QUERY STRING IL PARAMETRO "T" PER VEDERE SE SI TRATTA DI R o N O A E POI IL PARAMETRO LO METTO NELLA SESSIONE */
//echo "parametroT >" . $_GET['T'] . "<</br>";
if (isset($_GET['T'])) { $_SESSION['FLAG_PERSONA']=$_GET['T'];}
if (isset($_GET['A'])) { $_SESSION['ID_AREA']=$_GET['A']; }
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php"; ?>
	<FORM ACTION="user_salva.php" METHOD="POST">
		</BR></BR>
		<center>
	    <div class="container"></BR><br>
<?php
	$codUscita = 0;
	include "../funzioni/oDBConn.php";
	include "../funzioni/sCreaComboDaDB.php";
	$codUscita = oDBConn();
	if (is_numeric($codUscita)) {
		if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
		elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
	} else {
		$db = $codUscita;
		if ((isset($_SESSION['ID_AREA']))) {
			$ID_AREA = $_SESSION['ID_AREA'];
			$sSql = "SELECT ID_AREA, concat(ASSOC_SIGLA, \" - \", COMUNE, \" (\", PROV, \")\") AS VALORE FROM tb_area WHERE ID_AREA=$ID_AREA";
		} else {
			$sSql = "SELECT ID_AREA, concat(ASSOC_SIGLA, \" - \", COMUNE, \" (\", PROV, \")\") AS VALORE FROM tb_area ORDER BY NAZIONE, PROV, CAP, ASSOC_SIGLA";
		}
		$sCmbArea = sCreaComboDaDB($sSql, "Seleziona l'associazione/area in cui operare", "ID_AREA", "ID_AREA", "VALORE",$db);
		$codUscita = 0;
	}
// echo("</br> codUscita=" . $codUscita);
// echo ("</br>ID_USER>" . $ID_USER);
// echo ("</br>sql>" . $sql);
	// IN CASO DI ERRORE, NON VISUALIZZO IL FORM DI INSERIMENTO DATI
	if ($codUscita == 0) {
		// RESET DELLE VARIABILI COI DATI DEL FORM
		$ID_AREA = "";
		$USER = "";
		$PWD = "";
		$MAIL = "";
		// TESTO SE L'UTENTE E' NEL PRIMO INSERIMENTO DI REGISTRAZIONE O IN MODIFICA
		if (isset($_SESSION['ID_USER'])) { $ID_USER = $_SESSION['ID_USER']; } else { $ID_USER = ""; }
		if (((isset($_SESSION['FLAG_REG'])) AND ($_SESSION['FLAG_REG'] == 0)) AND ($ID_USER != "")) {
			// SE HO IL SUO ID_USER LEGGO I DATI DAL DB PER LA MODIFICA
			$sql = "SELECT U.*, M.MAIL FROM TB_USER U LEFT JOIN TB_MAIL M ON (U.ID_USER=M.ID_USER) WHERE (U.ID_USER='$ID_USER')";
			$risultato_query = mysqli_query($sql, $db);
			if ($risultato_query) {	
				while ($riga=mysqli_fetch_array($risultato_query)) {
					$ID_AREA = $riga['ID_AREA'];
					$USER = $riga['USER'];
					$PWD = $riga['PWD'];
					$MAIL = $riga['MAIL'];
				}
			}			
		} 		
		mysqli_close($db);	// CHIUDO LA CONNESSIONE AL DB

		// GESTIONE MANCANZA FLAG E INSERIMENTO CON UNA COMBO SOLO PER N/V/A MA NON PER R
		if ($_SESSION['FLAG_PERSONA']=='R') { echo("REGISTRAZIONE UTENTE PER ASSOCIAZIONE RESPONSABILE DI AREA"); }
		elseif ($_SESSION['FLAG_PERSONA']=='N') { echo("REGISTRAZIONE UTENTE PER UN NEGOZIO"); }
		elseif ($_SESSION['FLAG_PERSONA']=='V') { echo("REGISTRAZIONE UTENTE COME VOLONTARIO"); }
		elseif ($_SESSION['FLAG_PERSONA']=='A') { echo("REGISTRAZIONE UTENTE PR UNA ASSOCIAZIONE"); }
		else {
?>

		<div class="input-field col s12">
			<select name="FLAG_PERSONA">
				<option value="" disabled selected>Seleziona se sei negoziante, volontario o associazione</option>
				<option value='N'>Negoziante</option>
				<option value='V'>Volontario</option>
				<option value='A'>Associazione</option>
			</select>
			<label>Tipo registrazione</label>
		</div>
<?php	} ?>
        <!--AREA DI ATTIVITA':-->
		<div class="input-field col s12">
			<?php echo($sCmbArea); ?>
			<label>Area di attivita'</label>
		</div>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="USER" type="text" class="validate" MAXLENGTH="12"<?php echo(" value=\"$USER\""); ?>>
          <label for="icon_prefix">User</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">mail</i>
          <input name="MAIL" type="email" class="validate" MAXLENGTH="50"<?php echo(" value=\"$MAIL\""); ?>>
          <label for="email" data-error="Wrong" data-success="Right">Email</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">mail</i>
          <input name="MAIL2" type="email" class="validate" MAXLENGTH="50"<?php echo(" value=\"$MAIL\""); ?>>
          <label for="email" data-error="Wrong" data-success="Right">Conferma Email</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">lock</i>
          <input name="PWD" type="password" class="validate" MAXLENGTH="12"<?php echo(" value=\"$PWD\""); ?>>
          <label for="PWD">Password</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">lock</i>
          <input name="PWD2" type="password" class="validate" MAXLENGTH="12"<?php echo(" value=\"$PWD\""); ?>>
          <label for="PWD2">Conferma Password</label>
        </div>
		<div class="input-field col s12">
			Procedendo con la registrazione si accetta la nostra politica sulla privacy. </br></br>
			<a href="//www.iubenda.com/privacy-policy/8106375" class="iubenda-white iubenda-embed" title="Privacy Policy">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "//cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
        </div>
		</BR></BR>
		<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
			<i class="material-icons right">send</i>
		</button>
<?php } ?>
		</div>
		</center>
	</form>
	</body>
</html>
