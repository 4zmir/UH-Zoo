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
	//print_r($endday);die;
	
    $sql="
	SELECT member.member_id, member.member_fname, member.member_lname, u.user_fname, u.user_lname, member.member_start, member.member_fsize
	FROM member
	LEFT JOIN user as u ON u.user_id = member.user_id
	WHERE member.member_start >= '$startday' AND member.member_start < '$endday'
	ORDER by member.member_start DESC ";

		
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
        <li class="side-li"><a class="side" href="member_menu.php">Dashboard</a></li>
        <li class="side-li"><a class="side" href="memberInput.php">Add New Member</a></li>
        <li class="side-li"><a class="side" href="memberUpdate.php">Update Member</a></li>
        <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1>Search Members By Date Added</h1>
		  <label>Start day</label><br>
          <input type="date" placeholder="Enter a word" name="startday" required><br>
		  <label>End day</label><br>
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
                    <th>Member Last Name</th>
                    <th>Member First Name</th>
                    <th>Family Size</th>
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
                            <td>$item->member_lname</td>
                            <td>$item->member_fname</td>
                            <td>$item->member_fsize</td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$item->member_start</td>	
						</tr>";
						$num++;
                }
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>