<?php
// @Author: Ramarao
require_once 'includes/dbconnect.php';

class Login
{
// @desc validates the user credentials
// @param $emailId, 
// @param $password
public function validation($emailId, $password) 
	{
		$dbConnectObject= new DatabaseConnection();
		$dbConnectObject->conn;

		$sql = "SELECT user.id AS id, user.name AS name, user.email AS email, user.password AS password, user.mobile AS mobile, user.isActive AS isActive, user.role AS role, dept.name AS deptName FROM user INNER JOIN dept ON user.deptId = dept.id WHERE email = '$emailId' AND password = '$password'";

		$result = mysqli_query($dbConnectObject->conn, $sql);

		if (mysqli_num_rows($result) > 0)
		{
			while($row = mysqli_fetch_assoc($result))
			{
        		$isActive = $row["isActive"];
        		$role = $row["role"];
        		$_SESSION["name"] = $row["name"];
        		$_SESSION["id"] = $row["id"];
        		$_SESSION["mobile"] = $row["mobile"];
        		$_SESSION["deptName"] = $row['deptName'];
    		}
    		if ($isActive == 1 && $role == "user") {
    			$message = true;
    		}
    		else{$message = false;}
		    
  
		}
		else
		{
			
		    $message = false;
		    
		}
		return $message;
	}
}



?>