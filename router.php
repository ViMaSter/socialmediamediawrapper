<?php

	if (!is_null($_GET["dev"]))
	{
		include "inc/proxy/dev.php";
	}
	else
	{
		include "inc/proxy/regular.php";
	}
?>
