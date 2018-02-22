<?php
// SE IN PRODUZIONE, RICHIAMO LO SCRIPT DI GOOGLE ANALITYCS
// if ($bSviluppo) { echo "bvisluppo=true</br>"; } else { echo "bvisluppo=false</br>"; }
if (!$bSviluppo) { include_once("analyticsTracking.php"); }
// CHECK SE L'UTENTE E' LOGGATO
if (isset($_SESSION['USER'])) { $bLoggato = true; } else { $bLoggato = false; }
//if ($bLoggato == true) { echo "SI"; } else { echo "NO"; }
//echo("bLoggato >$bLoggato<</BR>"); 
?>
<nav class="light-blue lighten-1" role="navigation">
<div class="nav-wrapper">
<?php
echo("<div class=\"container\"><a href=\"$PATH/index.php\" id=\"logo-container\" class=\"brand-logo\"><img src=\"$PATH/img/logo-trasparente.jpg\"></a></div>");
echo("<ul class=\"right hide-on-med-and-down\">");
if (isset($_SESSION["ID_PERMESSO"])) {
	$_SESSION['FLAG_DEBUG'] = ($_SESSION['FLAG_SVILUPPO'] OR ($_SESSION['ID_PERMESSO']==1) OR ($_SESSION['ID_PERMESSO']==2));
} else {
	$_SESSION['FLAG_DEBUG'] = $_SESSION['FLAG_SVILUPPO'];
}
// STAMPA TUTTI I FLAG DI CONTROLLO SOLO IN SVILUPPO
if ($_SESSION['FLAG_DEBUG']) {
	if (isset($_SESSION["USER"])) {
	echo ("<li> (A=" . $_SESSION["ID_AREA"] . " U=" . $_SESSION["ID_USER"] . " PE=" . $_SESSION["ID_PERSONA"]);
	echo (" PM=" . $_SESSION["ID_PERMESSO"] . " FP=" . $_SESSION["FLAG_PERSONA"] . " FR=" . $_SESSION["FLAG_REG"]);
	echo (" FU2=" . $_SESSION["FLAG_PRI_SEC"] . " FN2=" . $_SESSION["FLAG_NEG_PRI_SEC"] . ") &nbsp; </li> &nbsp; ");
	}
}
// STAMPA LOGIN UTENTE
$ii=strripos($NomeFile, '/');
$pagina= substr($NomeFile, $ii+1);
if (isset($_SESSION["USER"])) { echo("<li>Utente: " . $_SESSION["USER"] . "</li><li> &nbsp; &nbsp; &nbsp; &nbsp; </li>"); }
// CONTROLLO PAGINA CHIAMATA PER ESCLUDERLA DAL MENU'
if ($pagina!='index.php') { echo("<li><a href=\"$PATH/index.php\">Home</a></li>"); }
if ($bLoggato) { echo("<li><a href=\"$PATH/indexlog.php\">Account</a></li>"); }
if ($pagina!='chisiamo.php') { echo("<li><a href=\"$PATH/chisiamo.php\">Chi siamo</a></li>"); }
if ($pagina!='cosafacciamo.php') { echo("<li><a href=\"$PATH/cosafacciamo.php\">Mission</a></li>"); }
if ((!$bLoggato) && ($pagina!='registrazioni.php')) { echo("<li><a href=\"$PATH/registrazioni.php\">Registrati!</a></li>"); }
if ($pagina!='mappa.php') { echo("<li><a href=\"$PATH/mappa.php\">Mappa</a></li>"); }
if ($pagina!='stampa.php') { echo("<li><a href=\"$PATH/stampa.php\">Stampa</a></li>"); }
if ($pagina!='Contatti.php') { echo("<li><a href=\"$PATH/contatti.php\">Contatti</a></li>"); }
if ($pagina!='login.php'){
	if (isset($_SESSION["USER"]))
		{ echo("<li><a href=\"$PATH/logout.php\">Logout</a></li>"); }
	else
		{ echo("<li><a href=\"$PATH/login.php\">Login</a></li>"); }
}
?>
	</ul>
	<ul id="nav-mobile" class="side-nav">
<?php
if (isset($_SESSION["USER"])) { echo("<li>Utente: " . $_SESSION["USER"] . "</li><li> &nbsp; &nbsp; &nbsp; &nbsp; </li>"); }
if ($pagina!='index.php') { echo("<li><a href=\"$PATH/index.php\">Home</a></li>"); }
if ($bLoggato) { echo("<li><a href=\"$PATH/indexlog.php\">Account</a></li>"); }
if ($pagina!='chisiamo.php') { echo("<li><a href=\"$PATH/chisiamo.php\">Chi siamo</a></li>"); }
if ($pagina!='cosafacciamo.php') { echo("<li><a href=\"$PATH/cosafacciamo.php\">Mission</a></li>"); }
if ((!$bLoggato) && ($pagina!='registrazioni.php')) { echo("<li><a href=\"$PATH/registrazioni.php\">Registrati!</a></li>"); }
if ($pagina!='mappa.php') { echo("<li><a href=\"$PATH/mappa.php\">Mappa</a></li>"); }
if ($pagina!='stampa.php') { echo("<li><a href=\"$PATH/stampa.php\">Stampa</a></li>"); }
if ($pagina!='Contatti.php') { echo("<li><a href=\"$PATH/Contatti.php\">Contatti</a></li>"); }
if ($pagina!='login.php'){
	if (isset($_SESSION["USER"]))
		{ echo("<li><a href=\"$PATH/logout.php\">Logout</a></li>"); }
	else
		{ echo("<li><a href=\"$PATH/login.php\">Login</a></li>"); }
}
?>
	</ul>
	<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
	</div>
</div>
</nav>
