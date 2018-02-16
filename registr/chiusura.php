<!DOCTYPE html>
<html>
	<head>
		<title> RiCibo </title>
<link rel="shortcut icon" href="/~ricibo/img/favicon.ico" />
<!--Import Google Icon Font-->
<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.css"  media="screen,projection"/>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/~ricibo/js/materialize.min.js"></script>
<script type="text/javascript" src="/~ricibo/js/init.js"></script>
		<link type="text/css" rel="stylesheet" href="/~ricibo/css/materialize.clockpicker.css" media="screen,projection" />
		<script src="/~ricibo/js/materialize.clockpicker.js"></script>
	</head>
	<body bgcolor="white">
		<nav class="light-blue lighten-1" role="navigation">
<div class="nav-wrapper">
<div class="container"><a href="/~ricibo/index.php" id="logo-container" class="brand-logo"><img src="/~ricibo/img/logo-trasparente.jpg"></a></div><ul class="right hide-on-med-and-down"><li><a href="/~ricibo/index.php">Home</a></li><li><a href="/~ricibo/chisiamo.php">Chi siamo</a></li><li><a href="/~ricibo/cosafacciamo.php">Cosa Facciamo</a></li><li><a href="/~ricibo/mappa.php">Mappa Del Sito</a></li><li><a href="/~ricibo/contattaci.php">Contattaci</a></li><li><a href="/~ricibo/login.php">Login</a></li>	</ul>
	<ul id="nav-mobile" class="side-nav">
<li><a href="/~ricibo/index.php">Home</a></li><li><a href="/~ricibo/chisiamo.php">Chi siamo</a></li><li><a href="/~ricibo/cosafacciamo.php">Cosa Facciamo</a></li><li><a href="/~ricibo/mappa.php">Mappa Del Sito</a></li><li><a href="/~ricibo/contattaci.php">Contattaci</a></li><li><a href="/~ricibo/login.php">Login</a></li>	</ul>
	<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
	</div>
</div>
</nav>
	  <form action="chiusura_salva.php" METHOD="POST">
		  </br></br>
	    <div class="container">
				        </br></br>
			I turni di chiusura vanno indicati inserendo 00:00 sia come orario di apertura che di chiusura.
        <table class="bordered">
          <thead>
            <tr>
              <th>Giorno</th>
              <th>Orario mattina</th>
              <th>Orario pomeriggio</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="input-field col s12">
                    <i class="material-icons prefix">today</i>
                    <input type="date" name="DATA" class="datepicker" value="1970-01-01">
                    <label for="icon_prefix">Data</label>
                </div>
              </td>
              <td>
                <div class="input-field inline">
                    <label for="ORA1_APER">Ora inizio</label>
                    <input name="ORA1_APER" id="ORA1_APER" class="timepicker"  value="01:00">
                </div>
                <div class="input-field inline">
                    <label for="ORA1_CHIU">Ora fine</label>
                    <input name="ORA1_CHIU" id="ORA1_CHIU" class="timepicker"  value="02:00">
                </div>
              </td>
              <td>
                <div class="input-field inline">
                    <label for="ORA2_APER">Ora inizio</label>
                    <input name="ORA2_APER" id="ORA2_APER" class="timepicker"  value="03:00">
                </div>
                <div class="input-field inline">
                    <label for="ORA2_CHIU">Ora fine</label>
                    <input name="ORA2_CHIU" id="ORA2_CHIU" class="timepicker"  value="04:00">
                </div>
              </td>
            </tr>
            </tr>
          </tbody>
        </table>
        </br>
				<button class="waves-effect waves-light btn" type="submit" value="SALVA">Salva
						<i class="material-icons right">send</i>
				</button>
			</br></br>
      </div>
	  </form>
  </body>
</html>
