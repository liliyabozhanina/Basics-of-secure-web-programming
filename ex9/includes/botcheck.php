<?php
	function add_ip(){
		$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
		$ip = mysqli_real_escape_string($link, $_SERVER['REMOTE_ADDR']);
		$sql = "INSERT INTO login_logs_hash(ip) 
				VALUES (INET6_ATON('".$ip."'))
				ON DUPLICATE KEY UPDATE attempts = attempts+1";
				
		$result = mysqli_query($link, $sql);	
	}
	
	$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
	$ip = mysqli_real_escape_string($link, $_SERVER['REMOTE_ADDR']);
	$sql = "SELECT 1 AS blocked
			FROM login_logs_hash
			WHERE ip = INET6_ATON('".$ip."')
						AND
				  attempts > 5";
	$result = @mysqli_query($link, $sql);
	$row = @mysqli_fetch_assoc($result);
	if(isset($row['blocked'])){
		echo 'Too many login attempts. Please contact support';
		exit;
	}
?>