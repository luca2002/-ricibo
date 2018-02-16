<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php" ?>
    </head>
<body bgcolor="white">
    <?php include "../menu.php"; ?>
	  <FORM ACTION="persona_salva.php" METHOD="POST">
		</BR></BR>
	    <div class="container"></BR><br>
		FARE: FINIRE COMBO
<?php if ($_SESSION[FLAG_REG]==0) { ?>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="FLAG_PRI_SEC" type="text" class="validate" MAXLENGTH="30" value="">
          <label for="icon_prefix">FLAG_PRI_SEC</label>
        </div>
		
<div class="input-field col s12">
			<select name="FLAG_PRI_SEC">
				<option value="" disabled selected>Seleziona se </option>
				<option value='N'>Negoziante</option>
				<option value='V'>Volontario</option>
				<option value='A'>Associazione</option>
			</select>
			<label>Tipo</label>
		</div>		
<?php } ?>		
		
		
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="NOME" type="text" class="validate" MAXLENGTH="30" value="Lorenzo">
          <label for="icon_prefix">Nome</label>
        </div>
		<div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input name="COGNOME" type="text" class="validate" MAXLENGTH="30" value="Torresin">
          <label for="icon_prefix">Cognome</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">today</i>
          <input type="date" name="DATA_NASCITA" class="datepicker">
          <label for="icon_prefix">Data di nascita</label>
        </div>
		
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="STATO_NASCITA" type="text" class="validate" MAXLENGTH="30" value="Italia">
          <label for="icon_prefix">Stato nascita</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="COMUNE_NASCITA" type="text" class="validate" MAXLENGTH="30" value="Monza">
          <label for="icon_prefix">Comune nascita</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="STATO_RESIDENZA" type="text" class="validate" MAXLENGTH="30" value="Italia">
          <label for="icon_prefix">Stato residenza</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="PROV_RESIDENZA" type="text" class="validate" MAXLENGTH="2" value="MB">
          <label for="icon_prefix">Provicia residenza</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="COMUNE_RESIDENZA" type="text" class="validate" MAXLENGTH="30" value="Monza">
          <label for="icon_prefix">Comune residenza</label>
        </div>
		
		<div class="input-field col s12">
          <i class="material-icons prefix">location_on</i>
          <input name="CAP" type="text" class="validate" MAXLENGTH="5" value="20900">
          <label for="icon_prefix">CAP</label>
        </div>
	
		<br>
		<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
				<i class="material-icons right">send</i>
		</button>
		
      </div>
	  </form>
  </body>
</html>