<?php
	$time_target = 0.2;
	$time = 74;
	$memory = 4097;
	$threads = 1;
	$hash = password_hash('password', PASSWORD_ARGON2ID,
					  ['memory_cost'=>$memory, 'threads'=>$threads, 'time_cost'=>$time]);
	echo $hash.'<br />'.strlen($hash);
?>