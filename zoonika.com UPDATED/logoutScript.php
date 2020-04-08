<?PHP 

// set the expiration date to one hour ago
setcookie('user_id', "", time() - 3600);


header("Location: index.html"); /* Redirect browser to log in page*/

?>