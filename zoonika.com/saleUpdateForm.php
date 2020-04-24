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
	$change_id = $_GET['id'];


	$sql="SELECT sale.sale_id, sale.sale_qty, sale.product_id, product.product_name, product.product_id 
	from sale
	LEFT JOIN product ON product.product_id = sale.product_id
	WHERE sale.sale_id = '$change_id'";
	$db->query($sql);
	$item = $db->single();
	
	$sql ="select * from product";
	$db->query($sql);
	$prod =$db->resultSet();
	
	
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$sale_qty = $_POST['sale_qty'];
	$prd_id = $_POST['prd_id'];
	
	
	
	$sql="
	UPDATE sale SET sale_qty = '$sale_qty', product_id = '$prd_id'
	WHERE sale_id = '$change_id' ";	
	$db->query($sql);
	$db->execute();
	header('Location: saleUpdate.php');
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
        <li class="side-li"><a class="side" href="ride_menu.php">Dashboard</a></li>
        <li class="side-li"><a class="side" href="rideList.php">List All Rides</a></li>
		<li class="side-li"><a class="side" href="rideUpdate.php">Rides Update</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

 <!-- <header id="imgcontainer"></header>-->
   <script src="sidebar.js"></script>
   
   </body>
   

   <form  method="post">
		<div id="container" style='margin-bottom:6em;text-align:center;'>
			<h1> Update Form For the Sale</h1>
				<label for="poduct_name"><br><b>Product name:</b></br></label>	
				<select name="prd_id" required>				
               
				<option value="<?php echo $item->product_id; ?>" selected><?php echo $item->product_name; ?></option>
                 <?php 
				 foreach($prod as $pd){
				 echo "<option value='$pd->product_id'>$pd->product_name </option>";}
                ?>						
                </select><br>

                <label for="sale_qty"><b>Sale qty:</b></br></label>		 
                <input type="text"  name="sale_qty" value="<?php echo $item->sale_qty; ?>" required ><br>

				
			<button class="cancel" type="button" onclick="location.href='sale_menu.php'">Cancel</button >
			<button class="button" type="submit">Submit</button >
        </div>
    </form>
      





</html>