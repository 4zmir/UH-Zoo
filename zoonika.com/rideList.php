<?PHP
session_start();

include "Database.php";


$db = new Database();

$sql="SELECT * from user where user_id = '$_COOKIE[user_id]'";
$db->query($sql);
$user = $db->single();

if(!$_COOKIE['user_id']){
	header('Location: index.html');
	
}
if ($_COOKIE['user_id']){

	$sql="
	SELECT ride.ride_name, u.user_fname, u.user_lname, ride.ride_time
	FROM ride
	LEFT JOIN user as u ON u.user_id = ride.user_id
	order by ride_name";
		
	$db->query($sql);
	$result = $db->resultSet();
	//$rowNum = $db->rowCount();
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
    <title>Ride List</title>
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
		<li class="side-li"><a class="side" href="rideUpdate.php">Ride Update</a></li>
		<li class="side-li"><a class="side" href="rideReport.php">Reports for Ride</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <!--- <header id="imgcontainer"></header> -->
    <div id="container" style='margin-bottom:6em;text-align:center;'>
     <!-- POSTS -->
  <h1>List of All Rides</h1>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th> #</th>
                    <th>Ride's Name</th>
					<th>Who Added</th>
					<th>When Added</th>
                  
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
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

</body>

<script src="sidebar.js"></script>

</html>
