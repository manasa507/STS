<?php

require_once 'includes/dbconnect.php';

//@desc Users class insert data into users by taking data from index file

class Users 
{




public function insertDataFromForm($userName, $emailId, $mobileNumber, $password, $Gender, $deptId)
	{
		$dbConnectObject= new DatabaseConnection();
		$dbConnectObject->conn;

		$sql = "INSERT INTO user (name,email,mobile,password,gender,deptId) VALUES ('$userName','$emailId','$mobileNumber', '$password','$Gender','$deptId')";

		
		if (mysqli_query($dbConnectObject->conn, $sql)) 
			{	
				$successMessage = "Registered Successfully" ;
			}
			else 
			{
				
				$x=   mysqli_error($dbConnectObject->conn);
				
				if (strpos($x, $emailId) !== false) {
					$successMessage = "Already registered with ".$emailId;
				}
				if (strpos($x, $mobileNumber) !== false) {
					$successMessage = "Already registered with ".$mobileNumber;
				}
			}
			 return $successMessage;
	}

	
}

?>