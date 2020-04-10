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
	SELECT animal.animal_id, animal.animal_name, animal.animal_DOB, animal.animal_gender, animal.animal_breed, animal.animal_display, u.user_fname, u.user_lname, animal.animal_time
	FROM animal
	LEFT JOIN user as u ON u.user_id = animal.user_id
	 WHERE animal.animal_name LIKE '%$svar%'
	 OR animal.animal_DOB LIKE '%$svar%'
	 OR animal.animal_gender LIKE '%$svar%'
	 OR animal.animal_breed LIKE '%$svar%'
	 OR animal.animal_display LIKE '%$svar%'
	 OR animal.animal_time LIKE '%$svar%'
	 OR u.user_fname LIKE '%$svar%'
	 OR u.user_lname LIKE '%$svar%' ";


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
        <li class="side-li"><a class="side" href="addAnimalMenu.php">Dashboard</a></li>
		<li class="side-li"><a class="side" href="addAnimal.php">Add New Animal</a></li>
        <li class="side-li"><a class="side" href="addAnimalList.php">List All Animals</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>

   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search for an Animal</h1>

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
                    <th>Name</th>
					<th>DOB</th>
					<th>Gender</th>
					<th>Breed</th>
					<th>Display</th>
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
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td>$num</td>
							<td>$item->animal_name</td>
							<td>$item->animal_DOB</td>
							<td>$item->animal_gender</td>
							<td>$item->animal_breed</td>
							<td>$item->animal_display</td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$item->animal_time</td>
							<td><a href='animalDelete.php?id=$item->animal_id' >Delete</a></td>
							<td><a href='animalUpdtForm.php?id=$item->animal_id'>Update</a></td>

						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>