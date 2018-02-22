<?php
session_start();
/* INTERCETTO DA QUERY STRING IL PARAMETRO "T" PER VEDERE SE SI TRATTA DI R o N O A E POI IL PARAMETRO LO METTO NELLA SESSIONE */
$_SESSION['FLAG_PERSONA']=$_GET['T'];
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "../menuHead.php"; ?>
	</head>
	<body bgcolor="white">
<?php include "../menu.php"; ?>
	<FORM ACTION="liberatoria_salva.php" METHOD="POST">
		</BR></BR>
	    <div class="container"></BR></BR>
			I dati inseriti saranno usati solo per le esigenze dell'applicativo e non saranno diffusi.</BR>
			Le mail sar&agrave; utilizzata solo per comunicazioni di servizio dell'operativit&agrave; .</BR></BR>
			<P><input name="liberatoria" type="radio" id="Accetta" value="Accetta"/><label for="Accetta">Accetta</label></P>
			<P><input name="liberatoria" type="radio" id="Rifiuta" value="Rifiuta"/><label for="Rifiuta">Rifiuta</label></P>
			<button class="waves-effect waves-light btn" type="submit" value="Procedi">Procedi
					<i class="material-icons right">send</i>
		</button>
		</div>
	</form>
	</body>
</html>
