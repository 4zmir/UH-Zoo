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

	$sql="SELECT 
	u.user_fname,
	u.user_lname,
	animal.animal_name,
	animal.animal_DOB,
	animal.animal_gender,
	animal.animal_breed,
	animal.animal_display,
	animal.animal_time
	
	FROM animal 
	LEFT JOIN `user`as u ON u.user_id = animal.user_id
	ORDER BY animal.animal_name";
		
	$db->query($sql);
	$result = $db->resultSet();
	}
	//$rowNum = $db->rowCount();
	// echo "<pre>";
	// echo print_r($result);die;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal admin</title>
    <link rel="stylesheet" href="addAnimal.css">
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
            <li class="side-li"><a class="side" href="addAnimal.php">Add New Animal</a></li>
	    <li class="side-li"><a class="side" href="animalUpdate.php">Update an Animal</a></li>
	    <li class="side-li"><a class="side" href="animalReport.php">Animal Reports</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
            
        </ul>
    </div>

    <header id="imgcontainer"></header>
    <div id="container" style='margin-bottom:6em;text-align:center;'>
         <!-- POSTS -->
  <h1>List of All Animals</h1>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th> #</th>
                  <th>Animal Name</th>
                  <th>Animal Breed</th>
				  <th>Animal DOB</th>
                  <th>Animal Gender</th>
                  <th>At Display</th>
				   <th>Who added</th>
				   <th>When added</th>
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td>$num</td>
							<td>$item->animal_name</td>
							<td>$item->animal_breed</td>
							<td>$item->animal_DOB</td>
							<td>$item->animal_gender</td>
							<td>$item->animal_display</td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$item->animal_time</td>
							
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
 
        </div>

        

    <script src="sidebar.js"></script>
</body>

</html>
