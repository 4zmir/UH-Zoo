<?PHP
include "Database.php";
ini_set("display_errors",E_ALL);

Class loginClass
{
	public $post;
	public $user_email;
	public $user_password;
	public $department_id;
	public $db;
	public $result;
	public function __construct(Array $post)
	{
		$this->db = new Database();
		
		$this->post = $post; // $_POST array from form;
		$this->user_email = $this->post['user_email'];
		$this->user_password = $this->post['user_password'];
		$this->department_id = $this->post['department_id'];
		$sql = "SELECT * FROM user WHERE user_email = '$this->user_email' AND user_password = '$this->user_password' ";

		$this->db->query($sql);
		$this->result = $this->db->single();
		$this->login();
	}
	public function login(){
		 print_r($result);
		if($this->result){
			
		setcookie('user_id',$this->result->user_id,time()+(60*60),'/');
		
			if ($this->result->department_id =='1'){ /* Animal admin */

			exit(header("Location: addAnimalMenu.php")); /* Redirect browser */
			}
			if ($this->result->department_id =='3'){ /* Animal admin */

			exit(header("Location: ride_menu.php")); /* Redirect browser */
			}
			if ($this->result->department_id =='5'){ /* Animal admin */

			exit(header("Location: sale_menu.php")); /* Redirect browser */
			}
			if ($this->result->department_id =='6'){ /* Animal admin */

			exit(header("Location: product_menu.php")); /* Redirect browser */
			}
			else{ echo"different admin";}
		
		} else {
		exit(header("Location: login.html")); /* Wrong password, Go back to the same page  */

		}
	 }
	
}
?>