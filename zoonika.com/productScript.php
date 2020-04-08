<?php
	ini_set("display_errors",E_ALL);
	include "ProductClass.php";
	$profile = new ProductClass($_POST);
	echo "<PRE>";
	print_r($profile);
	?>