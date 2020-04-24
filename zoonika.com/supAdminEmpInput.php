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
	</body>

  <!--- <header id="imgcontainer"></header> -->
  <script src="sidebar.js"></script>
  </body>
  
  <form action="SupAdminScript.php" method="POST">
  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <h1> New Employee Form</h1>

    <label for="user_fname"><b>Employee First Name</b></b></label>
     <br>
    <input type="text" placeholder="Enter First Name" name="user_fname" required>
     <br>
	 
    <label for="user_lname"><b>Employee Last Name</b></b></label>
     <br>
    <input type="text" placeholder="Enter First Name" name="user_lname" required>
     <br>
	 <label for="user_DOB"><b>Employee DOB</b></b></label>
     <br>
    <input type="date" placeholder="Enter DOB" name="user_DOB" required>
     <br>
	 
	 
	 
	 <label for="user_gender"><b>Employee Gender</b></b></label><br>
	   <select  name = "user_gender" required>
                <option value="">--Select gender--</option>
                <option value="female">female</option>
                <option value="male">male</option>
            </select><br>
	 
	 
	 
	 <label for="user_email"><b>Employee email</b></b></label>
     <br>
    <input type="text" placeholder="Enter email" name="user_email" required>
     <br>
	 
	 
	 
	 <label for="user_password"><b>Employee password</b></b></label>
     <br>
    <input type="text" placeholder="Enter password" name="user_password" required>
     <br>
	 <label for="department_id"><b>Department</b></b></label>
     <br>
	 <select name ="department_id" >
					<option value="" selected >--Select Department--</option>
					<?PHP 
					foreach($department as $dpt){
					echo "<option value='$dpt->department_id'>$dpt->department_name </option>";
					}							
					?>
	</select><br>
	 
	 

    <button class="cancel" type="button" onclick="location.href='supAdminEmpInput.php'">Cancel</button >
    <button class="button" type="submit">Submit</button >
    
  </div>


</form>
  


</html>


