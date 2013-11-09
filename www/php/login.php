<?php
/*
 * This file plays role of accepting requests and giving response.
 * On each request, it will talk to database and will give appropriate
 * response in JSON format.
 */

/*
 * Check for POST requet
 */
// isset, determine if a variable is set and is not NULL
if (isset($_POST['email'])){
	require_once '../include/DB_Functions.php';
	$db = new DB_Functions();
	$email = $_POST['email'];
	$password = $_POST['password'];
	$user = $db->getUserByEmailAndPassword($email, $password);
	if ($user != false){
		// user found
		// echo json with success = 1
		$response['success'] = 1;
		$response['user']['name'] = $user['name'];
		//$response['user']['name'] = "Tao Hu";
		$response['user']['location'] = $user['location'];
		//$response['user']['location'] = "San Francisco";
		echo json_encode($response);
	}
	else{
		// user not found
		// echo json with error = 1
		$response['error'] = 1;
		$response['error_msg'] = "Invalid email or password!";
		echo json_encode($response);
	}
}
else{
	$response['error'] = 2;
	$response['error_msg'] = "No Email";
	echo json_encode($response);
	
}


?>

