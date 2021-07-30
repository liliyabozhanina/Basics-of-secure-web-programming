<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
	DEFINE("CIPHER", "aes-256-ctr");
	DEFINE("AESKEY", 'RE43kl34*&rEweAdYtNnPP[]qwSA7&43');
	
	session_start();
	session_regenerate_id(true);
	
	$_SESSION['error']=0;
	
	
	if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
		$user = openssl_decrypt($_COOKIE['user'], CIPHER, AESKEY, 0, base64_decode($_COOKIE['civ']));
		$pass = openssl_decrypt($_COOKIE['pass'], CIPHER, AESKEY, 0, base64_decode($_COOKIE['civ'])).PEPPER;	
	}
	else if(isset($_POST['user']) && isset($_POST['pass'])){
		$user = $_POST['user'];
		$pass = $_POST['pass'].PEPPER;
	}
	else{
		header("Location: index.php");
		exit;			
	}


	if(!preg_match("/^[a-zA-Z0-9_-]{4,32}$/", $user)){
		$_SESSION['error'] = '1';
		setcookie("user", "", mktime(0,0,0,1,1,1970));
		setcookie("pass", "", mktime(0,0,0,1,1,1970));
		header("Location: index.php");
		exit;		
	}
	
	
	$link = @mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
	@mysqli_set_charset($link, "ascii");
	//$user = @mysqli_real_escape_string($link, $user);

	
	if(!$link){
		echo 'Database maintenance';
		exit;
	}
	$sql = 'SELECT id, pass FROM users WHERE user = ?';
			
	$statement = mysqli_stmt_init($link);
	mysqli_stmt_prepare($statement, $sql);
	mysqli_stmt_bind_param($statement, "s", $user);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $row['id'], $row['pass']);
	mysqli_stmt_fetch($statement);
	if(!isset($row['id'])){
		$_SESSION['error'] = '1';
		setcookie("user", "", mktime(0,0,0,1,1,1970));
		setcookie("pass", "", mktime(0,0,0,1,1,1970));
		header("Location: index.php");
		exit;
	}

	if(!password_verify($pass, $row['pass'])){
		$_SESSION['error'] = '1';
		setcookie("user", "", mktime(0,0,0,1,1,1970));
		setcookie("pass", "", mktime(0,0,0,1,1,1970));
		header("Location: index.php");
		exit;
	}	

	$_SESSION['uid'] = $row['id'];
	$_SESSION['user'] = $user;
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['first_login_time'] = (int)time();
	$_SESSION['last_active'] = (int)time();
	
	if(isset($_POST['remember'])){
		$civ = openssl_random_pseudo_bytes(openssl_cipher_iv_length(CIPHER));
		setcookie("user", openssl_encrypt($_POST['user'], CIPHER, AESKEY, 0, $civ), time()+3600);
		setcookie("pass", openssl_encrypt($_POST['pass'], CIPHER, AESKEY, 0, $civ), time()+3600);
		setcookie("civ", base64_encode($civ), time()+3600);
	}
	
	header("Location: securearea.php");	
	exit;
?>