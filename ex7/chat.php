<?php
	require("./includes/header.php");
?>
<form action="chat_post.php" method="POST">
	<input type="text" name="message" />
	<input type="hidden" name="xsrf_dynamic" value="<?=$xsrf_dynamic?>" />
	<input type="hidden" name="xsrf_signed" value="<?=$xsrf_signed?>" />
	<input type="submit" name="submit" value="Изпрати" />
</form>
<?php
	echo "<p>";
	$link = @mysqli_connect("localhost", "chat", "gfdsgfdshdfhjgf", "osup2021");
	@mysqli_set_charset($link, "utf8mb4");
	$sql = "SELECT user, message, posted_on FROM chat_php LIMIT 20";
	$statement = mysqli_stmt_init($link);
	mysqli_stmt_prepare($statement, $sql);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $cuser, $cmessage, $cposted_on);
	while(mysqli_stmt_fetch($statement)){
		echo $cposted_on." ".htmlentities($cuser, ENT_QUOTES | ENT_HTML5, "UTF-8").": ".htmlentities($cmessage, ENT_QUOTES | ENT_HTML5, "UTF-8")."<br />";
	}
	echo "</p>";
	require("./includes/footer.php");
?>