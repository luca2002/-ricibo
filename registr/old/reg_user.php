<?php
session_start();
/* INTERCETTO DA QUERY STRING IL PARAMETRO "T" PER VEDERE SE SI TRATTA DI R o N O A E POI IL PARAMETRO LO METTO NELLA SESSIONE */
//echo "parametroT >" . $_GET['T'] . "<</br>";
$_SESSION['FLAG_PERSONA']=$_GET['T'];
// GESTIRE MANCANZA FLAG E PERMETTERE INSERIMENTO CON UNA COMBO SOLO PER N/V/A MA NON PER R

?>
<!DOCTYPE html>
<html>
  <body bgcolor="white">
    <?php
      include "../menu.php"
    ?>
	  <FORM ACTION="reg_user_salva.php" METHOD="POST">
	    <table border="1">
        <tr><td align="right">TIPO REGISTRAZIONE:</td><td>
		
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
      	<select name="FLAG_PERSONA">
      		<option value="default" selected>Seleziona la tua registrazione</option>
      		<option value='N'>Negoziante</option>
      		<option value='V'>Volontario</option>
      		<option value='A'>Associazione</option>
      	</select>
<?php	} ?>
		</td></tr>
        <tr><td align="right">AREA DI ATTIVITA':</td><td>
      	<select name="ID_AREA">
      		<option value="default" selected>Seleziona la tua area</option>
      		<option selected value='1'>Monza - CSV</option>
      	</select></td></tr>
		<tr><td align="right">USER:</td><td><input name="USER" type="text" size="12" MAXLENGTH="12" value="Lore74"></td></tr>
        <tr><td align="right">MAIL:</td><td><input name="MAIL" type="text" size="50" MAXLENGTH="50" value="torresin7@gmail.com"></td></tr>
        <tr><td align="right">CONFERMA MAIL:</td><td><input name="MAIL2" type="text" size="50" MAXLENGTH="50" value="torresin7@gmail.com"></td></tr>
        <tr><td align="right">PASSWORD:</td><td><input name="PWD" type="password" size="12" MAXLENGTH="12" value="lore-pwd"></td></tr>
        <tr><td align="right">CONFERMA PASSWORD:</td><td><input name="PWD2" type="password" size="12" MAXLENGTH="12" value="lore-pwd"></td></tr>
        <tr><td align="right"></td><td><input type="submit" value="SALVA"></td></tr>
      </table>
  </body>
</html>
