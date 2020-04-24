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
	SELECT sale.sale_id, product.product_price, sale.sale_qty, sale.user_id, sale.sale_date, product.product_name, u.user_lname, u.user_fname
	FROM sale 
	LEFT JOIN product ON sale.product_id = product.product_id
	LEFT JOIN user as u ON u.user_id = sale.user_id
	
	 WHERE sale.sale_id LIKE '%$svar%'
	 OR sale.sale_qty LIKE '%$svar%'
	 OR sale.user_id LIKE '%$svar%' 
	 OR u.user_fname LIKE '%$svar%'
	 OR u.user_lname LIKE '%$svar%'
	 OR product.product_price LIKE '%$svar%'
	 OR product.product_name LIKE '%$svar%'
	 OR sale.sale_date LIKE '%$svar%'";

		
	 $db->query($sql);
	 $result = $db->resultSet();
	 $rowNum = $db->rowCount();
	 //echo "<pre>";
	// echo print_r($result);die;
	
}

function formatDate($dayTime){
	 $arr = explode(' ', $dayTime);
	 $d = new DateTime($arr[0]);
	 return $d->format('M d, Y');
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
			<li class="side-li"><a class="side" href="sale_menu.php">Dashboard</a></li>
			<li class="side-li"><a class="side" href="saleInput.php">Add New Sale</a></li>
            <li class="side-li"><a class="side" href="saleList.php">List All Sales</a></li>
			<li class="side-li"><a class="side" href="saleReport.php">Report Sale</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Log Out</a></li>
    </ul>
  </div>

  <!-- <header id="imgcontainer"></header>-->
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Search for a sale</h1>

          <input type="text" placeholder="Enter a word" name="svar" required><br>

       <button class="button" type="submit">Submit</button >
        </div>
      </form>
      
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>

  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th></th>
					<th> #</th>
                    <th>Item Sold</th>
					<th>Qty</th>
					<th>Price $</th>
					<th>Who Sold</th>
					<th>When Sold</th> 
					<th></th>
					<th></th
                  
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$ftdate = formatDate($item->sale_date);
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<th></th>
							<td>$num</td>
							<td>$item->product_name</td>
							<td>$item->sale_qty</td>
							<td>$item->product_price </td>
							<td>$item->user_fname $item->user_lname</td>
							<td>$ftdate</td>
							<td><a href='saleDelete.php?id=$item->sale_id' 
							 onclick=\"return confirm('Are you sure you want to delete sale # $num?')\">Delete</a></td>

							<td><a href='saleUpdateForm.php?id=$item->sale_id'>Update</a></td>
							
						</tr>";
						$num++;
				}
			 ?>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>