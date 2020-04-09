<?php
	ini_set("display_errors",E_ALL);
	include "SupAdminClass.php";
	$profile = new SupAdminClass($_POST);
	echo "<PRE>";
	print_r($profile);
	?>