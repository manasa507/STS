<?php
// @author: Ramarao
	require_once('models/dept.php');
	
	require_once('models/user.php');

	$deptObj = new Dept();
	$select = $deptObj->getDept();

	$userName = $lastName = $mobileNumber = $emailId = $password = $filledMaleValue = $filledFemaleValue = $userNameError = $mobileNumberError = $emailError = $passwordError = $passwordMatchError = $genderError = $successMessage = $deptError= "";

	if(isset($_POST["submit"]))
	{
		$check = true;
		if(!isset($_POST["userName"]) ||$_POST["userName"] === "")
		{
			$check = false;
			$userNameError="Enter Username";
		}
		else
		{
			$userName = $_POST["userName"];
		}

		if(!isset($_POST["mobileNumber"]) || $_POST["mobileNumber"] === "")
		{
			$check = false;
			$mobileNumberError="Enter mobilenumber";
		}
		else
		{
			//@desc validate the mobilenumber with regular expression
			$mobileNumber = $_POST["mobileNumber"];
			if (preg_match("/^(?=.*\d).{10}$/", $mobileNumber))
			{
				$check = true;
			}
			else
			{
				$check = false;
				$mobileNumberError = "Enter 10 digit number";
			}
		}
		
		if(!isset($_POST["emailId"]) || $_POST["emailId"] === "")
		{
			$check = false;
			$emailError = "Enter Email";
		}
		else
		{
			//@desc validate the email with FILTER_VALIDATE_EMAIL keyword
			$emailId = $_POST["emailId"];
			if (!filter_var($emailId, FILTER_VALIDATE_EMAIL))
			{
			 	$emailError = "Error in email format";
			}
		}

		if(!isset($_POST["password"]) || $_POST["password"] === "")
		{
			$check = false;
			$passwordError = "Enter Password";
		}
		else
		{
			$password = $_POST["password"];
			//@desc validate the password with regular expression
			if (preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/", $password))
			{
				
			}
			else
			{
				$passwordError = "should contain alphabets,numbers and min of 6 charaters";
			}
		}

		if(!isset($_POST["confirmPassword"]) || $_POST["confirmPassword"] === "" )
		{
			$check = false;
			$passwordMatchError = "Enter Confirm Password";
		}
		else
		{
			$confirmPassword = $_POST["confirmPassword"];
			if ($password!==$confirmPassword) 
			{
      			$passwordMatchError = "Password does not match"; 
      		}
		}

		if(!isset($_POST["Gender"]) || $_POST["Gender"] === "" )
		{
			$check = false;
			$genderError="Select Gender";
		}
		else
		{	
			$Gender = $_POST["Gender"];
			if($_POST["Gender"]=== 'Male'){$filledMaleValue = "checked";}
			else{$filledFemaleValue = "checked";}
		}

		if(!isset($_POST["dept"]) || $_POST["dept"] === "" || $_POST["dept"][0] == 'none')
		{
			$check = false;
			$deptError = "Select Department";			
		}
		else
		{
			$dept = $_POST['dept'];
			$deptSelectedOption=implode("",$dept);
			
		}

		if($check == true)
		{
			$id = $_SESSION["id"];
			$userObj = new User();
			
			$successMessage = $userObj->insertDataFromForm($userName, $emailId, $mobileNumber, $password, $Gender, $deptSelectedOption);

			//desc after insertion of data making the fields empty
			if($successMessage == "Registered Successfully" )
			{
				$userName = $lastName = $mobileNumber = $emailId = $password = $filledMaleValue = $filledFemaleValue =  "";
				unset($deptCheck); 
			}

		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign UP form</title>
	<link rel="icon" type="image/png" href="assets/images/icons/credencys.ico"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="assets/css/signup.css">
</head>
<body>
	<div class="mainbox">
	<form action="<?php $_PHP_SELF ?>" method="POST">
		
		<h1>SIGNUP FORM</h1>

		<fieldset>
			<label>Username</label>
            <input type="text" name="userName" value="<?= $userName?>" >
            <p class="errorMessage"><?= $userNameError?></p>

            <label>Email Id</label>
            <input type="text" name="emailId" value="<?= $emailId?>" >	
            <p class="errorMessage"><?=$emailError?></p>

            <label>Mobile Number</label>
            <input type="text" name="mobileNumber" value="<?= $mobileNumber?>" >
            <p class="errorMessage"><?= $mobileNumberError?></p>

            <label>Password</label>
            <input type="password" name="password" value=""></td>
            <p class="errorMessage"><?= $passwordError?></p>

            <label>Confirm Password</label>
            <input type="password" name="confirmPassword" >
            <p class="errorMessage"><?= $passwordMatchError?></p>

            <label>Gender</label>
            <input type="radio" name="Gender" value="Male" <?= $filledMaleValue?> >Male <br>
			<input type="radio" name="Gender" value="Female" <?= $filledFemaleValue?> >Female 
            <p class="errorMessage"><?= $genderError?></p>

            <label>DEPARTMENT</label>
            <select name="dept[]">
            	<option> --select-- </option>
            	<?= $select ?>
            </select>
            	
			<p class="errorMessage"><?= $deptError?></p>

			<input type="submit" name="submit">

			
		</fieldset>
		<div class="message">
			<a class="login" href="../sts/login.php"><?=$successMessage?></a>  
			<a class="login" href="../sts/login.php">LOGIN</a>
			<i class="fa fa-long-arrow-right"></i>

		</div>	
	
	</form>
</div>

</body>
</html>