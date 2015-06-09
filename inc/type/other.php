<?php
    header("Content-type: ".$type);
	echo file_get_contents($filename);
?>