<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
	session_start();
	session_regenerate_id(true);
	$time = 84;
	$memory = 4097;
	$threads = 1;
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Регистрация</h1>
<?php
	if(!isset($_POST['user']) || !isset($_POST['pass1']) || !isset($_POST['pass2']) || !isset($_POST['captcha'])){
		goto form;
	}
	// проверка за Captcha
	if($_SESSION['captcha']!=$_POST['captcha']){
		echo 'Невалиден security code';
		goto form;
	}
	if(!preg_match("/^[a-zA-Z0-9_-]{4,32}$/", $_POST['user'])){
		echo 'Въвеждайте от 4 до 32 символа a-z, A-Z, 0-9, - или _<br /><br />';
		goto form;
	}
	//... аналогични проверки дали паролата е достатъчно дълга и сигурна
	if($_POST['pass1'] !== $_POST['pass2']){
		echo 'Паролите не съвпадат<br /><br />';
		goto form;		
	}
	//...
	$user = $_POST['user'];
	$pass = password_hash($_POST['pass1'].PEPPER, PASSWORD_ARGON2ID, 
						  ['memory_cost'=>$memory, 'threads'=>$threads, 'time_cost'=>$time]);
	
	/*$pass = hash("sha256", PEPPER.$_POST['pass1']);
	for($i=0; $i<3000000; $i++){
		$pass = hash("sha256", $user.$pass);
	}	
		
	$salt = openssl_random_pseudo_bytes(16);
	$pass = hash("sha256", $pass.$salt);
	$salt = bin2hex($salt);
	*/
	$link = @mysqli_connect("localhost", "register", "gfdghuiw52", "osup2021");
	@mysqli_set_charset($link, "ascii");
	$user = @mysqli_real_escape_string($link, $user);
	$pass = @mysqli_real_escape_string($link, $pass);
	
	if(!$link){
		echo 'Database maintenance';
		exit;
	}
	$sql = 'INSERT INTO users(user, pass) VALUES
			("'.$user.'",
			 "'.$pass.'"
			)';

	$result = @mysqli_query($link, $sql);
	if(!$result){
		echo 'Изберете друго потребителско име';
		goto form;
	}
	echo 'Регистрирахте се успешно!<br /><br />';
	goto loginlink;
form: ?><form action="register.php" method="POST">
	Username: <input type="text" name="user" /><br />
	Pass once: <input type="password" name="pass1" /><br />
	Pass again: <input type="password" name="pass2" /><br />
	<img src="captcha.php" alt="security code" /><br />
	Security code: <input type="text" name="captcha" /><br />
	<input type="submit" name="submit" value="Регистрирай!" />
</form>
<?php loginlink: ?><p><a href="index.php">Връзка за вход</a></p>
</body>
</html>