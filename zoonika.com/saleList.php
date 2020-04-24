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
				DATE(sale.sale_date) AS sale_date, 
				u.user_fname AS fname,
				u.user_lname AS lname,
				product.product_name,
				product.product_price,
				sale.sale_qty				
				FROM
				sale
				LEFT JOIN product ON sale.product_id = product.product_id
				LEFT JOIN `user`as u ON u.user_id = sale.user_id";
				
										/* SALES BY USER ID
										SELECT
											DATE(sale.sale_date) AS sale_date, 
											u.user_fname AS fname,
											u.user_lname AS lname,
											product.product_name,
											COUNT(product.product_id) as cnt,
											SUM(product.product_price) as total
										   
										FROM
											sale
										LEFT JOIN product ON sale.product_id = product.product_id
										LEFT JOIN `user`as u ON u.user_id = sale.user_id

										GROUP BY 
										sale_date,fname,lname,product_name
										ORDER BY lname
										*/		
	$db->query($sql);
	$result = $db->resultSet();
	//$rowNum = $db->rowCount();
	// echo "<pre>";
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
    <title>Sale List</title>
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
            <li class="side-li"><a class="side" href="saleUpdate.php">Update Sale</a></li>
			<li class="side-li"><a class="side" href="saleReport.php">Report Sale</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
            
        </ul>
    </div>

    <!-- <header id="imgcontainer"></header>-->

    <div id="container" style='margin-bottom:6em;text-align:center;'>
       <!-- POSTS -->
  <h1>List of All Sales</h1>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th> #</th>
                    <th>Product Name</th>
					<th>Price</th>
					<th>Qty</th>
					<th>Sale Date</th>
					<th>Salesperson</th>
                  
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$ftdate = formatDate($item->sale_date);
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td>$num</td>
							<td>$item->product_name</td>
							<td>$$item->product_price</td>
							<td>$item->sale_qty</td>
							<td>$ftdate</td>
							<td>$item->fname $item->lname</td>
							
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
