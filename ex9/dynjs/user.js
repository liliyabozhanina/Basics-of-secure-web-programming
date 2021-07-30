<?php
	//session_start();
	header("Content-Type: application/javascript");
	if(!isset($_SESSION['user'])){
		exit;
	}
?>
window.onload = function(){
	init();
}
function init(){
	var user = "<?=$_SESSION['user']?>";
	user = addHello(user);
	document.getElementsByTagName("h1")[0].innerHTML = user;
}

function addHello(user){
	user = "Hello " + user;
	return user;
}