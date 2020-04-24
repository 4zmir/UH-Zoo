<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class ProductClass
{
	public $post;
	
	public $product_name;
	public $product_type_id;
	public $product_price;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->id =$_COOKIE['user_id'];
		$this->user_id=$_COOKIE['user_id'];
		$this->product_name = $this->post['product_name'];
		$this->product_price = $this->post['product_price'];
		$this->product_type_id = $this->post['product_type_id'];
		
		
		

		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		 
		$this->db->query($sql);
		$this->result = $this->db->single();
		$this->checkCookie();
		$this->profileFill();
	}
	public function render(){
	  echo "<PRE>";
	  print_r($this->product_type_id);
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
		$sql = "INSERT INTO  product (product_name, product_price, product_type_id, user_id) VALUES ('$this->product_name', '$this->product_price', '$this->product_type_id', '$this->user_id')";
		$this->db->query($sql);
		$this->result = $this->db->execute();
		echo '<script type="text/JavaScript">
		alert("Product was successfully added.");
            	window.location.replace("http://www.zoonika.com/prdList.php");
            	</script>'
            	;
		}catch(PDOException $e){
			echo '<script type="text/JavaScript">
                	alert("An error occured when inserting this product (Possibly a duplicate).");
                	window.location.replace("http://www.zoonika.com/prdtInput.php");
                	</script>'
                	;
		}
		//header("Location: http://www.zoonika.com/prdtInput.php");
		}
	}
}