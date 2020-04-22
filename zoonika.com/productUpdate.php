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
	SELECT product.product_id, product.product_type_id, product.product_name, product.product_price, u.user_fname, u.user_lname, product.product_time
	FROM product
	LEFT JOIN user as u ON u.user_id = product.user_id
	 WHERE product.product_name LIKE '%$svar%'
	 OR product.product_time LIKE '%$svar%'
	 OR product.product_price LIKE '%$svar%'
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
        <li class="side-li"><a class="side" href="product_menu.php">Dashboard</a></li>
	<li class="side-li"><a class="side" href="prdtInput.php">Add New Product</a></li>
        <li class="side-li"><a class="side" href="prdList.php">List All Products</a></li>
	<li class="side-li"><a class="side" href="productReport.php">Product Reports</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <header id="imgcontainer"></header>
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search for a Product</h1>

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
                    			<th>product's id</th>
					<th>product's type id</th>
					<th>product's name</th>
					<th>product's price</th>
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
							<td>$item->product_id</td>
							<td>$item->product_type_id</td>
							<td>$item->product_name</td>
							<td>$item->product_price</td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$item->product_time</td>
							<td><a href='productDelete.php?id=$item->product_id'  
							onclick=\"return confirm('Are you sure you want to delete $item->product_name?')\">Delete</a></td>
							<td><a href='productUpdtForm.php?id=$item->product_id'>Update</a></td>
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>