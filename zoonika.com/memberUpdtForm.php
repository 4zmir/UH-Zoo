<?PHP
session_start();

include "Database.php";

if(!$_COOKIE['user_id']){
	header('Location: index.html');
}

$db = new Database();

$sql="SELECT * from user
 where user_id = '$_COOKIE[user_id]'";
$db->query($sql);
$user = $db->single();

if(isset($_GET['id']) && ($_GET['id']!== '')){
	$product_id = $_GET['id'];


	$sql="SELECT * from member where member_id = '$product_id'";
	$db->query($sql);
	$item = $db->single();
	
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $member_fname = $_POST['member_fname'];
    $member_lname = $_POST['member_lname'];
    $member_fsize = $_POST['member_fsize'];
    $member_start = $_POST['member_start'];

    if ($member_start == "Yes"){
        $sql = "UPDATE member SET member_fname = '$member_fname', member_lname = '$member_lname', member_fsize = $member_fsize,
                member_start = current_timestamp(), member_expire = current_timestamp() + INTERVAL 1 YEAR
	              WHERE member_id = '$product_id' ";	
	      $db->query($sql);
	      $db->execute();
	      header('Location: memberUpdate.php');
    }
    if ($member_start == "No"){
        $sql = "UPDATE member SET member_fname = '$member_fname', member_lname = '$member_lname', member_fsize = $member_fsize
	              WHERE member_id = '$product_id' ";	
	      $db->query($sql);
	      $db->execute();
	      header('Location: memberUpdate.php');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Ride</title>
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
        <li class="side-li"><a class="side" href="memberList.php">List All Members</a></li>
		<li class="side-li"><a class="side" href="memberUpdate.php">Member Update</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>
   
   </body>
   

   <form  method="post">
		<div id="container" style='margin-bottom:6em;text-align:center;'>
            <h1> Update Form For Members</h1>
            
				<label for="ride_name"><br><b>Member First name:</b></br></label>		 
                <input type="text"  name="member_fname" value="<?php echo $item->member_fname; ?>" required ><br>

                <label for="ride_name"><b>Member Last name:</b></br></label>		 
                <input type="text"  name="member_lname" value="<?php echo $item->member_lname; ?>" required ><br>

                <label for="member_fsize"><b>Family Size:</b></label><br>
                <input type="number" name="member_fsize" value="<?php echo $item->member_fsize; ?>" required><br>

                <label for = "member_start"><b>Renewing Membership?</b></label><br>
                <select name="member_start" required>
                  <option value="" selected>--Select Option--</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>

                </select><br>

			<button class="cancel" type="button" onclick="location.href='member_menu.php'">Cancel</button >
			<button class="button" type="submit">Submit</button >
        </div>
    </form>
</html>