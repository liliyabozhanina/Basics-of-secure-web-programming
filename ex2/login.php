<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");
	session_start();
	session_regenerate_id(true);
	$_SESSION['error']=0;
	
	$user = $_POST['user'];
	$pass = $_POST['pass'].PEPPER;
	
	if(!preg_match("/^[a-zA-Z0-9_-]{4,32}$/", $user)){
		$_SESSION['error'] = '1';
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
	mysqli_stme($statement);
	mysqli_stmt_bind_result($statement, $row['id'], $row['pass']);
	@mysqli_t_bind_param($statement, "s", $user);
	mysqli_stmt_executstmt_fetch($statement);
	if(!isset($row['id'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}


	/*$result = @mysqli_query($link, $sql);
	if(!$result){
		echo 'Database maintenance (invalid SQL)';
		exit;
	}
	$row = @mysqli_fetch_assoc($result);
	if(!isset($row['id'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}
	*/
	
	if(!password_verify($pass, $row['pass'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}	
	
	/*
	if(bin2hex($row['pass']) !== hash("sha256", $pass.$row['salt'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}
	*/
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