<?php
    /*@desc editing the user profile
      @ author manasa
      @ version 7.0
      @ date 20/06/18
    */
    session_start();
    require_once 'includes/dbconnect.php';
    require_once 'upload.php';
    $msg = '';
    $email = $_SESSION["email"];
    $userObj = new User();
    // fetch particular usrer information from user table
    $sql = $userObj->selectById($email);
    $rows = $userObj->fetchArray($sql);
    $name =  $rows['name'];
    $email =  $rows['email'];
    $mobile =  $rows['mobile'];
    $password =  $rows['password'];
    $picture =  $rows['picture'];
    $_SESSION['$picture'] = $picture;
    $dp = $_SESSION['$image'];

    if (isset($_POST['submit']))
    {
        $mobileNo = $_POST['mobile'];
        $oldPass = $_POST['password'];
        $newPassword = $_POST['newPassword'];
        $re_pass = $_POST['re_password'];
     if(isset($_FILES["fileToUpload"]))
    {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) 
      {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) 
        {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } 
        else 
        {
          echo "File is not an image.";
          $uploadOk = 0;
        }
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) 
      {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) 
      {
        echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } 
      else 
      {
        if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
          echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } 
        else 
        {
          echo "Sorry, there was an error uploading your file.";
        }
      }
      if(isset($_FILES["fileToUpload"]))  
      {
        $fileToUpload = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));  
        $image = addslashes($_FILES['fileToUpload']['name']); 
       
    }
    $imgField = 'image';
                if(!empty($image))
                {
                    $userObj->update($imgField,$image,$email); 
                    echo "<script>alert('Update Sucessfully'); window.location='editprofile.php'</script>";  
                }
                else{
                {
                    $userObj->update($imgField,$dp,$email); 
                    echo "<script>alert('Update Sucessfully'); window.location='editprofile.php'</script>";  
                }
            }

        $rows = $userObj->numRows($sql);
    
        if ($rows != 0) 
        {
            if(!empty($newPassword || $mobileNo || $image))
            {  
                if($password == $oldPass){}
                else{
                    echo "<script>alert('Please Enter Valid Old Password'); window.location='editprofile.php'</script>";
                }
                if(!empty($newPassword))
                {
                    if(preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/",$newPassword))
                    {
                        if ($newPassword == $re_pass){
                            $pswrdField = 'password';
                            $updateRecrd = $userObj->update($pswrdField,$newPassword,$email);
                            echo "<script>alert('Update Sucessfully'); window.location='editprofile.php'</script>";
                        }
                        else
                        {
                            echo "<script>alert('Your new and Retype Password is not match'); window.location='editprofile.php'</script>";
                        }
                    }
                    else
                    {
                     echo "<script>alert('should contain alphabets,numbers and min of 6 charaters'); window.location='editprofile.php'</script>";
                    }
                }
                
                }
                if($mobileNo != $mobile){
                    if (preg_match("/^(?=.*\d).{10}$/", $mobileNo))
                    {
                        $mobileField = 'mobile';
                        $updateRecrd = $userObj->update($mobileField,$mobileNo,$email);
                        echo "<script>alert('Updafghhte Sucessfully'); window.location='editprofile.php'</script>";
                    }
                    else{
                        echo "<script>alert('Enter 10 digit mobile no'); window.location='editprofile.php'</script>";
                    }
                }
                else{
                    echo "<script>alert('Profile Not Updated'); window.location='editprofile.php'</script>";
                }
            }
            else
            {
                echo "<script>alert('profile not updated'); window.location='editprofile.php'</script>";
            }
        }
    }
    
?>
<!DOCTYPE html>
    <head>
        <title >Edit User Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/editprofile.css">
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
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="editprofile.php">profile</a></li>
                                    <li><a href="userlogout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <form  action="editprofile.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="full-width bg-transparent"> 
                    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12">
                        <h1 class="text-center black-color">Edit User Profile</h1>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="custom-form">
                                <div class="text-center bg-form">
                                    <div class="img-section">
                                        <?php
                                            $files = glob("uploads/*.*");
                                            for ($i=0; $i<count($files); $i++)
                                            {   
                                              $num = $files[$i];
                                             
                                              if($files[$i] == "uploads/".$picture)
                                                {
                                                echo '<img src="'.$num.'" alt="random image">'."&nbsp;&nbsp;";
                                                }
                                            }
                                        ?>  
                                        <span class="glyphicon glyphicon-camera" id="PicUpload"></span>
                                    
                                        <input type="file" id="image-input" onchange="readURL(this);" accept="image/*" name="fileToUpload" value="$picture" class="form-control form-input Profile-input-file" disabled>
                                    </div>
                                    <div class="col-lg-12">
                                        <a href="#" onclick="show('pswrd')" >
                                            <h4 class="text-right col-lg-12">
                                               <span  class="glyphicon glyphicon-edit"></span> Edit Profile
                                            </h4>
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




  
