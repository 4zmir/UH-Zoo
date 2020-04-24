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

	$sql=
	"SELECT 
	u.user_id,
	u.user_fname,
	u.user_lname,
	u.user_DOB, 
	u.user_gender, 
	u.user_email,
	u.user_password,
	u.user_create_date,
	department.department_name
	FROM user as u 
	LEFT JOIN department 
			ON u.department_id = department.department_id
	ORDER BY department_name";
		
	$db->query($sql);
	$result = $db->resultSet();
	//$rowNum = $db->rowCount();
	//echo "<pre>";
	//echo print_r($result);die;
		
}

function formatDate($dayTime){
	 $arr = explode(' ', $dayTime);
	 $d = new DateTime($arr[0]);
	 return $d->format('M d, Y');
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
        <li class="side-li"><a class="side" href="SupAdminUpdate.php">Update Employee</a></li>
        <li class="side-li"><a class="side" href="SupAdminReport.php">Reports for Employee</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
    </ul>
  </div>

  <!--- <header id="imgcontainer"></header> -->

  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <h1>List of All Employees</h1>
    <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
					<tr>
            <th>Department</th>
			<th>Employee ID</th>
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
					$ftdateDOB = formatDate($item->user_DOB);
					$ftdate = formatDate($item->user_create_date);
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
            echo "<tr $shade>
				<td>$item->department_name</td>
                <td>$item->user_id</td>
                <td>$item->user_fname</td>
                <td>$item->user_lname</td>
                <td>$ftdateDOB</td>
                <td>$item->user_gender</td>
                <td>$item->user_email</td>
                <td>$item->user_password</td>
				<td>$ftdate</td>
								
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

