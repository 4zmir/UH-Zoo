<?php
	ini_set("display_errors",E_ALL);
	include "AddAnimalClass.php";
	$profile = new AddAnimalClass($_POST);
	echo "<PRE>";
	print_r($profile);
	?>