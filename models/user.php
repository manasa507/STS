<?php
/**
   	@ desc Select class for all CRUD functionalities performs here.. 
    @ PHP version: 7.1.15
    @ date: 11-06-2018
    @ author: Saimanasa
    **/

	require_once 'includes/dbconnect.php';
	require_once 'includes/connection.php';
	session_start();
	require_once 'models/modelwrapper.php';
	
	class User 
	{
		
		
		/**
		@ desc selectAll function for fetch all no.of records in a particular table.
		@ param STRING  $tableName 
		@ param  STRING $columnName  
		@ return STRING $allRecords
		**/
		public function selectAll(){
			$tableName = 'dept';
			$columnName = 'id,name';
			$wrapperObj = new ModelWrapper();
        	$allRecords = $wrapperObj->selectAll($tableName,$columnName);
        	return $allRecords;
			
		}
		/**
		@ desc selectById function for fetch all no.of records in a table.
		@ param STRING  $tableName 
		@ param  STRING $columnName
		@ param  STRING $partRecrd is a field name
		@ param  STRING $fieldValue is a record value
		@ return STRING $response
		**/
		public function selectById($partRecrd,$id){
			$tableName = 'user';
			$columnName = '*';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->selectById($tableName,$columnName,$partRecrd,$id);
        	return $response;
		}
		/**
		@ author: Sridevi
		@ desc delete function for delete record by Id.
		@ param STRING  $table 
		@ param INT $id 
		@ param STRING  $pager 
		@ return STRING $response
		**/	
		public function delete($id){
			$table = 'user';
			$pager = 'users.php';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->delete($table,$id,$pager);
        	return $response;
		}
		/**
		@ desc update function for update user formData.
		@ param  STRING $formData 
		@ param  STRING $id  
		@ return STRING $response
		**/
		public function update( $formData, $id)
		{
			$tableName = 'user';
			$pager = 'users.php';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->update( $tableName,$pager,$formData,  "WHERE id = '$id'");
		    // run and return the query result
		    return $response;
		}

 		/**
		@ desc insert function for insert users into users table. 
		@ param  STRING $formData  
		@ return STRING $successMessage
		**/
		public function insert($formData)
		{
			$tableName = 'user';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->insert($tableName, $formData);
		    if($query === TRUE){
				$successMessage = "Registered Successfully";
			}
			else 
			{
				$error=   mysqli_error($dbConnectObject->conn);
				if (strpos($error, $email) !== false) {
					$successMessage = "Already registered with ".$email;
				}
				if (strpos($error, $mobileNumber) !== false) {
					$successMessage = "Already registered with ".$mobileNumber;
				}
			}

			return $successMessage;
		

		}
		
		/*
		@author: Sridevi
		@desc to check login details of admin
		@version PHP 7.0.29-1
	    @desc selecting data
	    @param string $userName
	    @param string $password
	    @return string $credErr
	  	*/
	  	public function adminLogin($userName,$password) 
		{

	  		$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;
			$wrapperObj = new ModelWrapper();
			$sql=mysqli_query($dbConnectObject->conn,"SELECT id,name,password FROM user where name='$userName' AND  password='$password' AND role='admin' ");
	     	if ($sql->num_rows == 1 )
	      	{
	      	
	          $row=$wrapperObj->fetchArray($sql);
	          $_SESSION["name"] = $row["name"];
	          $_SESSION["id"] = $row["id"];
	          header("Location:admin.php");
	      	} 
	      	else
	      	{
	     		$credErr="Invalid credentials";
	     		return $credErr;
	      	}	
		}

		public function validation($emailId, $password) 
		{
			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;

			$sql = "SELECT user.id AS id, user.name AS name, user.email AS email, user.password AS password, user.mobile AS mobile, user.isActive AS isActive, user.role AS role, dept.name AS deptName, user.image AS image FROM user INNER JOIN dept ON user.deptId = dept.id WHERE email = '$emailId' AND password = '$password'";

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
	        		$_SESSION["image"] = $row['image'];
	        	}

	    		if ($isActive == 1 && $role == "user")
	    		 {
	    			$message = true;
	    		}
	    		else
	    		{
	    			$message = false;
	    		}	    
			}
			else
			{
				
			    $message = false;
			    
			}
			return $message;
		}


		public function emailValidation($email) 
		{
      
	     	$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;
	     	$sql="SELECT id,email FROM user where email='$email' AND role='user' ";
	      	$result = mysqli_query($dbConnectObject->conn,$sql);
	      	if ($result->num_rows == 1 )
	      	{

		          $row=mysqli_fetch_array($result);
		          $id=$row['id'];
		          $emailId=$row["email"];
		          $_SESSION['email']=$emailId;
		          $uniqidStr = md5(uniqid(mt_rand()));
		          $_SESSION['token'] = $uniqidStr;
		          $sql = "UPDATE user SET `password`= '$uniqidStr'  WHERE email = '$emailId'";
		          $result = mysqli_query($dbConnectObject->conn,$sql);
		          if($result == TRUE)
		          {
		            $_SESSION['emailMsg'] = "http://192.168.11.157/sts/resetpassword.php?userId=$id";
		            header('location:mail.php');
		          }
         
      		} 
      		else
      		{
	     		$credErr="Invalid email";
	     		return $credErr;
      		}
		}


		/*
		    @desc to update password
		    @param int $id
		    @param string $password
		    @param string $confirmPassword
		    @param string $enteredToken
		    @return string $matchErr
		*/
		public function passwordUpdation($id,$password,$confirmPassword,$enteredToken)
		{
		    $dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;	
		    $sql = "SELECT password,name from user where id = '$id' ";
		    $result = mysqli_query($dbConnectObject->conn,$sql);
		    if($result == TRUE)
		    {
		        $num_rows=mysqli_num_rows($result); 
		        $row = mysqli_fetch_assoc($result);   
		        $uniqueToken = $row['password'];                    
		    }
		    if($enteredToken === $uniqueToken)
		    { 
		        if($password == $confirmPassword )
		        {  
		            $sql = "UPDATE user SET password= '$password'  WHERE id = '$id' ";       
		            $result = mysqli_query($dbConnectObject->conn,$sql);
		            if($result == TRUE)
		            {
		              header('location:login.php');
		            }
		        }
		        else
		        {
		          $matchErr= "Password Not Matched";
		          return $matchErr;
		        }
		    }
		    else
		    {
		        $matchErr= "Invalid Token";
		        return $matchErr;
		    }
		}

		public function insertDataFromForm($userName, $emailId, $password, $mobileNumber,$Gender, $deptId,$image)
		{

			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;

			$sql = "INSERT INTO user (name,email,password,mobile,gender,deptId,image) VALUES ('$userName','$emailId', '$password','$mobileNumber','$Gender','$deptId','$image')";

			
			if (mysqli_query($dbConnectObject->conn, $sql)) 
			{	
				$successMessage = "Registered Successfully" ;
			}
			else 
			{
				$x=mysqli_error($dbConnectObject->conn);
				if (strpos($x, $emailId) !== false)
				{
					$successMessage = "Already registered with ".$emailId;
				}
				if (strpos($x, $mobileNumber) !== false) 
				{
					$successMessage = "Already registered with ".$mobileNumber;
				}
			}
			return $successMessage;
		}

		
    }
?>