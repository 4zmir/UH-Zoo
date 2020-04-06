<?PHP 

// set the expiration date to one hour ago
setcookie('user_id', "", time() - 3600);


header("Location: http://www.zoonika.com/index.html?lo=1"); /* Redirect browser to log in page*/

?>