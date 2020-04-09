<?PHP
include "Database.php";

Class forgotpasswordClass
{
	public $post;
	
	public $user_email;
	public $user_DOB;
	public $user_password; //current forgotten password
	//public $password; // new password
	public $passwordConfirm; // confirm newpassword
	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		
		$this->user_email = $this->post['user_email'];
		$this->user_DOB = $this->post['user_DOB'];
		$this->user_password = $this->post['user_password'];
		$this->passwordConfirm = $this->post['passwordConfirm'];// $this points to the class property.

		
		//$sql = "SELECT user_email, user_DOB FROM user WHERE user_email = $this->user_email AND user_DOB = $this->user_DOB ";
		//$this->db->query($sql);
		//$this->result = $this->db->single(); // $this->result->user_email
		//$this->checkUsrNm();
		$this->checkpwd();
	}
	
	//public function render(){
	// echo "<pre>";
	//  print_r($this->post);
	//}

	
	public function checkpwd(){
		if ($this->user_password == $this->passwordConfirm && !(empty($this->user_email)) && !(empty($this->user_DOB)) ) {
			
			$sql = "SELECT user_email, user_DOB FROM user WHERE user_email = '$this->user_email' AND user_DOB = '$this->user_DOB' ";
			$this->db->query($sql);
			$this->result = $this->db->single(); // $this->result->user_email
			if(!$this->result){
			echo '<script type="text/JavaScript">
            		alert("Password update failed! Incorrect Username and/or DOB!");
           		window.location.replace("forgotpassword.php");
            		</script>'
			;
			}
			


			$sql = "UPDATE user SET user_password = '$this->user_password' WHERE user_email = '$this->user_email' AND user_DOB = '$this->user_DOB' ";
			$this->db->query($sql);
			$this->db->execute();
			//header("Location: login.html"); /*  */
			echo '<script type="text/JavaScript">
            		alert("Your password was successfully updated.");
           		window.location.replace("login.html");
            		</script>'
			;	
		} 
		else {
			//header("Location: login.html"); /* error */
			echo '<script type="text/JavaScript">
            		alert("Password update failed! New Password did not match with Confirm New Password!");
           		window.location.replace("forgotpassword.php");
            		</script>'
			;     
		}
		}	
 }
?>

		

