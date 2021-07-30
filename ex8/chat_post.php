<?php
	session_start();
	session_regenerate_id(true);
	if(!isset($_SESSION['user'])){
		header("Location: index.php");
		exit;
	}
	
	if($_SERVER['HTTP_USER_AGENT']!==$_SESSION['user_agent']){
		echo 'Session fixation';
		exit;
	}
	/*
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!="http://localhost./chat.php"){
		echo 'XSRF attack!';
		exit;
	}
	*/
	/*
	if(!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN']!="http://localhost."){
		echo 'XSRF attack!';
		exit;
	}
	*/
	
	if(!isset($_POST['xsrf_dynamic'])
		||
	   !isset($_SESSION['xsrftoken'])
	    || 
	   !isset($_POST['xsrf_signed'])
		||
	   $_POST['xsrf_signed']!==hash_hmac("sha256", $_POST['xsrf_dynamic'], $_SESSION['xsrftoken'])
	){
		echo 'XSRF attack!';
		exit;	
	}
	
	if(!isset($_POST['message'])){
		header("Location: chat.php");
		exit;
	}
	
	if(trim($_POST['message'])==""){
		header("Location: chat.php");
		exit;
	}
	
	$link = @mysqli_connect("localhost", "chat", "gfdsgfdshdfhjgf", "osup2021");
	@mysqli_set_charset($link, "utf8mb4");
	$sql = "INSERT INTO chat_messages(uid, message) VALUES(?,?)";
	$statement = mysqli_stmt_init($link);
	mysqli_stmt_prepare($statement, $sql);
	mysqli_stmt_bind_param($statement, "is", $_SESSION['uid'], $_POST['message']);
	mysqli_stmt_execute($statement);
	header("Location: chat.php");
	exit;
?>