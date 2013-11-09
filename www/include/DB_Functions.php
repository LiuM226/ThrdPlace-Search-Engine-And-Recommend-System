<?php
/*
 * This file contains functions to store user in database, get user from database
 */
class DB_Functions{

	private $db;
	private $db_link;
	// constructor
	function __construct(){
		require_once 'DB_Connect.php';
		// Connecting to database
		$this->db = new DB_Connect();
		$this->db_link = $this->db->connect();
	}

	// destructor
	function __destruct(){

	}
	
	/*
	 * Get user by email and password
	 */
	public function getUserByEmailAndPassword($email, $password){
		$select = mysql_select_db("test", $this->db_link) or die("Could not select example");
		$result = mysql_query("SELECT * FROM users WHERE email = '$email'");
		// check for result
		$no_of_rows = mysql_num_rows($result);
		if ($no_of_rows > 0){
			$result = mysql_fetch_array($result);
			return $result;
		}else{
			return false;
		}
	}

	/*
	 * Check user is existing or not
	 */
	 
	public function isUserExist($email){
		$result = mysqli_query($this->db_link, "SELECT email from users WHERE email = '$email'") or die(mysqli_error($this->db_link));
		$no_of_rows = mysqli_num_rows($result);
		if($no_of_rows > 0){
			// user existing
			return true;
		}
		else{
			return false;
		}
	
	}
}

?>
