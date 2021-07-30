<?php
	if(isset($_COOKIE['token']) && isset($_COOKIE['series']) && isset($_COOKIE['user'])){
		header("Location: login.php");
		exit;
	}
	session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./includes/indexstyle.css" type="text/css" media="all" />
<script>
	function stopTab(e){
		var evt = e || window.event;
		if(evt.keyCode === 9){
			return false;
		}
	}
</script>
</head>
<body>
<div style="text-align:center;"><img src="logo.jpg" /></div>
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
	Username: <input id="user" type="text" name="user" placeholder="Потребителско име" /><br />
	Password: <input id="pass" type="password" name="pass" placeholder="Вашата парола" onkeydown="return stopTab(event);" /><br />
	<input id="email" type="text" name="email" placeholder="Не попълвайте това"  /><br />
	<input type="submit" name="submit" value="Вход!" /> Remember? <input type="checkbox" name="remember" value="yes" />
</form>
<p><a href="register.php">Нямате акаунт?</a></p>
<p><a href="http://localhost./MotoMix.7z">http://localhost./MotoMix.7z</a></p>
</body>
</html>