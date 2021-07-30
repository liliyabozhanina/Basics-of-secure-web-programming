<?php
	DEFINE("SDKWEBS_KEY", "fduhghsduiht423ghgf");
	session_set_cookie_params(["samesite" => "None"]);
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
	
	header("Content-Security-Policy: default-src 'self';frame-src 'self' https://www.youtube.com; script-src 'self' 'unsafe-inline'");
	
	$xsrf_dynamic = base64_encode(openssl_random_pseudo_bytes(32));
	$xsrf_signed  = hash_hmac("sha256", $xsrf_dynamic, $_SESSION['xsrftoken']);
?><!DOCTYPE html>
<html lang="bg-BG">
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> 
<meta http-equiv="Pragma" content="no-cache" /> <meta http-equiv="Expires" content="0" />
<title><?=$_SESSION['user']?></title>
<link rel="stylesheet" href="./includes/style.css" type="text/css" media="all" />
<script src="./dynjs/user.js"></script>
</head>
<body>
<div class="wrapper">
	<div class="search">
		<form action="search.php" method="GET">
			<input type='text' name='search' value='<?=trim(htmlentities($_GET['search']??"", ENT_QUOTES | ENT_HTML5, "UTF-8"))?>' />
			<input type="submit" name="submit" value="Търси" />
		</form>
	</div>
	<div class="contents">