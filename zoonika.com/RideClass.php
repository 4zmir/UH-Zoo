<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class RideClass
{
	public $post;
	
	public $ride_name;
	public $ride_time;
	public $department_id = 3;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->id =$_COOKIE['user_id'];
		$this->user_id=$_COOKIE['user_id'];
		$this->ride_name = $this->post['ride_name'];
		$this->department_id = 3;
	

		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		 
		$this->db->query($sql);
		$this->result = $this->db->single();
		$this->checkCookie();
		$this->profileFill();
	}
	public function render(){
	  echo "<PRE>";
	  print_r($this->user_id);
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
		$sql = "INSERT INTO ride (ride_name, department_id, user_id) VALUES ('$this->ride_name', '$this->department_id', '$this->user_id')";
		$this->db->query($sql);
		$this->result = $this->db->execute();
		echo '<script type="text/JavaScript">
            	alert("Ride was successfully added.");
            	window.location.replace("http://www.zoonika.com/rideList.php");
            	</script>'
           	 ;
		}catch(PDOException $e){
			echo '<script type="text/JavaScript">
                alert("An error occured when inserting this ride (Possibly a duplicate).");
                window.location.replace("http://www.zoonika.com/rideInput.php");
                </script>'
                ;
		}
		//header("Location: http://www.zoonika.com/rideInput.php");
		}
	}
}