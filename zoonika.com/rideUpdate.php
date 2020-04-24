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
	SELECT ride.ride_id, ride.ride_name, u.user_fname, u.user_lname, ride.ride_time
	FROM ride
	LEFT JOIN user as u ON u.user_id = ride.user_id
	 WHERE ride.ride_name LIKE '%$svar%'
	 OR ride.ride_time LIKE '%$svar%'
	 OR u.user_fname LIKE '%$svar%' 
	 OR u.user_lname LIKE '%$svar%' ";

		
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
        <li class="side-li"><a class="side" href="ride_menu.php">Dashboard</a></li>
		<li class="side-li"><a class="side" href="rideInput.php">Add New Ride</a></li>
        <li class="side-li"><a class="side" href="rideList.php">List All Rides</a></li>
		<li class="side-li"><a class="side" href="rideReport.php">Reports for Ride</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

   <!--- <header id="imgcontainer"></header> -->
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search for a ride</h1>

          <input type="text" placeholder="Enter a word" name="svar" required><br>

       <button class="button" type="submit">Submit</button >
        </div>
      </form>
      
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>

  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th> #</th>
                    <th>Ride's Name</th>
					<th>Who Added</th>
					<th>When Added</th>
					<th></th>
					<th></th
                  
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$ftdate = formatDate($item->ride_time);
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td>$num</td>
							<td>$item->ride_name</td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$ftdate</td>
							 <td><a href='rideDelete.php?id=$item->ride_id' 
              onclick=\"return confirm('Are you sure you want to delete $item->ride_name?')\">Delete</a></td>
							<td><a href='rideUpdtForm.php?id=$item->ride_id'>Update</a></td>
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>