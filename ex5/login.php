<?php
	DEFINE("PEPPER", "g5reoi52ju5r34jgiths");

	session_start();
	session_regenerate_id(true);
	
	$_SESSION['error']=0;
	
	if(isset($_COOKIE['token'])&& isset($_COOKIE['series']) && isset($_COOKIE['user'])){
		$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
		@mysqli_set_charset($link, "ascii");
		$sql = 'SELECT users_tokens.uid, users.user, users_tokens.token
				FROM users_tokens 
				JOIN users ON users_tokens.uid = users.id
				WHERE users_tokens.series = UNHEX(?)
						AND
					  users.user = ?';
		$statement = mysqli_stmt_init($link);
		mysqli_stmt_prepare($statement, $sql);
		mysqli_stmt_bind_param($statement, "ss", hash("sha256", PEPPER.$_COOKIE['series']), $_COOKIE['user']);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $rowid, $rowuser, $rowtoken);
		mysqli_stmt_fetch($statement);
		if(isset($rowid) && isset($rowuser) && isset($rowtoken)){
			if(bin2hex($rowtoken) !== hash("sha256", $_COOKIE['token'].PEPPER)){
				echo 'You account is probably hacked! Please contact support!';
				exit;
			}
			
			$_SESSION['uid'] = $rowid;
			$_SESSION['user'] = $rowuser;
			$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['first_login_time'] = (int)time();
			$_SESSION['last_active'] = (int)time();
			
			$newtoken = bin2hex(openssl_random_pseudo_bytes(32));
			mysqli_close($link);
			$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
			@mysqli_set_charset($link, "ascii");
			$sql = 'UPDATE users_tokens
					SET token = UNHEX(?),
						expires_at = DATE_ADD(NOW(), INTERVAL 1 HOUR)
					WHERE uid = ? AND token = UNHEX(?)';
			$statement = mysqli_stmt_init($link);
			mysqli_stmt_prepare($statement, $sql);
			mysqli_stmt_bind_param($statement, "sis", $newtoken, $_SESSION['uid'], $_COOKIE['token']);
			if(mysqli_stmt_execute($statement)){
				setcookie("user", $_SESSION['user'], time()+3600);
				setcookie("token", $newtoken, time()+3600);
				setcookie("series", $_COOKIE['series'], time()+3600);
			}

			header("Location: securearea.php");
			exit;
		}
		else{
			setcookie("user", "", mktime(0,0,0,1,1,1970));
			setcookie("token", "", mktime(0,0,0,1,1,1970));
			setcookie("series", "", mktime(0,0,0,1,1,1970));
			header("Location: index.php");
			exit;			
		}
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
		header("Location: index.php");
		exit;
	}

	if(!password_verify($pass, $row['pass'])){
		$_SESSION['error'] = '1';
		header("Location: index.php");
		exit;
	}	
	mysqli_close($link);


	$_SESSION['uid'] = $row['id'];
	$_SESSION['user'] = $user;
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
	$_SESSION['first_login_time'] = (int)time();
	$_SESSION['last_active'] = (int)time();
	
	if(isset($_POST['remember'])){
		$token = bin2hex(openssl_random_pseudo_bytes(32));
		$series = bin2hex(openssl_random_pseudo_bytes(32));
		
		
		$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
		@mysqli_set_charset($link, "ascii");
		$sql = 'INSERT INTO users_tokens(uid, token, series) VALUES(?,UNHEX(?), UNHEX(?))';
		$statement = mysqli_stmt_init($link);
		mysqli_stmt_prepare($statement, $sql);
		mysqli_stmt_bind_param($statement, "iss", $_SESSION['uid'], 
							   hash("sha256", $token.PEPPER), hash("sha256", PEPPER.$series));
		if(mysqli_stmt_execute($statement)){
			setcookie("user", $_SESSION['user'], time()+3600);
			setcookie("token", $token, time()+3600);
			setcookie("series", $series, time()+3600);
		}
	}
	
	header("Location: securearea.php");	
	exit;
?>