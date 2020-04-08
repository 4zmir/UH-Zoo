<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);


Class MemberClass
{
	public $post;
	
	public $sale_id;
	public $member_fname;
    public $member_lname;
    public $member_fsize;
	public $user_id;

	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->id =$_COOKIE['user_id'];
		$this->user_id=$_COOKIE['user_id'];
		$this->sale_id = $this->post['sale_id'];
		$this->member_fname = $this->post['member_fname'];
        $this->member_lname = $this->post['member_lname'];
        $this->member_fsize = $this->post['member_fsize'];

		
		
		

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
		$sql = "INSERT INTO  member (sale_id, member_fname, member_lname, member_fsize, user_id) 
                VALUES ('$this->sale_id', '$this->member_fname', '$this->member_lname', '$this->member_fsize', '$this->user_id')";
		$this->db->query($sql);
		$this->result = $this->db->execute();
		echo '<script type="text/JavaScript">
		alert("Member was successfully added.");
            	window.location.replace("memberList.php");
            	</script>'
            	;
		}catch(PDOException $e){
			echo '<script type="text/JavaScript">
                	alert("An error occured when inserting this member (Possibly a duplicate).");
                	window.location.replace("memberInput.php");
                	</script>'
                	;
		}
		//header("Location: http://www.zoonika.com/prdtInput.php");
		}
	}
}