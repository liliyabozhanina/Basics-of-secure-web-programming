<?php
	require("./includes/header.php");
	if(isset($_GET['search']) && !trim($_GET['search'])==""){
		echo '<h2>Потърсите за '.trim(htmlentities($_GET['search'],  ENT_QUOTES | ENT_HTML5, "UTF-8")).'</h2>';
		echo '<p>...</p>';
	}
	else{
		echo 'Моля въведете текст във формата за търсене';
	}

	require("./includes/footer.php");
?>