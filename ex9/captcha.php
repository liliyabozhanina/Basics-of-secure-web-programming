<?php
	session_start();
	header("Content-Type: image/png");
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$randomString = strtolower(base64_encode(openssl_random_pseudo_bytes(3)));
	$_SESSION['captcha'] = $randomString;
	
	$files = glob("./includes/fonts/*.[tT][tT][fF]");
	
	$image = imagecreatetruecolor(200,60);
	$background = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255));
	imagefilledrectangle($image, 0, 0, 200, 60, $background);
	
	for($i=0; $i<strlen($randomString); $i++){
		$font = $files[array_rand($files)];
		$fontcolor = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));
		imagettftext($image, rand(16,24), rand(-30, 30), 11+22*$i, rand(26, 58), $fontcolor, $font, $randomString[$i]);
	}
	
	imagepng($image);
?>