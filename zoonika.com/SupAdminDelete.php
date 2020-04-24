<?PHP

if(isset($_GET['id']) && ($_GET['id']!== '')){
	$user_delete_id = $_GET['id'];
	
	#echo"<PRE>";
	#print_r ($user_delete_id); die;


	include "Database.php";


	if(!$_COOKIE['user_id']){
	header('Location: index.html');}
	

	$db = new Database();
	$sql="SELECT * from user where user_id = '$_COOKIE[user_id]'";
	$db->query($sql);
	$user = $db->single();
	
	
	
	$sql= " SELECT user_id from ride where user_id = '$user_delete_id' "; 
	$db->query($sql);
	$unit1 = $db->single(); 
	$sql= " SELECT user_id from product where user_id = '$user_delete_id' "; 
	$db->query($sql);
	$unit2 = $db->single(); 
	$sql= " SELECT user_id from animal where user_id = '$user_delete_id' "; 
	$db->query($sql);
	$unit3 = $db->single(); 
	 
	


	
						if ($unit Or $unit1 OR $unit2 OR $unit3 ){
							echo '<script type="text/JavaScript">
										alert("Can not delete a user that has already created  a recors in the zoo!");
										window.location.replace("http://www.zoonika.com/SupAdminUpdate.php");
										</script>';
							
						
						} else {
							
							

							
						$sql= "DELETE FROM user WHERE user_id = '$user_delete_id' ";
						$db->query($sql);
						$db->execute();

						exit(header('Location: SupAdminUpdate.php'));
							}
	}
	
	else {
	echo "failed";
	}

	
?>