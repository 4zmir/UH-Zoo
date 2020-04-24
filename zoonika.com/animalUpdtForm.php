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


	$sql="SELECT * from animal where animal_id = '$product_id'";
	$db->query($sql);
	$item = $db->single();

}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	$name = $_POST['name'];
	$DOB = $_POST['DOB'];
	$gender = $_POST['gender'];
	$breed = $_POST['breed'];
	$display = $_POST['display'];

	$sql="
	UPDATE animal SET animal_name = '$name', animal_DOB = '$DOB', animal_gender = '$gender', animal_breed = '$breed', animal_display = '$display'
	WHERE animal_id = '$product_id' ";
	$db->query($sql);
	$db->execute();
	header('Location: animalUpdate.php');
	// echo "<pre>";
	 //echo print_r($vv);die;

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
        <li class="side-li"><a class="side" href="addAnimalMenu.php">Dashboard</a></li>
        <li class="side-li"><a class="side" href="addAnimalList.php">List All Animals</a></li>
	<li class="side-li"><a class="side" href="animalUpdate.php">Animal Update</a></li>
	<li class="side-li"><a class="side" href="animalReport.php">Animal Reports</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

   <!--- <header id="imgcontainer"></header> -->
   <script src="sidebar.js"></script>

   </body>


   <form  method="post">
		<div id="container" style='margin-bottom:6em;text-align:center;'>
			<h1> Update Form For the Animal</h1>
				<label for="animal_name"><br>Animal Name:</br></label>
				<input type="text"  name="name" value="<?php echo $item->animal_name; ?>" required ><br>

				<label for="animal_DOB"><br>Date of Birth:</br></label>
				<input type="date"  name="DOB" value="<?php echo $item->animal_DOB; ?>" required ><br>

                <?php $genderStatus = $item->animal_gender;?>
				<label for="animal_gender"><br>Gender:</br></label>
				<select  name="gender" required>
				    <option value= "" <?php if($genderStatus == "") echo "SELECTED";?> >N/A</option>
				    <option value= "Male" <?php if($genderStatus == "Male") echo "SELECTED";?> >Male</option>
				    <option value= "Female" <?php if($genderStatus == "Female") echo "SELECTED";?> >Female</option>
				</select><br>

				<label for="animal_breed"><br>Animal Breed:</br></label>
				<input type="text"  name="breed" value="<?php echo $item->animal_breed; ?>" required ><br>

                <?php $displayStatus = $item->animal_display;?>
				<label for="animal_display"><br>Currently on display?</br></label>
				<select name="display" required>
				    <option value= "" <?php if($displayStatus == "") echo "SELECTED";?> >N/A</option>
				    <option value= "Yes" <?php if($displayStatus == "Yes") echo "SELECTED";?> >Yes</option>
				    <option value= "No" <?php if($displayStatus == "No") echo "SELECTED";?> >No</option>
				</select><br>

			<button class="cancel" type="button" onclick="location.href='addAnimalMenu.php'">Cancel</button >
			<button class="button" type="submit">Submit</button >
        </div>
    </form>


//value="<?php echo $item->animal_name; ?>"



</html>