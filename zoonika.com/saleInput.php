<?PHP
session_start();

include "Database.php";

if(!$_COOKIE['user_id']){
	header('Location: index.php');
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
    <title>Add Sale</title>
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
            <li class="side-li"><a class="side" href="sale_menu.php">Dashboard</a></li>
            <li class="side-li"><a class="side" href="saleList.php">List All Sales</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
            
        </ul>
    </div>

    <header id="imgcontainer"></header>

    <div id="container" style='margin-bottom:6em;text-align:center;'>
		<h1> INPUT NEW SALE</h1>
			<form  id="submit" action="" method="POST">
                
        
                <label for="product_id">Product ID</label><br>
                <input type="number" placeholder="Enter Product id" name="product_id" required><br>
                
                <label for="sale_date">Sale date</label><br>
                <input type="date" placeholder="Enter Sale date" name="sale_date" value="YYYY-MM-DD" required ><br>

               <button class="cancel" type="button" onclick="location.href='.php'">Cancel</button >
             <button class="button" type="submit">Submit</button >  
        </form>
    </div>

        

    <script src="sidebar.js"></script>
</body>

</html>




