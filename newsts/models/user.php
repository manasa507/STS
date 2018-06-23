<?php
require_once 'includes/dbconnect.php';
require_once 'includes/connection.php';
session_start();
	
	class User
	{
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
      
	     	$connectionObj=new Connection("localhost","root","123","sts");
	     	$sql="SELECT id,email FROM user where email='$email' AND role='user' ";
	      	$result = mysqli_query($connectionObj->conn,$sql);
	      	if ($result->num_rows == 1 )
	      	{

		          $row=mysqli_fetch_array($result);
		          $id=$row['id'];
		          $emailId=$row["email"];
		          $_SESSION['email']=$emailId;
		          $uniqidStr = md5(uniqid(mt_rand()));
		          $_SESSION['token'] = $uniqidStr;
		          $sql = "UPDATE user SET `password`= '$uniqidStr'  WHERE email = '$emailId'";
		          $result = mysqli_query($connectionObj->conn,$sql);
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
		    $connectionObj=new Connection("localhost","root","123","sts");
		    $sql = "SELECT password,name from user where id = '$id' ";
		    $result = mysqli_query($connectionObj->conn,$sql);
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
		            $result = mysqli_query($connectionObj->conn,$sql);
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