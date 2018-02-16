<?php
function sCheckOra($sOra) {
//echo "</BR>sCheckOra >$sOra<  lenstr: ".strlen($sOra);
	if ($sOra == NULL) { $sOra = "00:00"; }
	else {
//echo "</BR>sCheckOra1 >$sOra<";
		if (strlen($sOra) < 3) { $sOra .= ":00"; }
		$i = stripos($sOra, ":", 0);
		if ($i == 1) { $sOra = "0" . $sOra; }
		else if (strlen($sOra) == 7) { $sOra = substr($sOra, 0, 4); }
		else if (strlen($sOra) == 8) { $sOra = substr($sOra, 0, 5); }
	}
//echo "</BR>sFormattaOra rende >$sOra<";
	return $sOra;	
}
?>
