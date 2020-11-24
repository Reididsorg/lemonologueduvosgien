<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Identification</title>
	</head>
	<body>
		<p>Veuillez saisir vos identifiants :</p>
		<form action="login.php" method="post">
			<p>
			<div>
				<label for="pseudo">Pseudo : </label>
				<input type="text" name="pseudo" />
			</div>
			<div>
				<label for="password">Password : </label>
				<input type="password" name="password" />
			</div>
			<div>
				<input type="submit" value="Valider" />
			</div>	
			</p>
		</form>
	</body>
</html>