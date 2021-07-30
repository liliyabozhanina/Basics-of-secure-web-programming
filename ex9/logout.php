<?php
	require("./includes/header.php");
	
	if(!isset($_GET['xsrf_dynamic']) || !isset($_GET['xsrf_signed'])
			||
	   $_GET['xsrf_signed']!==hash_hmac("sha256", $_GET['xsrf_dynamic'], $_SESSION['xsrftoken'])
	){
		echo 'I will NOT log you out!';
	}
	else{
		session_destroy();
		echo 'Излязохте успешно.<br /><br />';
		echo '<a href="index.php">Влезте отново</a>';
	}
	echo "<br />".$_GET['xsrf_signed']."<br />".hash_hmac("sha256", $_GET['xsrf_dynamic'], $_SESSION['xsrftoken']);
	require("./includes/footer.php");
?>