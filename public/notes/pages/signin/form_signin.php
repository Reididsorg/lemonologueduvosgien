<?php 
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Inscription</title>
	</head>
	<body>
		<p>Veuillez définir vos identifiants :</p>
		<form action="signin.php" method="post">
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
				<label for="email">Email : </label>						
				<input type="text" name="email" />
			</div>
			<div>					
				<input type="submit" value="Valider" />
			</div>	
			</p>
		</form>
	</body>
</html>