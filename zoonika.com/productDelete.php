<?PHP

if(isset($_GET['id']) && ($_GET['id']!== '')){
	$product_id = $_GET['id'];
	//echo "$product_id";
  
 
	include "Database.php";


	if(!$_COOKIE['user_id']){
	exit(header('Location: index.html'));
	}

	$db = new Database();

	$sql="SELECT * from user where user_id = '$_COOKIE[user_id]'";
	$db->query($sql);
	$user = $db->single(); 
	
	$sql="SELECT product_id from sale where product_id = '$product_id'";
	$db->query($sql);
	$unit = $db->single(); 
	
	
	if ($unit){
		echo '<script type="text/JavaScript">
                	alert("Can not delete a product that has already been sold!");
               		window.location.replace("http://www.zoonika.com/productUpdate.php");
                	</script>';
		
	 //exit(header('Location: productUpdate.php'));
	 
	}
	else{
		
		
		$sql="DELETE FROM product WHERE product_id = '$product_id' ";
	$db->query($sql);
	$db->execute();
	exit(header('Location: productUpdate.php'));

	}
	

} 	else {
	echo "failed";
}


?>