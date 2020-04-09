<?php

	ini_set("display_errors",E_ALL);
	include "forgotpasswordClass.php";
	$profile = new forgotpasswordClass($_POST);
	//echo "<PRE>";
	//print_r($profile);
?>
