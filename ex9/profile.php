<?php
	require("./includes/header.php");
?>
<p id="profileArea">
<?php
	$link = mysqli_connect("localhost", "login", "fjidsgjfdisgjf", "osup2021");
	$sql = "SELECT user FROM users";
	$result = mysqli_query($link, $sql);
	while(($row = mysqli_fetch_assoc($result))!=null){
		echo '<a href="profile.php?user='.$row['user'].'">'.$row['user'].'</a><br />';
	}
?></p>
<script>
	var currentSearch = document.location.search;
	var searchParams = new URLSearchParams(currentSearch);
	var username = searchParams.get('user');
	
	if(username!=null){
		document.getElementById('profileArea').innerHTML = 'Профилът на '+username+'<br /><br /><br /><br /><a href="http://localhost./profile.php">Виж други профили</a>';
	}
</script>
<iframe width="560" height="315" src="https://www.youtube.com/embed/5qap5aO4i9A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php
	require("./includes/footer.php");
?>