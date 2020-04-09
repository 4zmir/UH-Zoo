<?PHP 
/* Rdo not have it here, you need to put in in separate file, then the user log out it g*/

if($_COOKIE['user_id']){
	
// set the expiration date to one hour ago
setcookie('user_id', "", time() - 3600);


header("Location: http://www.zoonika.com/index.html?ex=1"); /* Redirect browser to log in page*/

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="sidebar.css">
    <title>Sign In</title>
</head>

<body>
    <div id="sidebar">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="side-ul">
            <li class="side-li"><a class="side" href="index.html">Home</a></li>
            <li class="side-li"><a class="side" href="#">Events</a></li>
            <li class="side-li"><a class="side" href="about.html">About Us</a></li>
        </ul>
    </div>


    <div class="full-page">
        <div class="img-container"></div>
        <div class="container">
            <div class="signin">
                <h1>Sign In</h1>
                <form action="loginScript.php" method="POST">
                
                    <!--<label class = "user" for="username">Username:</label><br>-->
                    <input type="text" placeholder="Username email" name="user_email"><br>

                    <!--<label class = "password" for="password">Password:</label><br>-->
                    <input type="password" placeholder="Password" name="user_password"><br>

                    <button class="submit" type="submit" name="submitbtn">Sign In</button><br>

                </form><br><br><!--<br>-->
                <a class = "underline" href="#">Forgot your password?</a><br>
                <a class = "underline" href="#">Create an account</a><br>
            </div>
        </div>
    </div>

    <script src="sidebar.js"></script>

</body>
</html>
