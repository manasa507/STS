<?php
require_once 'models/user.php';
session_start();


  if(isset($_GET['userId']))
  { 
       $_SESSION['userid']  = rtrim($_GET['userId'],'/');
  }

  if(isset($_POST['submit']))
  {
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirmpassword'];
      $enteredToken = $_POST['token']; 

      $id = $_SESSION['userid'];
      $userObj=new User();
      $matchErr=$userObj->passwordUpdation($id,$password,$confirmPassword,$enteredToken);  
  }

 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <link rel="icon" type="image/png" href="images/icons/credencys.ico"/>

  <title>Resetpassword</title>

  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="assets/css/bootstrap-theme.css" rel="stylesheet">
  <!-- font icon -->
  <link href="assets/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!--external css-->
  <link href="assets/css/forgot.css" rel="stylesheet">
  
</head>

<body>
  	
    <form class="reset" name="resetform" method="POST" action="resetpassword.php" onsubmit="return validation();" >
          	<p class="lockicon">
                <i class="icon_lock_alt"></i>
            </p>
            <h4 class="resetpassword">Resetpassword</h4>    

			      <div class="input-group">
  	        	  <span class="input-group-addon">
                  <i class="material-icons">edit</i>
                </span>
  	      		 <input type="text" class="form-control" placeholder="Enter token" name="token">
          	</div>
            <span id="tknErr"></span>

          	<div class="input-group">
  	        	  <span class="input-group-addon">
                  <i class="icon_key_alt"></i>
                </span>
  	      		 <input type="password" class="form-control" placeholder="Password" name="password">
          	</div>
            <span id="pwdErr"></span>


            <div class="input-group">
  	        	  <span class="input-group-addon">
                  <i class="icon_key"></i>
                </span>
  	      		 <input type="password" class="form-control" placeholder="ConfirmPassword" name="confirmpassword">
          	</div>
            <span id="cpwdErr"></span>


            <span class="error"><?=$matchErr?></span>

        	  <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Changepassword">
    </form>

 	</div>
  <script type="text/javascript" src="assets/js/forgot.js"></script>
  
</body>

</html>
