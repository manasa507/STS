<?php
      require 'models/user.php';
      require_once 'models/modelwrapper.php';
      //modal form validations
	$emailRecrd = 'email';
      $name = $_POST['name1']; // Fetching Values from URL.
      $email = $_POST['email1'];
      $mobile = $_POST['mobile1'];
      $gender = $_POST['gender1'];
      $dept = $_POST['dept1'];
      $password = $_POST['password1']; 
      $role= $_POST['role1']; 
      $pager = 'users.php';
      // Check if e-mail address syntax is valid or not
      $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Sanitizing email(Remove unexpected symbol like <,>,?,#,!, etc.)
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "Invalid Email.......";
      }
      else if(!preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/", $password)){
            echo "Password should be alphanumeric.......";
      }

      else
      {
            $userObj = new User();
            $modelObj = new ModelWrapper();
            $selectId =  $userObj->selectById($emailRecrd,$email);
            $result =  $modelObj->numRows($selectId);
            if(($result)==0)
            {
                  $insertData = array("name"=>$name,
                        "email"=>$email,
                        "password"=>$password,
                        "mobile"=>$mobile,
                        "gender"=>$gender,
                        "deptId"=>$dept,
                        "role"=>$role); 
                  $query = $userObj->insert($insertData);
                  if($query){
                  echo "You have Successfully Registered.....";

                  }else
                  {
                        echo "Error....!!";
                  }
            }else{
                  echo "This email is already registered, Please try another email...";
            }
      }
?> 