<?php
	require("./includes/header.php");
	$id = $_GET['id']??1;
	if(!preg_match("/^[0-9]+$/", $id)){
		echo 'No such article';
		exit;		
	}
	$link = @mysqli_connect("localhost", "articles", "gfgfdgfdhgf", "osup2021");
	@mysqli_set_charset($link, "ascii");
	//$id = @mysqli_real_escape_string($link, $id);
	$sql = "SELECT content FROM articles WHERE id=?";
	$statement = mysqli_stmt_init($link);
	mysqli_stmt_prepare($statement, $sql);
	mysqli_stmt_bind_param($statement, "i", $id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $content);
	@mysqli_stmt_fetch($statement);
	echo $content??'No such article';
	require("./includes/footer.php");
?>