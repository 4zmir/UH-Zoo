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
    <title>Super Admin Page</title>
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
          <li class="side-li"><a class="side" href="supAdminEmpInput.php">Input New Employee</a></li>
          <li class="side-li"><a class="side" href="supAdminEmpList.php">See All Employees</a></li>
          <li class="side-li"><a class="side" href=#>Update Employee</a></li>
          <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
      </ul>
    </div>

  <header id="imgcontainer"></header>

  <div id="container">
      <h1>Super Admin Dashboard</h1>
  </div>

  <script src="sidebar.js"></script>

</body>
</html>
