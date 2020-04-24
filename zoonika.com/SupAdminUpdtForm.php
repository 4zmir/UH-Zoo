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

$sql="SELECT * from department";
$db->query($sql);
$department = $db->resultSet();

if(isset($_GET['id']) && ($_GET['id']!== '')){
	$product_id = $_GET['id'];


	$sql="SELECT user.*, d.department_name
        FROM user
		LEFT JOIN department as d ON 
        user.department_id = d.department_id
		where user_id = '$product_id'";
	$db->query($sql);
	$item = $db->single();

}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_fname = $_POST['user_fname'];
    $user_lname = $_POST['user_lname'];
	$user_DOB = $_POST['user_DOB'];
    $user_gender = $_POST['user_gender'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
	$department_id = $_POST['department_id'];
    
    $sql= "
    UPDATE user SET user_fname = '$user_fname', user_lname = '$user_lname', user_DOB = '$user_DOB', user_gender = '$user_gender', user_email = '$user_email', 
    user_password = '$user_password', department_id = '$department_id'
    WHERE user_id = '$product_id'";
    $db->query($sql);
	$db->execute();
	header('Location: SupAdminUpdate.php');

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
        <li class="side-li"><a class="side" href="supadmin_menu.php">Dashboard</a></li>
        <li class="side-li"><a class="side" href="supAdminEmpInput.php">Input New Employee</a></li>
        <li class="side-li"><a class="side" href="supAdminEmpList.php">See All Employees</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
    </ul>
    </div>

     <!--- <header id="imgcontainer"></header> -->
    <script src="sidebar.js"></script>

    </body>


    <form  method="post">
        <div id="container" style='margin-bottom:6em;text-align:center;'>
            <h1> Update Form For an Employee</h1>
            <label for="user_fname"><br>First Name:</br></label>
            <input type="text"  name="user_fname" value="<?php echo $item->user_fname; ?>" required ><br>
            
            <label for="user_lname"><br>Last Name:</br></label>
            <input type="text"  name="user_lname" value="<?php echo $item->user_lname; ?>" required ><br>

            <label for="user_DOB"><br>Date of Birth:</br></label>
            <input type="date"  name="user_DOB" value="<?php echo $item->user_DOB; ?>" required ><br>

            
            <label for="user_gender"><br>Gender:</br></label>
            <select  name="user_gender" required>
                <option value= "<?php echo $item->user_gender;?>"><?php echo $item->user_gender;?></option>
                <option value= "Male">Male</option>
                <option value= "Female">Female</option>
            </select><br>

            <label for="user_email"><br>Email:</br></label>
            <input type="text"  name="user_email" value="<?php echo $item->user_email; ?>" required ><br>

            <label for="user_password"><br>Password:</br></label>
            <input type="text"  name="user_password" value="<?php echo $item->user_password; ?>" required ><br>

            
            <label for="department_id"><br>Department</br></label>
            <select name="department_id" required>

            <option value="<?php echo $item->department_id; ?>" selected><?php echo $item->department_name; ?></option>
                <?PHP 
                foreach($department as $dp){
                echo "<option value='$dp->department_id'>$dp->department_name </option>";
                }							
                ?>

            </select><br>

            <button class="cancel" type="button" onclick="location.href='superadmin_menu.php'">Cancel</button >
            <button class="button" type="submit">Submit</button >
        </div>
    </form>


</html>
