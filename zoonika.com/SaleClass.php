<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class SaleClass
{
	public $post;
	
	public $sale_date;
	public $product_id;
	public $sale_qty;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		$this->cart = json_decode($post['cart']);
		//$this->render();
		
		
		$this->post = $post; // $_POST array from form;
		$this->user_id =$_COOKIE['user_id'];
		$this->sale_qty = $this->post['qty'];
		$this->sale_price = $this->post['price'];
		$this->product_id = $this->post['pid'];
		
		
		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		$this->db->query($sql);
		$this->result = $this->db->single(); 
		$this->checkCookie();
		//$this->render();
		$this->profileFill();
	}
	public function render(){
		
	  echo "<pre>";
	  print_r($this->cart[1]->qty);
	  die;
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		
		foreach( $this->cart as $x) {
			
				if($_SERVER['REQUEST_METHOD']=='POST'){
				$sql = "INSERT INTO sale ( product_id, sale_qty, user_id ) VALUES ('$x->pid','$x->qty', '$this->user_id')";
				
								
				$this->db->query($sql);
				$this->db->execute();  }
		}
		
		exit(header("Location: http://www.zoonika.com/saleList.php"));
				
	
}
}
?>