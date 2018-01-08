<?php
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	header("Location: " . $protocol . $_SERVER['HTTP_HOST'] . "/direct" . $_SERVER["REQUEST_URI"]);
?>