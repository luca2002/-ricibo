<?php
session_start();
/* INTERCETTO DA QUERY STRING IL PARAMETRO "T" PER VEDERE SE SI TRATTA DI R o N O A E POI IL PARAMETRO LO METTO NELLA SESSIONE */
//echo "parametroT >" . $_GET['T'] . "<</br>";
$_SESSION['FLAG_PERSONA']=$_GET['T'];
// GESTIRE MANCANZA FLAG E PERMETTERE INSERIMENTO CON UNA COMBO SOLO PER N/V/A MA NON PER R
?>
<!DOCTYPE html>
<html>
	<head>
		<!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.min.css"  media="screen,projection"/>
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
<body bgcolor="white">
	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="/~ricibo/js/materialize.min.js"></script>
	<script type="text/javascript" src="/~ricibo/js/init.js"></script>

    <?php
      include "../menu.php";
    ?>
	  <FORM ACTION="user_salva.php" METHOD="POST">
		</BR></BR>
	    <div class="container"></BR>
        TIPO REGISTRAZIONE:
		
<?php	if ($_SESSION['FLAG_PERSONA']=='R') {
			echo("ASSOCIAZIONE RESPONSABILE DI AREA");
		} elseif ($_SESSION['FLAG_PERSONA']=='N') {
			echo("NEGOZIANTE");
		} elseif ($_SESSION['FLAG_PERSONA']=='V') {
			echo("VOLONTARIO");
		} elseif ($_SESSION['FLAG_PERSONA']=='A') {
			echo("ASSOCIAZIONE");
		} else {
?>
		<div class="input-field col s12">
			<select name="FLAG_PERSONA">
				<option value="" disabled selected>Seleziona la tua registrazione</option>
				<option value='N'>Negoziante</option>
				<option value='V'>Volontario</option>
				<option value='A'>Associazione</option>
			</select>
			<label>Tipo</label>
		</div>
<?php	} ?>
		
        <!--AREA DI ATTIVITA':-->
		<div class="input-field col s12">
			<select name="ID_AREA">
				<option value="" disabled selected>Seleziona la tua area</option>
				<option selected value='1'>Monza - CSV</option>
			</select>
			<label>Area di attivita'</label>
		</div>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="USER" type="text" class="validate" MAXLENGTH="12" value="Lore74">
          <label for="icon_prefix">User</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">mail</i>
          <input name="MAIL" type="email" class="validate" MAXLENGTH="50" value="torresin7@gmail.com">
          <label for="email" data-error="Wrong" data-success="Right">Email</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">mail</i>
          <input name="MAIL2" type="email" class="validate" MAXLENGTH="50" value="torresin7@gmail.com">
          <label for="email" data-error="Wrong" data-success="Right">Conferma Email</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">lock</i>
          <input name="PWD" type="password" class="validate" MAXLENGTH="12" value="lore-pwd">
          <label for="password">Password</label>
        </div>
		<div class="input-field col s12">
		  <i class="material-icons prefix">lock</i>
          <input name="PWD2" type="password" class="validate" MAXLENGTH="12" value="lore-pwd">
          <label for="password">Conferma Password</label>
        </div>

		<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
				<i class="material-icons right">send</i>
		</button>
		
      </div>
	  </form>
  </body>
</html>
