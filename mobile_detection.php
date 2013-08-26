<?php
	if(! empty($_SERVER['HTTP_USER_AGENT'])){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if( preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent) ){
			header('Location: ./mobile/');
		}
	}
?>