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

$sql="SELECT * from department";
$db->query($sql);
$department = $db->resultSet();

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
          <li class="side-li"><a class="side" href="SupAdminUpdate.php">Update Employee</a></li>
          <li class="side-li"><a class="side" href="SupAdminReport.php">Reports for Employee</a></li>
          <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
      </ul>
    </div>

  <header id="imgcontainer"></header>

     
    <form action="supAdminScript.php" method="POST">

      <div class="supAdminInput" id="container" style='margin-bottom:6em;text-align:center;'>
        <h1> INPUT NEW EMPLOYEE</h1>

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
            <option value="no">no (for employee)</option>
          </select>

        <label for="department_id"><b>What Department?</b></label>
          <select name="department_id" required>
              <option value="">--Please choose an option--</option>
              <?PHP 
                foreach($department as $dp){
                  echo "<option value='$dp->department_id'>$dp->department_name </option>";
                }							
              ?>
          </select>
          <button type="submit">Submit</button>
              
        </div>
    </form>


  <script src="sidebar.js"></script>

</body>
</html>
