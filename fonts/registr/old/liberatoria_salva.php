<?php
session_start();

$liberatoria = htmlspecialchars($_POST['liberatoria']);
echo "</br> liberatoria=" . $liberatoria;
echo "FLAG_PERSONA >" . $_SESSION['FLAG_PERSONA'] ."<</BR>";
	
if ($liberatoria == 'Accetta') {
	$tmp = $_SESSION['FLAG_PERSONA'];
	if ($tmp == ('R' || 'N' || 'V' || 'A')) { header("location: user.php"); }
}
$_SESSION['FLAG_PERSONA'] == '';
//header("location: ../index.php");

?>
