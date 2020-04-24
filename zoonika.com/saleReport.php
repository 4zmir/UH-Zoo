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

$sql="SELECT * from product";
$db->query($sql);
$items = $db->resultSet();


$sql="SELECT * from user
		WHERE department_id = '5' ";
$db->query($sql);
$sale_person = $db->resultSet();
 //echo"<PRE>";
 //print_r($sale_person);die;
 
 function formatDate($dayTime){
	 $arr = explode(' ', $dayTime);
	 $d = new DateTime($arr[0]);
	 return $d->format('M d, Y');
 }
 
 




if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$startday = $_POST['startday']." 00:00:00";
	$endday = $_POST['endday']." 23:59:59";
	$productType = $_POST['productType'];
	$salePerson = $_POST['salePerson'];
	
	
	//echo"<PRE>";
	//print_r($_POST);die;
 
 if ($_POST['productType']=='All' AND $_POST['salePerson']=='All'){
	
	  $sql= " SELECT SUM(sale.sale_qty) as 'qty_by_product',
			pt.product_type_name,
			p.product_name,
			p.product_price
			FROM product as p
			LEFT JOIN sale ON p.product_id = sale.product_id
			LEFT JOIN product_type as pt ON p.product_type_id = pt.product_type_id
			WHERE sale.sale_date >= '$startday' AND sale.sale_date <= '$endday' 
			GROUP BY sale.product_id 
			ORDER BY qty_by_product ";

		
	 $db->query($sql);
	 $result = $db->resultSet();
	// $rowNum = $db->rowCount();
	//echo "<pre>";
   // echo print_r($result);die;
	
	
  } elseif($_POST['productType']=='All' AND $_POST['salePerson']!='All'){
	  
	  
	  $sql= " SELECT SUM(sale.sale_qty) as 'qty_by_product',
			pt.product_type_name,
			p.product_name,
			p.product_price
			FROM product as p
			LEFT JOIN sale ON p.product_id = sale.product_id
			LEFT JOIN product_type as pt ON p.product_type_id = pt.product_type_id
			WHERE sale.sale_date >= '$startday' AND sale.sale_date < '$endday' 
			AND sale.user_id ='$salePerson'
			GROUP BY sale.product_id 
			ORDER BY qty_by_product ";

		
	 $db->query($sql);
	 $result = $db->resultSet();
	// $rowNum = $db->rowCount();
	//echo"hello";
	//echo "<pre>";
  // echo print_r($result);die;
	  

  } elseif($_POST['productType']!='All' AND $_POST['salePerson']=='All'){
  
   $sql= " SELECT SUM(sale.sale_qty) as 'qty_by_product',
			p.product_name,
			p.product_price,
			u.user_fname,
			u.user_lname
			FROM sale
			LEFT JOIN user as u ON u.user_id = sale.user_id
			LEFT JOIN product as p ON p.product_id = sale.product_id
			WHERE sale.sale_date >= '$startday' AND sale.sale_date < '$endday' 
			AND p.product_id ='$productType'
			GROUP BY sale.user_id 
			ORDER BY qty_by_product DESC";

		
	 $db->query($sql);
	 $resultBySP = $db->resultSet();
	// $rowNum = $db->rowCount();
	//echo"hello";
	//echo "<pre>";
	//echo print_r($result);die;
  
  
  
  
  
  } else {
	  
	 $sql= " SELECT SUM(sale.sale_qty) as 'qty_by_product',
			p.product_name,
			p.product_price,
			u.user_fname,
			u.user_lname
			FROM sale
			LEFT JOIN user as u ON u.user_id = sale.user_id
			LEFT JOIN product as p ON p.product_id = sale.product_id
			WHERE sale.sale_date >= '$startday' AND sale.sale_date < '$endday' 
			AND sale.product_id = '$productType'
			AND sale.user_id ='$salePerson'
			
			GROUP BY sale.product_id 
			ORDER BY qty_by_product ";

		
	 $db->query($sql);
	 $resultBySP = $db->resultSet();
	// $rowNum = $db->rowCount();
	//echo "<pre>";
   // echo print_r($result);die;
	   
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
			<li class="side-li"><a class="side" href="sale_menu.php">Dashboard</a></li>
			<li class="side-li"><a class="side" href="saleInput.php">Add New Sale</a></li>
            <li class="side-li"><a class="side" href="saleList.php">List All Sales</a></li>
			<li class="side-li"><a class="side" href="saleUpdate.php">Update Sale</a></li>
            <li class="side-li"><a class="side" href="logoutScript.php">Logout</a></li>
    </ul>
  </div>

 <!-- <header id="imgcontainer"></header>-->
   <script src="sidebar.js"></script>
   
   </body>
   <form  method="post">


   <div id="container" style='margin-bottom:6em;text-align:center;'>
      <h1> Sales Report Form </h1>

			<label><b>Start day</b></label><br>
			<input type="date"  name="startday" style="width:300px;" value="<?= (isset($startday))? explode(' ',$startday)[0] :'' ?>" required><br>
			<label><b>End day</b></label><br>
			<input type="date"  name="endday"style="width:300px;" value="<?= (isset($endday))? explode(' ',$endday)[0] :'' ?>" required><br> 
			<label><b>Select 1 product or All</b></label><br>	
			<select name="productType" style="width:300px;">
					<option selected>--Select Item--</option>
					<option value="All">All</option>
									<?PHP 
										foreach($items as $item){
											echo "<option value='$item->product_id'>$item->product_name</option>";
										}							
									?>
			</select><br>
			<label><b>Select 1 saleperson or All</b></label><br>
			<select name="salePerson" style="width:300px;">
					<option selected>--Select Item--</option>
					<option value="All">All</option>
									<?PHP 
										foreach($sale_person as $sp){
											echo "<option value='$sp->user_id'>$sp->user_fname $sp->user_lname </option>";
										}							
									?>
			</select><br>


       <button class="button" type="submit">Submit</button >
        </div> 
      </form>
      
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"  && ($result) ){ ?>
 


  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:80%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
					<th></th>
					<th> #</th>
                    <th>Item Sold</th>
					<th>Qty</th>
					<th style='text-align:right;width:50px'>Price $</th>
					<th></th>
					<th>Product Type</th>
      
                </tr>
              </thead>

              <tbody>
             <?PHP
				$ttt_qty=0;
			    $ttt=0;
				$num=1;
				foreach($result as $item){
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
							<td></td>
							<td >$num</td>
							<td >$item->product_name</td>
							<td style='text-align:right;width:20px'>$item->qty_by_product</td>
							<td style='text-align:right;width:100px'>$item->product_price</td>
							<td></td>
							<td>$item->product_type_name</td>
						</tr>";
						$num++;
						$ttt=$ttt+$item->product_price*$item->qty_by_product;
						$ttt_qty = $ttt_qty+$item->qty_by_product;						
				}
			?>
			 <tr style="background:#b7def7">
				<tr>
				<td></td>
				  <td><b>Total:<b></td>
				  <td></td>
				  <td style='text-align:right;width:50px'><b><?PHP echo"$ttt_qty";  ?><b></td>
				  <td style='text-align:right;width:50px'><b><?PHP echo "$" . number_format($ttt,2);  ?><b></td>
				  <td></td>
				  <td></td>
				</tr>
			  </tr>
			<tfoot style="background:#b7def7">
				<tr>
				<td></td>
				  <td><b>Selected Interval:<b></td>
				  <td><b><?PHP echo formatDate($startday).' - '. formatDate($endday);  ?><b></td>
				  <td ></td>
				  <td ></td>
				  <td></td>
				  <td></td>
				</tr>
			  </tfoot>
			  </tbody>
            </table>
 
    </div>
	

 <?PHP } ?>
 
 <?PHP if($_SERVER['REQUEST_METHOD'] == "POST"  &&($resultBySP)){ ?>
  <div id="container" style='margin-bottom:6em;text-align:center;'>
            <table class="table-info" style="width:60%;margin:auto;box-shadow: 2px 2px 12px #5a9c5a;">
              <thead style="color:white;background:rgb(90, 156, 90);">
                <tr>
			
					<th> #</th>
					<th>Sale Person</th>
                    <th>Item Sold</th>
					<th>Qty</th>
					<th>Unit price $</th>
					<th>Total $:</th>
					
      
                </tr>
              </thead>

              <tbody>
             <?PHP
				$num=1;
				foreach($resultBySP as $itemsp){
					$ttl = $itemsp->qty_by_product*$itemsp->product_price;
					$shade = ($num % 2) ? 'style="background:#deffdc;"':'';
					echo "<tr $shade>
					
							<td >$num</td>
							<td>$itemsp->user_fname $itemsp->user_fname</td>
							<td>$itemsp->product_name</td>
							<td>$itemsp->qty_by_product</td>
							<td style='text-align:left;'>$itemsp->product_price</td>
							<td >$ $ttl</td>
							
						</tr>";
						$num++;
				}
			 ?>
			 <tfoot style="background:#b7def7">
				<tr>
				
				  <td><b>Selected Interval:<b></td>
				  <td><b><?PHP echo formatDate($startday).' - '. formatDate($endday);  ?><b></td>
				  <td ></td>
				  <td ></td>
				  <td></td>
				  <td></td>
				  
				</tr>
			  </tfoot>
              </tbody>
            </table>
    </div>

 <?PHP } ?>
 
 


</html>