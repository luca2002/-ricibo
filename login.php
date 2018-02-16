<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'menuHead.php'; ?>
	</head>
	<style>

		.checkbox-orange[type="checkbox"].filled-in:checked + label:after{
			border: 2px solid orange;
			background-color: orange;
			font-family: 'Roboto', sans-serif;
		}
		.input-field input[type=text]:focus + label {
			color: #FF9F0F;
		}
		.input-field input[type=password]:focus + label {
			color: #FF9F0F;
		}
		.input-field input[type=text]:focus {
			border-bottom: 1px solid #FF9F0F;
			box-shadow: 0 1px 0 0 #FF9F0F;
		}
		.input-field input[type=password]:focus {
			border-bottom: 1px solid #FF9F0F;
			box-shadow: 0 1px 0 0 #FF9F0F;
		}
		.input-field input[type=text].valid {
			border-bottom: 1px solid #FF9F0F;
			box-shadow: 0 1px 0 0 #FF9F0F;
		}
		.input-field input[type=password].valid {
			border-bottom: 1px solid #FF9F0F;
			box-shadow: 0 1px 0 0 #FF9F0F;
		}
	</style>
<body bgcolor="white">
	<?php include 'menu.php'; ?>
	<br><br><br>
	<form method="post" action="loginCheck.php">
	<br>
	<div class="container">
		<div class="input-field col s6">
			<input name="USER" type="text" class="validate">
			<label for="USER">Nome utente</label>
		</div>
		<div class="input-field col s12">
			<input name="PWD" type="password" class="validate">
			<label for="PWD">Password</label>
		</div>
		<p>
			<input type="checkbox" class="filled-in checkbox-orange" id="remember"/>
			<label for="remember">Vuoi restare connesso?</label>
		</p>
		<br> <br>
		<button class="waves-effect waves-light btn" type="login" name="login">Accedi
			<i class="material-icons right">send</i>
		</button>
		</div>
	</form>
</body>
</html>
