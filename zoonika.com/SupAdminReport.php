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
	
	$startday = $_POST['startday'] . " 00:00:00";
	$endday = $_POST['endday'] . " 23:59:59";
	
	// echo"<PRE>";
	// print_r($_POST);die;
	//echo"<PRE>";
//	print_r($endday);die;
	
$sql="
    SELECT user.user_fname, user.user_lname, user.user_DOB, user.user_gender, 
    user.user_email, user.user_password, user.user_create_date, d.department_name, 
    u.user_fname as admin_fname, u.user_lname as admin_lname
	FROM user
    LEFT JOIN department as d ON d.department_id = user.department_id
    LEFT JOIN user as u ON u.user_id = user.user_added
	WHERE user.user_create_date >= '$startday' AND user.user_create_date  < '$endday'
	ORDER by user.user_create_date DESC ";

		
    $db->query($sql);
    $result = $db->resultSet();
    $rowNum = $db->rowCount();
	// echo "<pre>";
	// echo print_r($result);die;
	
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
    <li class="side-li"><a class="side" href="SupAdminUpdate.php">Update Employee</a></li>
    <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search an employee by added day</h1>
		  <label>Start day</label>
          <input type="date" placeholder="Enter a word" name="startday" required><br>
		  <label>End day</label>
          <input type="date" placeholder="Enter a word" name="endday" required><br> 

       <button class="button" type="submit">Submit</button >
        </div>
      </form>
      
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>

  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:60%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th></th>
					<th> #</th>
                    <th>Department</th>
                    <th>Employee's Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Password</th>
					<th>Who Added</th>
					<th>When Added</th>         
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td></td>
                            <td>$num</td>
                            <td>$item->department_name</td>
                            <td>$item->user_fname $item->user_lname</td>
                            <td>$item->user_DOB</td>
                            <td>$item->user_gender</td>
                            <td>$item->user_email</td>
                            <td>$item->user_password</td>
							<td>$item->admin_fname $item->admin_lname</td>
							<td>$item->user_create_date</td>
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>