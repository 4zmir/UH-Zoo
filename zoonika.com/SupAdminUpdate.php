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

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$svar = $_POST['svar'];
	$sql="
    SELECT user.user_id, user.department_id, user.user_fname, user.user_lname, user.user_DOB, user.user_gender, 
    user.user_email, user.user_password, d.department_name, user.user_create_date
	FROM user
	LEFT JOIN department as d ON d.department_id = user.department_id
	 WHERE user.user_fname LIKE '%$svar%'
	 OR user.user_lname LIKE '%$svar%'
	 OR user.user_DOB LIKE '%$svar%'
	 OR user.user_gender LIKE '%$svar%'
	 OR user.user_email LIKE '%$svar%'
	 OR user.user_password LIKE '%$svar%'
	 OR user.user_create_date LIKE '%$svar%'
	 OR d.department_name LIKE '%$svar%' 
	 ORDER BY d.department_name";


	 $db->query($sql);
	 $result = $db->resultSet();
	 $rowNum = $db->rowCount();
	// echo "<pre>";
	// echo print_r($result);die;

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
  <title>Reports</title>
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
        <li class="side-li"><a class="side" href="supAdminEmpList.php">See All Employees</a></li>
        <li class="side-li"><a class="side" href="SupAdminReport.php">Reports for Employee</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
    </ul>
  </div>

   <!--- <header id="imgcontainer"></header> -->
   <script src="sidebar.js"></script>

   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search for an Employee</h1>

          <input type="text" placeholder="Enter a word" name="svar" required><br>

       <button class="button" type="submit">Submit</button >
        </div>
      </form>

 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>

  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:95%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
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
                    <th></th>
					<th></th>
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
                            <td>$$ftdateDOB</td>
                            <td>$item->user_gender</td>
                            <td>$item->user_email</td>
                            <td>$item->user_password</td>
                            <td>$ftdate</td>
							  <td><a href='SupAdminDelete.php?id=$item->user_id' 
              onclick=\"return confirm('Are you sure you want to delete $item->user_fname $item->user_lname?')\">Delete</a></td>
							<td><a href='SupAdminUpdtForm.php?id=$item->user_id'>Update</a></td>
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>