<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
	session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Регистрация</h1>
<?php
	if(!isset($_POST['user']) || !isset($_POST['pass1']) || !isset($_POST['pass2'])){
		goto form;
	}
	if(mb_strlen($_POST['user'])<4 || mb_strlen($_POST['user'])>32){
		echo 'Прекалено къс или прекалено дълъг username<br /><br />';
		goto form;
	}
	//... аналогични проверки дали паролата е достатъчно дълга и сигурна
	if($_POST['pass1'] !== $_POST['pass2']){
		echo 'Паролите не съвпадат<br /><br />';
		goto form;		
	}
	//...
	$user = $_POST['user'];
	$pass = hash("sha256", PEPPER.$_POST['pass1']);
	for($i=0; $i<3000000; $i++){
		$pass = hash("sha256", $user.$pass);
	}	
		
	$salt = openssl_random_pseudo_bytes(16);
	$pass = hash("sha256", $pass.$salt);
	$salt = bin2hex($salt);
	
	$link = @mysqli_connect("localhost", "register", "gfdghuiw52", "osup2021");
	if(!$link){
		echo 'Database maintenance';
		exit;
	}
	$sql = 'INSERT INTO users(user, salt, pass) VALUES
			("'.$user.'",
			 UNHEX("'.$salt.'"),
			 UNHEX("'.$pass.'")
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
	<input type="submit" name="submit" value="Регистрирай!" />
</form>
<?php loginlink: ?><p><a href="index.php">Връзка за вход</a></p>
</body>
</html>