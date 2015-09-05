<?php
	$query = explode("/", $_GET["query"]);

	// Roughly prepare our absolute path
	$absolutePath = sprintf(
		"%s://%s",
		$_SERVER['HTTPS'] ? "https" : "http",
		$_SERVER["SERVER_NAME"] . (dirname($_SERVER["REQUEST_URI"]) == "/" ? "" : dirname($_SERVER["REQUEST_URI"]))
	);

	// Initialize our variables
	$directQuery = false;
	$filename = "";

	if ($query[0] == "direct")
	{
		$directQuery = true;
		$filename = $query[1];
	}

	$blacklist = json_decode( file_get_contents( "blacklist.json" ) );
	$filename = array_pop($query);


	// Gracefully close connection when no file was found
	//  or the filename is listed in the blacklist
	if (!is_file($filename) || in_array($filename, $blacklist))
	{
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		if (file_exists("404.php"))
		{
			require_once("404.php");
			exit();
		}
		else {
			exit("404");
		}
	}

	// Gather type info
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$type = finfo_file($finfo, $filename);
	finfo_close($finfo);

	if ($directQuery)
	{
		http_send_content_disposition(basename($filename), true);
		http_send_content_type($type);
		http_send_file($filename);
	}
	else
	{
		// Use template based on MIME-type we're serving (ignoring subtype)
		$typeArray = explode("/", $type);
		$typeFile = $typeArray[0];

		$responseType = is_file("inc/type/$typeFile.php") ? $typeArray[0] : "other";

		$canonialURL = "$absolutePath/$filename";
		$directURL = "$absolutePath/direct/$filename";
		include "inc/type/" . $responseType . ".php";
	}
?>
