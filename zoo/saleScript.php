<?php
	ini_set("display_errors",E_ALL);
	include "SaleClass.php";
	$profile = new SaleClass($_POST);
	echo "<PRE>";
	print_r($profile);
	?>