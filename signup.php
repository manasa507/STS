<?php
// @author: Ramarao
require_once('models/dept.php');
require_once('models/user.php');

$deptObj = new Dept();
$select = $deptObj->getDept();

$userName = $lastName = $mobileNumber = $emailId = $password = $filledMaleValue = $filledFemaleValue = $userNameError = $mobileNumberError = $emailError = $passwordError = $passwordMatchError = $check = $genderError = $successMessage = $deptError= $imgError="";

if(isset($_POST["Submit"]))
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

		if(!isset($_POST["mobileNumber"]) ||$_POST["mobileNumber"] === "")
		{
			$check = false;
			$mobileNumberError="Enter mobilenumber";
		}
		else
		{
			//@desc validate the mobilenumber with regular expression
			$mobileNumber = $_POST["mobileNumber"];
			if (preg_match("/^(?=.*\d).{10}$/", $mobileNumber)){$check = true;}
			else{
				$check = false;
				$mobileNumberError = "Enter 10 digit number";}
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
			if (preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/", $password)){
				
			}
			else{$passwordError = "should contain alphabets,numbers and min of 6 charaters";}
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

	

		if(isset($_FILES["fileToUpload"]))  
	  	{
	    	$fileToUpload = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));  
	    	$image_name = addslashes($_FILES['fileToUpload']['name']);  
	    }
		
		$target_dir = "../sts/uploads/";  
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		// $check = true;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



    	
    	$size = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    	if($size !== false) {
        	// echo "File is an image - " . $ram["mime"] . ".";
        	$check = true;
    	} else {
        	$imgError = "File is not an image.";
        	$check = false;
    	}
	
	
		// Check if file already exists
		if (file_exists($target_file)) 
		{
		    $imgError = "Sorry, file already exists.";
		    $check = false;
		}
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) 
		{
		    $imgError = "Sorry, your file is too large.";
		    $check = false;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
		{
		    $imgError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $check = false;
		}
		
		// Check if $check is set to 0 by an error
		if ($check == false) 
		{
		    $imgError = "Select an image.";
		// if everything is ok, try to upload file
		}
		else
		{ 
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			{
        		// echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    		} 
    		else
    		{
       			$imgError = "Sorry, there was an error uploading your file.";
    		}
		}

		if($check == true)
		{
			$id = $_SESSION["id"] ;
			$UsersObject = new User();

					
			// desc users object calling for insertion of data when all fields are filled
			$addData = array("name"=>$userName,
							"email"=>$emailId,
							"password"=>$password,
							"mobile"=>$mobileNumber,
							"gender"=>$Gender,
							"deptId"=>$deptSelectedOption,
							"image"=>$image_name);
			$successMessage = $UsersObject->insert($addData);
			//$successMessage = $UsersObject->insertDataFromForm($userName, $emailId,$password, $mobileNumber,$Gender, $deptSelectedOption, $image_name);
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
	<link rel="icon" type="image/png" href="assets/img/icons/credencys.ico"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="assets/css/signup.css">
</head>
<body>
	<div class="mainbox">
	<form action="<?php $_PHP_SELF ?>" method="POST" enctype="multipart/form-data">
		
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

            <label>PROFILE PIC</label>
            <input type="file" name="fileToUpload" id="fileToUpload">
           	<p class="errorMessage"><?=$imgError?></p>

			<input type="submit" name="Submit">

			
		</fieldset>
		<div class="message">
			<a class="login" href="../sts/login.php"><?=$successMessage?></a>  
			<br>
			<a class="login" href="../sts/login.php">LOGIN</a>
			<i class="fa fa-long-arrow-right"></i>

		</div>	
	
	</form>
</div>

</body>
</html>