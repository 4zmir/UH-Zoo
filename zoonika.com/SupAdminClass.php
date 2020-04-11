<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class SupAdminClass
{
	public $post;
	
    public $user_fname;
    public $user_lname;
    public $user_DOB;
    public $user_gender;
    public $user_email;
    public $user_password;
	public $department_id;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
        $this->user_fname = $this->post['user_fname'];
        $this->user_lname = $this->post['user_lname'];
        $this->user_DOB = $this->post['user_DOB'];
        $this->user_gender = $this->post['user_gender'];
        $this->user_email = $this->post['user_email'];
        $this->user_password = $this->post['user_password'];
		$this->department_id = $this->post['department_id'];
		$this->user_id=$this->post['user_id'];

		$sql = "SELECT * FROM user WHERE user_id = '$this->user_id'";
		 
		$this->db->query($sql);
		$this->result = $this->db->single();
		$this->checkCookie();
		$this->profileFill();
	}
	public function render(){
	  echo "<PRE>";
	  print_r($this->department_id);
	}
	
	public function checkCookie(){
	 if(!$_COOKIE['user_id'] ){
		header('Location: index.html');
		}
	}

	
	public function profileFill(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
		$sql = "INSERT INTO  user (user_fname, user_lname, user_DOB, user_gender, user_email, user_password, department_id) 
                VALUES ('$this->user_fname', '$this->user_lname', '$this->user_DOB', '$this->user_gender', '$this->user_email', '$this->user_password', '$this->department_id')";

		$this->db->query($sql);
		$this->result = $this->db->execute();
		echo '<script type="text/JavaScript">
		alert("Employee was successfully added.");
            	window.location.replace("supAdminEmpList.php");
            	</script>'
            	;
		}catch(PDOException $e){
			echo '<script type="text/JavaScript">
                	alert("An error occured when inserting this employee (Possibly a duplicate).");
                	window.location.replace("supAdminEmpInput.php");
                	</script>'
                	;
		}
		//header("Location: http://www.zoonika.com/prdtInput.php");
		}
	}
}