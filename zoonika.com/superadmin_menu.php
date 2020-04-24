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

$var = $_POST['whichRecord'];

		$sql = "UPDATE unusual_sale SET seen_by_admin = '1' 
		WHERE sale_id = '$var' ";
			$db->query($sql);
			$db->execute();

}


$sql="SELECT unusual_sale.sale_id, unusual_sale.user_id, unusual_sale.sale_date, unusual_sale.sale_qty, user.user_fname ,user.user_lname
		from unusual_sale 
		left join user on user.user_id = unusual_sale.user_id
		where unusual_sale.seen_by_admin = '0'";
$db->query($sql);
$result = $db->resultSet();

  
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
          <li class="side-li"><a class="side" href="SupAdminUpdate.php">Update Employee</a></li>
		  <li class="side-li"><a class="side" href="SupAdminReport.php">Report Employee</a></li>
          <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
      </ul>
    </div>

  <header id="imgcontainer"></header>

  <div id="container">
      <h1>Super Admin Dashboard</h1>
	  
	  <?PHP if($result) { ?>
	  
	  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
</head>
<body>


 
<div class="alert" style='margin-bottom:6em;text-align:center;'>
  <strong>Unusual quantity for a sale</strong>
   
  <?php foreach($result as $rs) {
	  $ftdate = formatDate($rs->sale_date);
	  
	  echo "<li>
				$rs->user_fname  $rs->user_lname sold $rs->sale_qty  items (price > $5.00 ) on a single transaction on $ftdate
				<form method='POST'>
					<input type='hidden' name='whichRecord' value='$rs->sale_id'>
					<input name='$rs->user_id' type='submit' value='Acknowledge'>
				</form>
			</li>";
	   }
		 ?>
	   
	   </div>



</body>
	  
	  <?PHP }?>
	  
  </div>
  <script src="sidebar.js"></script>

</body>
</html>
