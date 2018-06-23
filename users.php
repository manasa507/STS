<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title>Users Database</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
      <!-- Bootstrap CSS -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- font icon -->
      <link href="assets/css/elegant-icons-style.css" rel="stylesheet"/>
      <!-- Custom styles -->
      <link href="assets/css/admin.css" rel="stylesheet">
      <link href="assets/css/admineff.css" rel="stylesheet">
      <link href="assets/css/style-responsive.css" rel="stylesheet"/>
      
       
    </head>

    <!-- myfun() for dtatables pagination -->
    <body onload= "myfun()">
      <?php
        require_once 'includes/connection.php';
        require_once 'models/user.php';
        require_once 'models/modelwrapper.php';
        // Here Parameters Declaration for fetch all table records ..... 
        $fields = 'id,name,email,mobile,isActive,createdAt';
        $partRecrd = 'id';
        $userObj = new User();
        $modelObj = new ModelWrapper();
        $allRecords = $userObj->selectById("role","user");
              
        //Delete particular record by id.
        if (isset($_GET['delId'])) {
          $id = $_GET['delId'];
          $records = $userObj->delete($id);
        }
        // fetch all department records
        $deptObj = $userObj->selectAll(); 
        $rowsObj = $modelObj->numRows($deptObj);
        $select = $modelObj->fetchAssoc($deptObj,$rowsObj);

        //for update user status
        if(isset($_POST['Submit']))
        {
          $id =$_POST['Submit'];
          $status = $userObj->selectById($partRecrd,$id);
          while($row = $modelObj->fetchArray($status))
          {
            $status = $row['isActive'];
            if($status == 0){
              $changeStatus = 1;
            }
            else{
               $changeStatus = 0;
            }
            $statusData = array("isActive"=>$changeStatus);
            $update = $userObj->update($statusData, $id);
           
          }
        }
        // for Update user Records
        if (isset($_POST['submit'])){
          $id = $_POST['id'];
          $name = $_POST['name'];
          $email = $_POST['email'];
          $mobile = $_POST['mobile'];
          $userData = array("name"=>$name,
                            "email"=>$email,
                            "mobile"=>$mobile);
          $updateDept = $userObj->update($userData, $id);

        }
      ?>
        <!-- container section start -->
        <section id="container">

        <!--header start-->
        <header class="header dark-bg">
          <div class="toggle-nav" >
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" id="toggle"  data-placement="bottom"><a href='javascript:'><i class="icon_menu"  ></i></a></div>
          </div>

          <!--logo start-->
          <a href="#" class="logo">SUPPORT TICKET SYSTEM</a>
          <!--logo end-->
          
          <div class="top-nav notification-row">
            <!-- user login dropdown start-->
            <ul>
              <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <span class="profile-ava">
                    <img class ="adminimg" alt="adminimg" src="assets/img/logo.png">
                  </span>
                  <span class="username">ADMIN</span>
                  <b class="caret"></b>
                </a>
                <!-- drop down profile -->
                <ul class="dropdown-menu extendedut">
                  <div class="log-arrow-up"></div>
                  <li>
                    <a href="logout.php"><i class="arrow_carrot-right_alt2"></i> Log Out</a>
                  </li>
                </ul>
              </li>
            </ul>
            <!-- user login dropdown end -->
          </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
          <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
              <li>
                <a href="admin.php">
                  <i class="icon_house_alt"></i>
                  <span>Dashboard</span>
                </a>
              </li>
             
             <li>
                <a href="users.php">
                  <i class="icon_id"></i>     
                  <span>Users</span>
                </a>
              </li>

              <li>
                <a href="deptinfo.php">
                  <i class="icon_building"></i>
                  <span>Department</span>
                </a>
              </li>

               <li>
                <a href="categories.php">
                  <i class="icon_table"></i>
                  <span>Category</span>
                </a>
              </li>

                <li>
                <a href="tickets.php">
                  <i class="icon_documents_alt"></i>
                  <span>Tickets</span>
                </a>
              </li>
            </ul>
            <!-- sidebar menu end-->
          </div>
        </aside>
        <!--sidebar end-->
      
      <!--Users Table-->
      <section id="main-content">
        <section id="container">
          <div class="col-lg-12 col-xs-12">
            <section class="card" style="size: 100px;">
              <header class="panel-heading">Users 
                <button class="pull-right control-group btn btn-default" data-toggle="modal" data-target="#reg">ADD USER</button>
              </header>
              <div style="overflow-x:auto;">
                <!-- modal form for add user data -->
                <form action="<?php $_PHP_SELF ?>" method="POST">
                  <table class="table table-striped table-advance table-hover" id="myTable">
                    <thead>
                      <tr>
                        <th> S.NO</th>
                        <th><i class="icon_profile"></i> Name</th>
                        <th><i class="icon_mail_alt"></i> Email</th>
                        <th><i class="icon_mobile"></i> Mobile</th>
                        <th><i class="icon_mobile"></i> Status</th>
                        <th><i class="icon_calendar"></i> Created At</th>
                        <th><i class="icon_cogs"></i> ChangeStatus</th>
                        <th><i class="icon_cogs"></i> Delete</th>
                        <th><i class="icon_cogs"></i> Update</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        $rowObj = $modelObj->numRows($allRecords);
                        if($rowObj > 0)
                        {
                          while ($row = $modelObj->fetchArray($allRecords))
                          {
                            $status = $row['isActive'];
                            if($status==0){
                              $changeStatus = "activate";
                            }
                            else{
                              $changeStatus ="deactivate";
                            }
                            $id = $row['id'];
                            echo "<tr>
                              <td>".$i++."</td>
                              <td>".$row['name']."</td>
                              <td>".$row['email']."</td>
                              <td>".$row['mobile']."</td>
                              <td>".$row['isActive']."</td>
                              <td>". date('F d, Y', strtotime($row['createdAt'])). "</td>
                              <div class='btn-group'>
                                  <td><button name='Submit' class='btn btn-default' value='$id' >$changeStatus</button>
                                  </td>
                              </div>
                              <div class='btn-group'>
                                  <td><a class='btn btn-danger' href='users.php?delId={$row['id']}'><i class='icon_trash'></i>DELETE</a>
                                  </td>
                              </div>
                               <div class='btn-group'>
                                  <td><b><button><a  href='users.php?update={$row['id']}'>UPDATE</a></button></b>
                                  </td>
                              </div>
                            </tr>" ;
                          }
                        }
                      ?>
                    </tbody>
                  </table>
                </form>
              </div>
            </section>
          </div>
        </section>
      </section>

      <!-- Update Modal -->
      <?php
        echo "<section id='main-content' > ";
        echo "<section id='container' >";
        echo "<div class='col-lg-offset-2 col-lg-9 col-lg-offset-1 col-xs-12'>";
        echo "<section class='card' style='size: 100px;'>";
        if (isset($_GET['update'])) {
          $update = $_GET['update'];
          $query = $userObj->selectById($partRecrd,$update);
          while ($row1 = $modelObj->fetchArray($query)) {
            echo "<div class='panel-body'>";
            echo "<form class='form align' method='post'>";
            echo "<header class='panel-heading'>Update Users</header>";
            echo"<input class='input' type='hidden' name='id' value='{$row1['id']}' />";
            echo "<br />";
            echo "<label>" . "Name:" . "</label>" . "<br />";
            echo"<input class='input form-control' type='text' name='name' value='{$row1['name']}' />";
            echo "<br />";
            echo "<label>" . "Email:" . "</label>" . "<br />";
            echo"<input class='input form-control' type='text' name='email' value='{$row1['email']}' />";
            echo "<br />";
            echo "<label>" . "Mobile:" . "</label>" . "<br />";
            echo"<input class='input form-control' type='text' name='mobile' value='{$row1['mobile']}' />";
            echo "<br />";
              
            echo "<input class='submit' type='submit' name='submit' value='update' />";
            echo "</form>";
            echo "</div>";
          }
        }
        if (isset($_POST['submit'])) {
          echo '<div class="form" id="form3"><br><br><br><br><br><br>
          <Span>Data Updated Successfuly......!!</span></div>';
        }
        echo "</div>";
        echo "</section>";
        echo "</section>";
        echo "</section>";
      ?>
      <!-- ADD USER Modal -->
      <div class="modal fade" id="reg" tabindex="-1" role="dialog" >
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ADD USER</h4>
          </div>
          <div class="modal-body">
              <form class="form" method="post" id="form" action="#">
                <label>Username</label>
                <input type="text" name="userName" id="userName" class="form-control" value="">
             

                <label>Email Id</label>
                <input type="text" name="emailId" id="emailId" class="form-control" value="" >  
            
                <label>Mobile Number</label>
                <input type="text" name="mobileNumber" id= "mobileNumber" class="form-control" value="" >
             

                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" value=""></td>
            

                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                

                <label>Gender</label>
                <input type="radio" name="gender" id = "gen" value="Male">Male
                <input type="radio" name="gender" id = "gen" value="Female">Female<br>
               

                <label>DEPARTMENT</label>
                <select name="dept[]" id = "dept" class="form-control" >
                  <option > --select-- </option>
                  <?= $select ?>
                </select>

                <label>Role</label>
                <input type="text" name="role" id="role" class="form-control">
   
                <div class="modal-footer">
                  <input type="button" name="register" id="register" value="Register">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </form>
            </div>
          </div>  
        </div>
        
      
      <!-- page end-->

      <!-- Include JS File Here -->
            <script src="assets/js/bootstrap.min.js"></script>

      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script type="text/javascript" src="assets/js/adduser.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script src="assets/js/toggle.js" type="text/javascript"></script>
      <script src="assets/js/jquery.js"></script>

      <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
      <script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript">
          function myfun(){
          $('#myTable').DataTable(
            {
            searching: false,
            lengthChange: false,
            pageLength: 5
            });
          }
    </script>
   
  </body>
</html>