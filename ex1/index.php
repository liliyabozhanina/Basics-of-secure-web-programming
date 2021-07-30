<?php
	session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Добре дошли</h1>
<?php
/*	if(isset($_GET['error']) && $_GET['error']==1){
		echo 'Невалидно име или парола<br /><br />';
	}
*/
	if(isset($_SESSION['error']) && $_SESSION['error']==1){
		echo 'Невалидно име или парола<br /><br />';
	}
?>
<form action="login.php" method="POST">
	Username: <input type="text" name="user" /><br />
	Password: <input type="password" name="pass" /><br />
	<input type="submit" name="submit" value="Вход!" />
</form>
<p><a href="register.php">Нямате акаунт?</a></p>
</body>
</html>