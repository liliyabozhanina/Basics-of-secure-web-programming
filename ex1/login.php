<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
	session_start();
	session_regenerate_id(true);
	$_SESSION['error']=0;
	
	$user = $_POST['user'];
	$pass = hash("sha256", PEPPER.$_POST['pass']);
	for($i=0; $i<3000000; $i++){
		$pass = hash("sha256", $user.$pass);
	}
	
	if(mb_strlen($_POST['user'])>32 || mb_strlen($_POST['user'])>64){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;		
	}
	
	$link = @mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
	if(!$link){
		echo 'Database maintenance';
		exit;
	}
	$sql = 'SELECT id, pass, salt
			FROM users
			WHERE user="'.$user.'"';
	$result = @mysqli_query($link, $sql);
	if(!$result){
		echo 'Database maintenance';
		exit;
	}
	$row = @mysqli_fetch_assoc($result);
	if(!isset($row['id'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}
	if(bin2hex($row['pass']) !== hash("sha256", $pass.$row['salt'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}
	$_SESSION['uid'] = $row['id'];
	$_SESSION['user'] = $user;
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['first_login_time'] = (int)time();
	$_SESSION['last_active'] = (int)time();
	header("Location: securearea.php");	
	exit;
	
	
	/*
	
	if(($user == 'ivan' && $pass == '123456')
			||
	   ($user == 'petar' && $pass == 'password')
	){
		$_SESSION['user'] = $user;
		//$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['first_login_time'] = (int)time();
		header("Location: securearea.php");
	}
	else{
		$_SESSION['error'] = '1';
		header("Location: index.php");
	}
	*/
?>