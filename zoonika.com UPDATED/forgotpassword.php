<?PHP 


if(isset($_GET['nm'])){
	echo "<div class='alert alert-danger'><strong>Password does not match.</div>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="sidebar.css">
</head>

<body>

    

    <header id="imgcontainer"></header>
    <div id="container">
        <h1>Forgot Password</h1>

        <form  id="submit" action="forgotpasswordScript.php" method="POST">

            <label for="user_email">User Name:</label><br>
            <input type="text" placeholder="Username email" name="user_email" required><br>

            <label for="user_DOB">Date of birth:</label><br>
            <input type="date" placeholder="YYYY-MM-DD" name="user_DOB" value="YYYY-MM-DD" required><br>

	    <label for="user_password">Password:</label><br>
            <input type="text" placeholder="New Password" name="user_password" required><br>
		
	    <label for="passwordConfirm">Confirm Password:</label><br>
            <input type="text" placeholder="Confirm New Password" name="passwordConfirm" required><br>		

                        

            <button class="cancel" type="button" onclick="location.href='login.html'">Cancel</button >
            <button class="button" type="submit">Submit</button >
			

        </form>
    </div>

    <script src="sidebar.js"></script>
</body>

</html>
