<?php
session_start();
require_once 'models/user.php';

	$error = "";
	$errorMessage = "";
	if(isset($_POST["submit"]))
	{	
		$check =  true;
		if(!isset($_POST["emailId"]) || $_POST["emailId"] === "")
		{
			$check = false;
			$error = "*";
		}
		else
		{
			$emailId = $_POST["emailId"];
			$_SESSION["email"] = $emailId;	
		}

		if(!isset($_POST["password"]) || $_POST["password"] === "")
		{
			$check = false;
			$error = "*";
		}
		else
		{
			$password = $_POST["password"];
		}


		if($check == true)
		{
			$userObj = new User();
			$message = $userObj->validation($emailId, $password);

			if($message == true)
			{
			    header("Location:userhome.php");
			}
			else
			{
				$errorMessage = "INVALID CREDENTIALS";
				session_unset();
				session_destroy();
			}
		}

	}

	if(!empty($_POST["submit"]))
	{
	 	if(!empty($_POST["remember"])) 
		{
			setcookie ("userEmail",$_POST["emailId"],time()+ (10 * 365 * 24 * 60 * 60));
			setcookie ("userPassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
		} 
	}

?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="assets/img/icons/credencys.ico"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/login.css">
	</head>

	<body>
		
		<div class="Page">

			<div class="loginPage">
			
				<div class="container">
				
					<div class="bgimg" style="background-image: url(assets/img/bg-01.jpg);">
						<span class="title"> Support Ticketing System </span>
					</div>

					<form class="form" action="<?php $_PHP_SELF ?>" method="POST">

						<table align="center" cellpadding = "10">
						  
							<tr>
								<td class="label" >Email Id</td>
								<td class="label" >
									<input type="text" name="emailId" value="<?php if(isset($_COOKIE["userEmail"])) { echo $_COOKIE["userEmail"]; } ?>">
								</td>
								<td class="errorMessage"><?=$error?></td>
							</tr>
							
							<tr>
						 		<td class="label" >Password</td>
						 		<td class="label">
						 			<input type="password" name="password" value="<?php if(isset($_COOKIE["userPassword"])) { echo $_COOKIE["userPassword"]; } ?>" >
						 		</td>
						 		<td class="errorMessage"><?= $error?></td>
						 	</tr>
						 						
							<tr>
								<td></td>
								<td class="label" > 
									<input type="checkbox" name="remember" <?php if(isset($_COOKIE["userEmail"])) { ?> checked <?php } ?> />Remember me 
						 		</td>
							</tr>

							<tr>
								<td align="center" colspan="2">
									<input class="btn" type="submit" name="submit">					
							    </td>
							</tr>
							
							<tr>
								<td> <a href="forgotpassword.php">Forgot Password?</a></td>
								<td>
									<a href="../sts/signup.php" > Create account</a>
									<i class="fa fa-long-arrow-right"></i>
								</td>
								
							</tr>

							<tr>
								<td colspan="2" class="errorMessage" align="center">
									<?= $errorMessage?>
								</td>
							</tr>
							
						</table>			

					</form>
			
				</div>		
			</div>	
		</div>
		

	</body>

</html>