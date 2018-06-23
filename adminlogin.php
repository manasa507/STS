<?php

require_once 'models/user.php';
$credErr = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $userName=$_POST["username"];
    $password=$_POST["password"];
    $loginObj=new User();
    $credErr=$loginObj->adminLogin($userName,$password);

}
 
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <link rel="shortcut icon" href="assets/img/logo-footer.png">

  <title>Adminlogin</title>

  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="assets/css/bootstrap-theme.css" rel="stylesheet">
  <!-- font icon -->
  <link href="assets/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!--external css-->
  <link href="assets/css/style.css" rel="stylesheet">
  
</head>

<body class="loginadmin">

 	<div class="container">
  	
    <form class="loginform" name="login" method="POST" action="adminlogin.php" onsubmit="return validate();" >
      	<div class="loginblock">
          	<p class="lockicon">
                <i class="icon_lock_alt"></i>
            </p>
            <h4 class="adminname">Admin login</h4>

          	<div class="input-group">
           		 <span class="input-group-addon">
                  <i class="icon_profile"></i>
                </span>
            		<input type="text" class="form-control" placeholder="Username" name="username"  autofocus>
  			    </div>
          	<span id="userErr"></span>

          	<div class="input-group">
  	        	  <span class="input-group-addon">
                  <i class="icon_key_alt"></i>
                </span>
  	      		 <input type="password" class="form-control" placeholder="Password" name="password">
          	</div>
            <span id="pwdErr"></span>
            <span class="error"><?=$credErr?></span>

        	   <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Login">
     	  </div>
    </form>

    <div class="text-right">
	      <div class="credits">
	          <a href="#">Supporting ticket system by</a><br> 
            <a href="https://www.credencys.com/" target="blank">Credencys</a>
	       </div>
	  </div>

 	</div>
  
  <script type="text/javascript" src="assets/js/adminlogin.js"></script>

</body>

</html>
