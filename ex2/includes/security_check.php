<?php
	session_start();
	session_regenerate_id(true);
	/*if($_SERVER['REMOTE_ADDR']!==$_SESSION['user_ip']){
		echo 'Session fixation';
		exit;
	}*/
	if($_SERVER['HTTP_USER_AGENT']!==$_SESSION['user_agent']){
		echo 'Session fixation';
		exit;
	}
	
	/*
	$timeout = 500;
	$totaltimeout = 1500;
	
	$currenttime = (int)time();
	if(isset($_SESSION['last_active'])){
		if($currenttime - $_SESSION['last_active'] > $timeout){
			echo 'Session activity timeout';
			session_destroy();
			exit;
		}
	}
	$_SESSION['last_active'] = $currenttime;
	
	if($currenttime - $_SESSION['first_login_time'] > $totaltimeout){
		echo 'Permanent session timeout';
		session_destroy();
		exit;
	}
	*/
	
	if(!isset($_SESSION['user'])){
		echo 'Please <a href="index.php">Login</a>';
		exit;
	}
?>