
<?php
require_once 'models/user.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') 
  {
      $email=$_POST["email"];
      $userObj=new User();
      $credErr=$userObj->emailValidation($email);
  }
 
?>

<!DOCTYPE html>
<html>
    <head>

      <title>Forgotpassword </title>
      <link rel="icon" type="image/png" href="assets/images/icons/credencys.icon"/>
          <!-- Bootstrap CSS -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- bootstrap theme -->
      <link href="assets/css/bootstrap-theme.css" rel="stylesheet">
      <!-- font icon -->
      <link href="assets/css/elegant-icons-style.css" rel="stylesheet" />
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!--external css-->
      <link href="assets/css/forgot.css" rel="stylesheet">

    </head>

    <body>

      <form class="emailform" name="login" method="POST" action="forgotpassword.php" onsubmit="return validate();" >

              <h2 class="emailname">Enter the Email of Your Account to Reset New Password</h2>

              <div class="input-group">
                    <span class="input-group-addon">
                      <i class="icon_mail"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Email" name="email"  autofocus>
              </div>
              
              <span id="emailErr"></span>
              <span class="error"><?=$credErr?></span>

              <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Continue">

      </form>

      <script type="text/javascript" src="assets/js/forgot.js"></script>
    
    </body>
</html>

