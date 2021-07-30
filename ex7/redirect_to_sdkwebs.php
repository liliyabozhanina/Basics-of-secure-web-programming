<?php
	DEFINE("SDKWEBS_KEY", "fduhghsduiht423ghgf");
	session_start();
	session_regenerate_id(true);
	if(!isset($_SESSION['user'])){
		header("Location: index.php");
		exit;
	}
	
	$nonce = base64_encode(openssl_random_pseudo_bytes(32));
	$current_time = ceil(time()/30)*30;
	$timed_sign = hash_hmac("sha256", $_SESSION['user'], $current_time.$nonce);
	$final_sign = hash_hmac("sha256", $timed_sign, SDKWEBS_KEY);
	header("Location: http://sdkwebs.com/x.php?user=".$_SESSION['user']."&hmac=".$final_sign."&nonce=".$nonce);

?>

