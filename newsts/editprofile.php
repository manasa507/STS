<?php
    session_start();
    require 'includes/connect.php';
	$msg = '';
    $email = $_SESSION["email"];
    $sql = mysqli_query($conn,"SELECT name,email,mobile,password FROM user WHERE email = '$email'");
    while($row = mysqli_fetch_array( $sql ))
    {      
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        
        $password = $row['password'];
    } 
    if (isset($_POST['submit']))
    {
        $mobile = $_POST['mobile'];
        
        $newPassword = $_POST['newPassword'];
        $re_pass = $_POST['re_password'];
        
            if (mysqli_num_rows ($sql) != 0) 
            {

                if ($password == $password)
                {
                    if(preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/",$newPassword))
                    {
                        if ($newPassword == $re_pass)
                        {
                            if (preg_match("/^(?=.*\d).{10}$/", $mobile))
                            {   
                                $updateRecrd = mysqli_query($conn,"UPDATE user SET mobile='$mobile' , password='$newPassword' WHERE email= '$email'");
                                echo "<script>alert('Update Sucessfully'); window.location='editprofile.php'</script>";
                            }else{
                                echo "<script>alert('Enter 10 digit mobile no'); window.location='editprofile.php'</script>";
                            }
                        }else
                        {
                            echo "<script>alert('Your new and Retype Password is not match'); window.location='editprofile.php'</script>";
                        }
                    }else
                    {
                     echo "<script>alert('should contain alphabets,numbers and min of 6 charaters'); window.location='editprofile.php'</script>";
                    }
                }
                else
                {
                    echo "<script>alert('Your old password is wrong'); window.location='editprofile.php'</script>";
                }
            }
            else
            {
                echo "<script>alert('user not exist'); window.location='editprofile.php'</script>";
            }
        

    }
?>
<!DOCTYPE html>
    <head>
        <title >Edit User Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="assets/css/editprofile.css">
        <script type="text/javascript">
            function show(id){
                if(document.getElementById(id).style.display=="none"){
                document.getElementById(id).style.display="block";
                }
                else{
                document.getElementById(id).style.display="none";
                }

            }
            function clearFields(id) {
                document.getElementById(id).value="";
                document.getElementById(id).value="";
                document.getElementById(id).value="";
            }
          
        </script>
    </head>
    <body>

        <div class="header">

            <nav class="navbar navbar-inverse">
              <div class="container-fluid">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                  </button>
                  <a class="navbar-brand" href="https://www.credencys.com/">Credencys</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="userhome.php">Home</a></li>
                    
                    <li><a href="#">News</a></li>
                    <li><a href="#">About</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            
                            <span class="glyphicon glyphicon-user"></span>
                        </a>
                            <ul class="dropdown-menu">
                                <li><a href="editprofile.php">profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            
                            </ul>
                    </li>
                    
                    
                  </ul>
                </div>
              </div>
            </nav>
    
        </div>
        <form method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
            <div class="container">
                <div class="full-width bg-transparent"> 
                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12">
                        <h1 class="text-center black-color">Edit User Profile</h1>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                             <div class="custom-form">
                                <div class="text-center bg-form">
                                    <div class="img-section">
                                        <img src="http://www.gallery.qeshm.ir/Content/Images/default-avatar.jpg" class="imgCircle" width="50%" height="80%">
                                        <span class="glyphicon glyphicon-camera" id="PicUpload"></span>
                                    </div>
                                    <input type="file" id="image-input" onchange="readURL(this);" accept="image/*"  class="form-control form-input Profile-input-file" disabled>
                                    <div class="col-lg-12">
                                        <a href="#" onclick="show('pswrd')" >
                                            <h4 class="text-right col-lg-12">
                                           <span  class="glyphicon glyphicon-edit"></span> Edit Profile</h4>
                                            <input type="checkbox" class="form-control" id="checker">
                                        </a>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12">
                                    <input type="text" class="form-control form-input"  placeholder="Name"  name="name" id="name" value="<?= $name;?>" disabled>
                                    <span class="glyphicon glyphicon-user input-place"></span>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <input type="text" class="form-control form-input" placeholder="Email ID"  id="email" name="email" value="<?= $email;?>" disabled>
                                    <span class="glyphicon glyphicon-envelope input-place"></span>
                                    <span class="error"> </span>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <input type="text" class="form-control form-input" placeholder="mobile Number"  id="mobile" name="mobile" value="<?= $mobile;?>" onclick="clearFields('mobile');" disabled >
                                    <span class="error"> </span>
                                    <span class="glyphicon glyphicon-earphone input-place"></span>
                                </div>

                                
                               <!--password section-->
                                
                                <div class="col-lg-12 col-md-12">
                                    <input type="password" class="form-control form-input"  placeholder="Password"  id="password" name="password"  value="<?= $password;?>"  onclick="clearFields('password');" disabled>
                                    <span class=" glyphicon glyphicon-lock input-place"></span>
                                </div>
                            
                                <div style="display: none;" id ="pswrd">
                                
                                    <div class="col-lg-12 col-md-12"  >
                                        <input type="password" class="form-control form-input"  placeholder="NewPassword"  id="newPassword" name="newPassword"><?php echo $msg;?>
                                        <span class=" glyphicon glyphicon-lock input-place"></span>
                                    </div>
                                    <div class="col-lg-12 col-md-12"  >
                                        <input type="password" class="form-control form-input"  placeholder="ConfirmPassword" name="re_password">
                                        <span class=" glyphicon glyphicon-lock input-place"></span>
                                    </div>
                                </div>
                               
                                <div class="col-lg-12 col-md-12 text-center">
                                    <input type = "submit" name="submit"  class="btn btn-info btn-lg custom-btn" id="submit" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
     <script type="text/javascript" src="assets/js/profile.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   
</html>




  
 