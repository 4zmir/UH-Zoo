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

$sql="SELECT * from user";
$db->query($sql);
$tp = $db->resultSet();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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
          <li class="side-li"><a class="side" href="superadmin_menu.php">Dashboard</a></li>
          <li class="side-li"><a class="side" href="supAdminEmpList.php">See All Employees</a></li>
          <li class="side-li"><a class="side" href=#>Update Employee</a></li>
          <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
      </ul>
    </div>

  <header id="imgcontainer"></header>

  <div id="container">

      <header>
          <h1> New Employee Form</h1>
      </header>

      <form class="supAdminForm" action="SupAdminScript.php" method="POST">

        <label for="user_fname"><b>Employee First Name</b></label>
          <input type="text" placeholder="Enter First Name" name="user_fname" required>

        <label for="user_lname"><b>Employee Last Name</b></label>
          <input type="text" placeholder="Enter Last Name" name="user_lname" required>

        <label for="user_DOB"><b>Employee Date Of Birth</b></label>
          <input type="date" placeholder="Enter Employee DOB" name="user_DOB" value="YYYY-MM-DD" required>

        <label for="user_gender"><b>User Gender</b></label>
          <select name="user_gender" required>
              <option value="">--Please choose an option--</option>
              <option value="male">male</option>
              <option value="female">female</option><br></select>

        <label for="user_email"><b>User Email</b></label>
          <input type="text" placeholder="Enter email" name="user_email" required>

        <label for="user_password"><b>Enter Password</b></label>
          <input type="password" placeholder="Enter password" name="user_password" required>

        <label for="user_member"><b>Is This User a Zoo Member?</b></label>
          <select name="user_member" required>
          <option value="no">no ( for employee)</option>
          </select>

        <label for="department_id"><b>What Department?</b></label>
          <select name="department_id" required>
              <option value="">--Please choose an option--</option>
              <option value= 1 >Animal's department</option>
              <option value= 2 >Membership's department</option>
              <option value= 3 >Ride's department</option>
              <option value= 5 >Sale's department</option>
              <option value= 6 >Product's department</option><br></select>
              
        <button type="submit">Submit</button>
    </form>

  </div>

  <script src="sidebar.js"></script>

</body>
</html>


