<?php
/*
 * This file is used connect or disconnect to the database.
 */
class DB_Connect{

	// constructor
	function __construct(){

	}

	// destructor
	function __destruct(){
		// $this->close();
	}

	// Connecting to database
	public function connect(){
		// require_once, includes and evaluates the file, if failed, produce error; 
		// if the file has been included, not include again.
		require_once 'config.php';

		// Connecting to mysql
		$con= mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		// Check connection
		if(!$con){
			die('Could not connect: ' . mysql_error());
		}
		// return database handler
		//echo "Database Connection succeed.<br>";
		return $con; 
	}

	// Closing database connection
	public function close(){
		mysqli_close();
	}
}


?>