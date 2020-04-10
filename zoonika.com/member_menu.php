<?PHP
session_start();

include "Database.php";

if(!$_COOKIE['user_id']){
	header('Location: index.html');
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
    <link rel="stylesheet" href="sidebar.css"> 
    <link rel="stylesheet" href="product.css">
    <title>Member Admin Menu</title>
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
            <li class="side-li"><a class="side" href="memberInput.php">Add New Member</a></li>
            <li class="side-li"><a class="side" href="memberUpdate.php">Update Member</a></li>
            <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
            <li class="side-li"><a class="side" href="memberReport.php">Member Reports</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Log Out</a></li>
        </ul>
    </div>

    <header id="imgcontainer"></header>

    <div id="container">
      <h1>Member Admin Dashboard</h1>
    </div>

    <script src="sidebar.js"></script>

 
</body>
</html>





