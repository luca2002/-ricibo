<body><html>
TEST LETTURA
<?php
/* INFO DB */
$DBhost = "localhost";
$DBuser = "ricibo";
$DBpass = "pwd-cibo17";
$DBName = "ricibo";
$DBtable = "APP_TEST";
$db = mysql_connect($DBhost, $DBuser, $DBpass);
if(!$db){
	echo "</BR>Connection to DB Failed.";
	return;
} else {
	echo "</BR>Connection to DB OK!";
}
$ris = mysql_select_db($DBName);
if(!$ris){
	echo("</BR>Error: Database not found");
	return;
} else {
	echo "</BR>Database found!";
}
$date= new datetime();
$stri= $date->format('Y-m-d H:i:s');
$sql = "INSERT INTO APP_TEST (CEL, GPS_X, GPS_Y, DATA_INS) VALUES ('3331234567', 81.12345, 18.6789, '$stri')";
echo "</BR>$sql";

$risultato_query = mysql_query($sql, $db);
if($risultato_query){
	echo "</BR>OK!";
}else{
	echo("</BR>Error: " . mysql_error($db));
}
mysql_close($db);
?>
</br></br>FINE PAGINA!
</html></body>
