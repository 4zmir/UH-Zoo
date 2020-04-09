<?PHP
session_start();

include "Database.php";


$db = new Database();

$sql="SELECT * from user where user_id = '$_COOKIE[user_id]' ";
$db->query($sql);
$user = $db->single();

if(!$_COOKIE['user_id']){
	header('Location: index.html');
}
if ($_COOKIE['user_id']){

	$sql="SELECT user.user_id, user.user_fname, user.user_lname, user.user_DOB, user.user_gender, user.user_email, user.user_password, user.user_create_date, d.department_name
	FROM user 
	LEFT JOIN `department`as d ON user.department_id = d.department_id
  order by user.user_id";
		
	$db->query($sql);
	$result = $db->resultSet();
	//$rowNum = $db->rowCount();
	// echo "<pre>";
	// echo print_r($result);die;
	
	
	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Employees</title>
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
        <li class="side-li"><a class="side" href="supAdminEmpInput.php">Input New Employee</a></li>
        <li class="side-li"><a class="side" href=#>Update Employee</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>

  <div id="container">
    <h1>List of All Employees</h1>
    <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
					<tr>
            <th>Employee ID</th>
            <th>Department</th>
					  <th>First Name</th>
					  <th>Last Name</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Password</th>
            <th>When Added</th>
					</tr>
				  </thead>

				  <tbody>
				 <?PHP
					$num=1;
					foreach($result as $item){
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
            echo "<tr $shade>
                <td>$item->user_id</td>
                <td>$item->department_name</td>
                <td>$item->user_fname</td>
                <td>$item->user_lname</td>
                <td>$item->user_DOB</td>
                <td>$item->user_gender</td>
                <td>$item->user_email</td>
                <td>$item->user_password</td>
								<td>$item->user_create_date</td>
								
							</tr>";
							$num++;
					}
				 ?>
				  </tbody>
				</table>
  </div>

  <script src="sidebar.js"></script>

</body>
</html>

