<?PHP
session_start();

include "Database.php";

if(!$_COOKIE['user_id']){
	header('Location: index.php');
}

$db = new Database();

$sql="SELECT * from user where user_id = '$_COOKIE[user_id]'";
$db->query($sql);
$user = $db->single();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Ride</title>
  <link rel="stylesheet" href="product.css">
  <link rel="stylesheet" href="sidebar.css">
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
        <li class="side-li"><a class="side" href="ride_menu.php">Dashboard</a></li>
        <li class="side-li"><a class="side" href="rideList.php">List All Rides</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>
   
   </body>
   <form action="" method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> INPUT NEW RIDE</h1>

          <label for="ride_name"><br>Ride description:</br></label>
		 
          <input type="text" placeholder="Enter ride description" name="ride_name" required><br>
       
      
       <button class="cancel" type="button" onclick="location.href='rideInput.php'">Cancel</button >
       <button class="button" type="submit">Submit</button >
        </div>
      </form>
      
 




</html>
