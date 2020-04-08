<?php
	ini_set("display_errors",E_ALL);
	include "MemberClass.php";
	$profile = new MemberClass($_POST);
	echo "<PRE>";
	print_r($profile);
?>