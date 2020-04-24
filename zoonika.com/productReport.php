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

function formatDate($dayTime){
	 $arr = explode(' ', $dayTime);
	 $d = new DateTime($arr[0]);
	 return $d->format('M d, Y');
 }


if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	
	
	
	$startday = $_POST['startday'] . " 00:00:00";
	$endday = $_POST['endday'] . " 23:59:59";
	$prod_type_selected = $_POST['product_type_id'];

	
	
	 //echo"<PRE>";
	 //print_r($_POST);die;
	//echo"<PRE>";
	//print_r($endday);die;
	
	if($prod_type_selected =='All'){
	
    $sql="
	SELECT product.product_id,
			product.product_name,
			product.product_price,
			u.user_fname,
			u.user_lname,
			product.product_time,
			product_type.product_type_name
	FROM product
	LEFT JOIN user as u ON u.user_id = product.user_id
	LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
	WHERE product.product_time >= '$startday' AND product.product_time <= '$endday'
	ORDER by product_type.product_type_name ";



		
	 $db->query($sql);
	 $result = $db->resultSet();
	 
	// echo "<pre>";
	// echo print_r($result);die;
	

	
	$sql ="SELECT COUNT(product.product_id) As 'units', product_type.product_type_name
	FROM product 
	LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
	WHERE product.product_time >= '$startday' AND product.product_time <= '$endday'
	GROUP BY product_type.product_type_id
	ORDER BY product_type.product_type_name ";
	$db->query($sql);
	$countt = $db->resultSet();
	
	//echo "<pre>";
    //echo print_r($countt);die;
	
	}
	else {
		
		
		
		$sql="
	SELECT product.product_id, 
			product.product_name,
			product.product_price,
			u.user_fname, 
			u.user_lname,
			product.product_time,
			product_type.product_type_name
	FROM product
	LEFT JOIN user as u ON u.user_id = product.user_id
	LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
	WHERE product.product_time >= '$startday' AND product.product_time <= '$endday' AND product.product_type_id = '$prod_type_selected'
	ORDER by product.product_time DESC ";

		
	 $db->query($sql);
	 $result = $db->resultSet();
	 
	// echo "<pre>";
	// echo print_r($result);die;
	

	
	$sql ="SELECT COUNT(product.product_id) As 'units', product_type.product_type_name
	FROM product 
	LEFT JOIN product_type ON product.product_type_id = product_type.product_type_id
	WHERE product.product_time >= '$startday' AND product.product_time <= '$endday' AND product.product_type_id = '$prod_type_selected'
	GROUP BY product_type.product_type_id
	ORDER BY product_type.product_type_name ";
	$db->query($sql);
	$countt = $db->resultSet();
	
	//echo "<pre>";
    //echo print_r($countt);die;
			
		
	}
	
	
	
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
        <li class="side-li"><a class="side" href="productUpdate.php">Update a Product</a></li>
        <li class="side-li"><a class="side" href="logoutScript.php">Log out</a></li>
    </ul>
  </div>

  <!--- <header id="imgcontainer"></header> -->
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">

   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1>Reports for Products By Date Added and Type</h1>
			<label><b>Start day<b></label><br>
			<input type="date"  name="startday"  value="<?= (isset($startday))? explode(' ',$startday)[0] :'' ?>" required><br>
			<label><b>End day<b></label><br>
			<input type="date" name="endday"  value="<?= (isset($endday))? explode(' ',$endday)[0] :'' ?>" required><br>
			<label for="product_type_id"><b>Product type<b></label><br>
			<select name ="product_type_id" >
					<option value="" selected >--Select Item--</option>
					<option value="All">All Product Types</option>
					<?PHP 
					foreach($tp as $ptp){
					echo "<option value='$ptp->product_type_id'>$ptp->product_type_name </option>";
					}							
					?>
	</select><br>
		  

       <button class="button" type="submit">Submit</button >
        </div>
      </form>
      
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>
 
 <div id="container" style='margin-bottom:6em;text-align:center;'>
  <h2>Total units added in department(s)</h2>
            <table class="table-info" style="width:30%;margin:auto;box-shadow: 2px 2px 12px #b6bab5;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th></th>
                    <th>Product type</th>  
					<th>Count</th>					
                </tr>
				<?PHP
				$ttt=0;
				foreach($countt as $cnt){
					$shade = ($num % 2) ? 'style="background:#b6bab5;"':'';
					echo "<tr $shade>
							<td></td>
							<td>$cnt->product_type_name</td>
							<td>$cnt->units</td>
						</tr>";
						$ttt=$ttt+$cnt->units;
                }
			 ?>
			 <tfoot style="background:#b4edc3">
				<tr>
				  <td><b>Total:<b></td>
				  <td></td>
				  <td><b><?PHP echo"$ttt";  ?><b></td>
				</tr>
			  </tfoot>
              </tbody>
            </table>
    </div>
				
 

  <div id="container" style='margin-bottom:6em;text-align:center;'>
			<h2>List of units added in department(s)</h2>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th></th>
					<th> #</th>
					<th>Product Type</th>
                    <th>Name</th>
                    <th>Price</th>
					<th>Who Added</th>
					<th>When Added</th>
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($result as $item){
					$ftdate = formatDate($item->product_time);
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
											<td></td>
											<td>$num</td>
                            				<td>$item->product_type_name</td>
                            				<td>$item->product_name</td>
                            				<td>$item->product_price</td>
											<td>$item->user_fname $item->user_lname</td>
											<td>$ftdate</td>
						</tr>";
						$num++;
                }
			 ?>
			 <tfoot style="background:#b7def7">
				<tr>
				<td></td>
				  <td><b>Selected Interval:<b></td>
				  <td><b><?PHP echo formatDate($startday).' - '. formatDate($endday);  ?><b></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				</tr>
			  </tfoot>
              </tbody>
            </table>
    </div>

 <?PHP }?>


</html>