<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class SaleClass
{
	public $post;
	
	public $sale_date;
	public $product_id;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->user_id =$_COOKIE['user_id'];
		$this->sale_date = $this->post['sale_date'];
		$this->product_id = $this->post['product_id'];
		
		
	
		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		$this->db->query($sql);
		$this->result = $this->db->single(); 
		$this->checkCookie();
		//$this->render();
		$this->profileFill();
	}
	public function render(){
	  echo "<pre>";
	  print_r($this->result);
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
		$sql = "INSERT INTO sale (sale_date, product_id, user_id ) VALUES ('$this->sale_date', '$this->product_id', '$this->user_id')";
		try{
		$this->db->query($sql);
		$this->db->execute();
		}catch(PDOException $e){
			echo $e->getMesssage();
			die('died');
		}
		exit(header("Location: http://www.zoonika.com/saleList.php"));
		}
	}
}