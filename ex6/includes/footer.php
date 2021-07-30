</div>
	<div class="header"><h1>Our website</h1></div>
	<div class="menu">
		<a href="securearea.php">Начало</a> |
		<a href="chat.php">Чат</a> |
		<a href="profile.php?user=<?=$_SESSION['user']?>">Профил</a> |
		<a href="logout.php">Изход</a>
	</div>
	<div class="lsidebar">
		<?php
			$link = @mysqli_connect("localhost", "articles", "gfgfdgfdhgf", "osup2021");
			@mysqli_set_charset($link, "ascii");
			$sql = "SELECT id FROM articles";
			$statement = mysqli_stmt_init($link);
			mysqli_stmt_prepare($statement, $sql);
			mysqli_stmt_execute($statement);
			mysqli_stmt_bind_result($statement, $ids);
			while(mysqli_stmt_fetch($statement)){
				echo '<a href="articles.php?id='.$ids.'">Статия '.$ids.'</a><br />';
			}
		?>
	</div>
	<div class="footer">Copyright 2021</div>
</div>
</body>
</html>
<!-- 
<?php 
	$rand = rand(0,100);
	echo generateRandomString($rand);
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/=';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
?>
 -->