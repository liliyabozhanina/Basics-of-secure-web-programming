<?php
	require("./includes/header.php");
	
	session_destroy();
	echo 'Излязохте успешно.<br /><br />';
	echo '<a href="index.php">Влезте отново</a>';
	require("./includes/footer.php");
?>