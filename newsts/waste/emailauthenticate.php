<?php
require_once 'includes/connection.php';
session_start();
/*
  @author: Sridevi
  @desc to check email and update password
  @version PHP 7.0.29-1
*/ 
class Forgotpwd
{
  /*
    @desc to check email is valid or not
    @param string $email
    @return string $credErr
  */
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


}


?>