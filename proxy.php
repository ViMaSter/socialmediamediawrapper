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

	$filename = array_pop($query);

	// Gracefully close connection when no file was found
	if (!is_file($filename))
	{
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                require_once("404.php");
		die();
	}

	// Gather type info
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $filename);
    finfo_close($finfo);

	if ($directQuery)
	{
        // Send expected content
        header("Content-type: ".$type);
        echo file_get_contents($filename);
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
