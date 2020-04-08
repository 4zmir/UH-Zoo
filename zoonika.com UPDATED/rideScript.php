<?php
	ini_set("display_errors",E_ALL);
	include "RideClass.php";
	$profile = new RideClass($_POST);
	echo "<PRE>";
	print_r($profile);
	?>