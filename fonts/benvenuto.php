<?php
session_start();
echo "il tuo username e'" . $_SESSION["user"] . "<br>";
print_r($_SESSION);
?>
<BR><BR><a href="index.php">VAI!</a>
