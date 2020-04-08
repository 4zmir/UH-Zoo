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

$sql="SELECT * from member";
$db->query($sql);
$tp = $db->resultSet();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="product.css">
    <title>Add New Member</title>
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
            <li class="side-li"><a class="side" href="member_menu.php">Dashboard</a></li>
            <li class="side-li"><a class="side" href="#">Update Member</a></li>
            <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Log Out</a></li>
        </ul>
    </div>

    <header id="imgcontainer"></header>

    <div id="container" style='margin-bottom:6em;text-align:center;'>
        <form action="memberScript.php" method="post">
            <h1>Add Member</h1>

            <label for="sale_id"><b>Sale ID:</b></label><br>
            <input type="number" placeholder="Enter Sale ID" name="sale_id" required><br>

            <label for="member_fname"><b>Member First Name:</b></label><br>
            <input type="text" placeholder="Enter First Name" name="member_fname" required><br>

            <label for="member_lname"><b>Member Last Name:</b></label><br>
            <input type="text" placeholder="Enter Last Name" name="member_lname" required><br>

            <label for="member_fsize"><b>Family Size:</b></label><br>
            <input type="number" placeholder="Enter Family Size" name="member_fsize" required><br>

            <button type="submit">Submit</button>
        </form>
    </div>

    <script src="sidebar.js"></script>

</body>

</html>