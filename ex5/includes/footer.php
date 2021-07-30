</div>
	<div class="header"><h1>Our website</h1></div>
	<div class="menu">
		<a href="securearea.php">Начало</a> |
		<a href="chat.php">Чат</a> |
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