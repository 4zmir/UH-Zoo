<?PHP
session_start();

include "Database.php";


$db = new Database();

$sql="SELECT * from user where user_id = '$_COOKIE[user_id]' ";
$db->query($sql);
$user = $db->single();

if(!$_COOKIE['user_id']){
	header('Location: index.html');
}
if ($_COOKIE['user_id']){

	$sql="SELECT product.product_name, product.product_price, product.product_time, u.user_fname, u.user_lname 
	FROM product 
	LEFT JOIN `user`as u ON u.user_id = product.user_id
	order by product_name";
		
	$db->query($sql);
	$result = $db->resultSet();
	//$rowNum = $db->rowCount();
	// echo "<pre>";
	// echo print_r($result);die;
	
	
	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product admin</title>
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
	    <li class="side-li"><a class="side" href="productUpdate.php">Update a Product</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
            
        </ul>
    </div>

    <header id="imgcontainer"></header>
    <div id="container" style='margin-bottom:6em;text-align:center;'>

		<!-- POSTS -->
	  <h1>List of All Products</h1>
				<table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
					<tr>
						<th> #</th>
					  <th>Product Name</th>
					  <th>Price </th>
					   <th>Who Added </th>
					    <th>When Added </th>
					</tr>
				  </thead>

				  <tbody>
				 <?PHP
					$num=1;
					foreach($result as $item){
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
						echo "<tr $shade>
								<td>$num</td>
								<td>$item->product_name</td>
								<td>$item->product_price</td>
								<td>$item->user_fname $item->user_lname</td>
								<td>$item->product_time</td>
								
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
