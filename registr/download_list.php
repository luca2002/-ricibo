<?php
	session_start();
	
	try{
		if (!isset($_SESSION["ID_USER"])) {
			 header("location: ../index.php");
			 return;
		}
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
		}else{
			$qry = "SELECT * FROM TB_APP_VERSIONI";
			$res = mysql_query($qry);
			if(!$res){
				echo(mysql_error());
				die("DB Error");
			}
			
		?>
<!DOCTYPE html>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
		<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.clockpicker.css" media="screen,projection" />
		<script src="/~ricibo/js/materialize.clockpicker.js"></script>
	</head>
<body bgcolor="white">
	<?php include '../menu.php'; ?>
	</br></br>
	<div class="container">
		<table class="bordered">
		<thead>
		<tr>
			<th>Scarica</th>
			<th>Versione</th>
			<th>Descrizione</th>
		</tr>
		</thead>
		<tbody>
<?php	while($row = mysql_fetch_array($res)){ ?>
			<TR>
			<td><button class="waves-effect waver-light btn center" onclick="doDownload(<?php echo($row['VERSIONE']); ?>)">Download</button></td>
			<td><?php echo($row['VERSIONE']); ?></td>
			<td><?php echo(str_replace("\n", '<br />', $row['DESCRIZIONE'])); ?></td>
<?php 	}	?>
			</TR>
		</tbody>
        </table>
		<script>
			function doDownload(ver){
				window.location.href = "download_app.php?ver=" + ver;
			}
		</script>
	</div>
</body>
		<?php
		}
	} catch(Exception $e){
		echo($e);
	}
?>