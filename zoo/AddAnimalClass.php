<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class AddAnimalClass
{
	public $post;
	
	public $animal_name;
	public $department_id;
	public $animal_DOB;
	public $animal_gender;
	public $animal_breed;
	public $animal_display;
	public $user_id;
	public $animal_time;
	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->id =$_COOKIE['user_id'];
		$this->animal_name = $this->post['animal_name'];
		$this->department_id = 1;
		$this->user_id=$_COOKIE['user_id'];
		$this->animal_DOB = $this->post['animal_DOB'];
		$this->animal_gender = $this->post['animal_gender'];
		$this->animal_breed = $this->post['animal_breed'];
		$this->animal_display = $this->post['animal_display'];
		
		

		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		 
		$this->db->query($sql);
		$this->result = $this->db->single();
		
		$this->checkCookie();
		$this->profileFill();
	}
	public function render(){
	  echo "<PRE>";
	  print_r($this->result);
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
		try
		{
			$sql = "INSERT INTO  animal (animal_name, department_id, animal_DOB, animal_gender, animal_breed, animal_display, user_id) VALUES ('$this->animal_name', '$this->department_id', '$this->animal_DOB', '$this->animal_gender', '$this->animal_breed', '$this->animal_display', '$this->user_id')";
			$this->db->query($sql);
			$this->result = $this->db->execute();
			echo '<script type="text/JavaScript">
            		alert("Animal was successfully added.");
           		window.location.replace("addAnimalList.php");
            		</script>'
			;
		}catch(PDOException $e){
			echo '<script type="text/JavaScript">
                	alert("An error occured when inserting this animal (Possibly a duplicate).");
               		window.location.replace("addAnimal.php");
                	</script>'
			;
		}
		//header("Location: http://www.zoonika.com/addAnimalList.php");
		}
	}
}