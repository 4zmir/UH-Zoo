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

$sql="SELECT * from product_type";
$db->query($sql);
$tp = $db->resultSet();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
            <li class="side-li"><a class="side" href="product_menu.php">Product Dashboard</a></li>
            <li class="side-li"><a class="side" href="prdList.php">List all product</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
        </ul>
    </div>

    <header id="imgcontainer"></header>


    <script src="sidebar.js"></script>
</body> 


<form action="productScript.php" method="POST">



  <div id="container" style='margin-bottom:6em;text-align:center;'>
    <h1> INPUT NEW PRODUCTS</h1>

    <label for="product_name"><b>Product description</b></label>
     <br>
    <input type="text" placeholder="Enter Product description" name="product_name" required>
     <br>
	 <label for="product_type_id"><b>Product type<b></label><br>
     <select name ="product_type_id" >
					<option value="" selected >--Select Item--</option>
					<?PHP 
					foreach($tp as $ptp){
					echo "<option value='$ptp->product_type_id'>$ptp->product_type_name </option>";
					}							
					?>
	</select><br>
     <label for="product_price"><b>Product Price $:</b></label>
      <br>
        <input type="number" step=0.01 min = 0.00 placeholder="0.00" name="product_price" required>
      <br>
    <button class="cancel" type="button" onclick="location.href='rideInput.php'">Cancel</button >
    <button class="button" type="submit">Submit</button >
    
  </div>


</form>


</html>
