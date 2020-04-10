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


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Animal</title>
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
            <li class="side-li"><a class="side" href="addAnimalList.php">List all Animals</a></li>
	    <li class="side-li"><a class="side" href="animalUpdate.php">Update an Animal</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
        </ul>
    </div>

    <header id="imgcontainer"></header>
    <div id="container" style='margin-bottom:6em;text-align:center;'>
        <h1>Add Animal</h1>

        <form  id="submit" action="addAnimalScript.php" method="POST">

            <label for="animal_name">Animal Name:</label><br>
          <input type="text"  name="animal_name" required><br>

            <label for="animal_dob">Date of birth:</label><br>
           <input type="date" placeholder="Enter animal DOB" name="animal_DOB" value="YYYY-MM-DD" required><br>

            <label for="animal_gender">Gender:</label><br>
            <select  name = "animal_gender" required>
                <option value="">N/A</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>

            <label for="animal_breed">Animal Breed</label><br>
            <input type="text" name="animal_breed" required><br>
			
            <label for="display">Currently on display?</label><br>
            <select  name = "animal_display" required>
                <option value="">N/A</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br>
			

            <button class="cancel" type="button" onclick="location.href='addAnimal.php'">Cancel</button >
            <button class="button" type="submit">Submit</button >
			

        </form>
    </div>

    <script src="sidebar.js"></script>
</body>

</html>
