<?php
	$apiKey = "dfe064f3a5af4fd1a9ec31cc597e3b84";
	$apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
	
	header("Content-type: text/html; charset=utf-8");
	$reqInfo = $_GET['que'];
	$url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));
	$res = file_get_contents($url);
	
	echo $_GET['callback'].'('.$res.')';
?>