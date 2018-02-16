<?php
function sInizialiMaiuscole($stri) {
// echo "</BR> IniMaiusc 1) stri: $stri</BR>";
	$stri = strtolower(trim($stri));
	$l = strlen($stri);
	if ($l > 0) {
		if ($l == 1) { $stri = strtoupper($stri); }
		else { $stri = strtoupper(substr($stri, 0, 1)) . substr($stri, 1); }
		$i = stripos($stri, " ");
		while (!($i === false)) {
			// CARATTERE CENTRALE
			if ($i < $l) {
				$stri = substr($stri, 0, $i+1) . strtoupper(substr($stri, $i+1, 1)) . substr($stri, ($i+2));
			}
//echo "IniMaiusc 2B) i: $i - l: $l</BR>";
			$i = stripos($stri, " ", $i+1);
		}
	}
//echo "IniMaiusc 3) stri: $stri</BR>";
	return $stri;
}
?>
