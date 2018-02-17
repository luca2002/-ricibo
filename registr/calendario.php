<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<?php include '../menuHead.php'; ?>
	</head>
	<body bgcolor="white">
		<?php include '../menu.php'; ?>
		</br></br></br>
	 	<div class="container">
			<?php
				$ID_NEG_ASS = $_SESSION['ID_NEG_ASS'];
				$m = date('m');
				$y = date('Y');
				include "../funzioni/oDBConn.php";
				$codUscita = oDBConn();
				if (is_numeric($codUscita)) {
					if ($codUscita == 1) { echo("</br>Errore: connessione al DB fallita.</br>"); }
					elseif ($codUscita == 2) { echo("</br>Errore: DB non trovato.</br>"); } // CONNESSIONE ESEGUITA, MA DB NON TROVATO
				} else {
				if (((isset($_SESSION['FLAG_REG'])) AND ($_SESSION['FLAG_REG'] == 0)) AND ($ID_NEG_ASS != "")) {
					$db = $codUscita;
					$sql1 = "SELECT GIORNO_APERTURA FROM TB_APER_EXTRA WHERE ID_NEG_ASS = $ID_NEG_ASS ORDER BY GIORNO_APERTURA";
					$ris_ape = mysqli_query($sql,$sql1);
					$ris_ape_date = array();
					if($ris_ape) {
						$riga = mysqli_fetch_array($ris_ape);
						while($riga) {
							if(date('m', strtotime($riga['GIORNO_APERTURA'])) == $m) {
								array_push($ris_ape_date, date('d', strtotime($riga['GIORNO_APERTURA'])));
							}
							$riga = mysqli_fetch_array($ris_ape);
						}
					}
					$sql2 = "SELECT GIORNO_CHIUSURA FROM TB_CHIUSURA WHERE ID_NEG_ASS = $ID_NEG_ASS ORDER BY GIORNO_CHIUSURA";
					$ris_chiu = mysqli_query($db,$sql2);
					$ris_chiu_date = array();
					if($ris_chiu) {
						$riga = mysqli_fetch_array($ris_chiu);
						while($riga) {
							if(date('m', strtotime($riga['GIORNO_CHIUSURA'])) == $m) {
								array_push($ris_chiu_date, date('d', strtotime($riga['GIORNO_CHIUSURA'])));
							}
							$riga = mysqli_fetch_array($ris_chiu);
						}
					}
				}
				switch($m) {
					case 1:
								 echo('<h6>Gennaio ');
								 break;
					case 2:
								 echo('<h6>Febbraio ');
								 break;
					case 3:
								 echo('<h6>Marzo ');
								 break;
					case 4:
								 echo('<h6>Aprile ');
								 break;
					case 5:
								 echo('<h6>Maggio ');
								 break;
					case 6:
								 echo('<h6>Giugno ');
								 break;
					case 7:
								 echo('<h6>Luglio ');
								 break;
					case 8:
								 echo('<h6>Agosto ');
								 break;
					case 9:
								 echo('<h6>Settembre ');
								 break;
					case 10:
								  echo('<h6>Ottobre ');
								  break;
					case 11:
								  echo('<h6>Novembre ');
								  break;
					case 12:
								  echo('<h6>Dicembre ');
								  break;
				}
				echo($y . '</h6>');
			?>
			<table class="striped">
				<thead>
					<tr>
				 		<td>Luned&igrave;</td>
						<td>Marted&igrave;</td>
						<td>Mercoled&igrave;</td>
						<td>Gioved&igrave;</td>
						<td>Venerd&igrave;</td>
						<td>Sabato</td>
						<td>Domenica</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$g = date('D', strtotime($y . '-' . $m  . '-1'));
						$n = date('t', strtotime($y . '-' . $m  . '-1'));
						$k = 0;
						echo('<tr>');
						if($g != 'Mon')
						{
							$mprv = date('t', $m - 1);
							switch($g) {
								case 'Wed':
													 $mprev = $mprv - 1;
													 break;
								case 'Thu':
													 $mprev = $mprv - 2;
													 break;
								case 'Fri':
													 $mprev = $mprv - 3;
													 break;
								case 'Sat':
													 $mprev = $mprv - 4;
													 break;
								case 'Sun':
													 $mprev = $mprv - 5;
													 break;
							}
							for(; $mprev < $mprv + 1; $mprev++, $k++) {
								echo('<td>' . $mprev . '</td>');
							}
						}
						$j = 1;
						if($ris_ape_date) {
							$d_ape_cont = 0;
							$d_ape = $ris_ape_date[$d_ape_cont];
						}
						if($ris_chiu_date) {
							$d_chiu_cont = 0;
							$d_chiu = $ris_chiu_date[$d_chiu_cont];
						}
						for($i = 0; $i < 6; $i++)	{
							for(; $k < 7; $k++, $j++)	{
								if($j == $d_ape) {
									echo('<td bgcolor="#00FF00">' . $j . '</td>');
									$d_ape_cont++;
									$d_ape = $ris_ape_date[$d_ape_cont];
								}
								else if ($j == $d_chiu) {
									echo('<td bgcolor="#FF0000">' . $j . '</td>');
									$d_chiu_cont++;
									$d_chiu = $ris_chiu_date[$d_chiu_cont];
								}
								else {
									if($j > $n) {
										$j = 1;
									}
									echo('<td>' . $j . '</td>');
								}
							}
							$k = 0;
							echo('</tr>');
							if($i < 6)
								echo('<tr>');
						}
					?>
		 		</tbody>
			</table>
			<?php
				if (!$ris_ape && !$ris_chiu)
					echo('</br>Non ci sono aperture o chiusure extra in questo mese.');
			}
			?>
		</div>
	</body>
</html>
