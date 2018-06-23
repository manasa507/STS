<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories Database</title>
    <link rel="shortcut icon" href="assets/img/credencys.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!--external css-->
    <!-- font icon -->
    <link href="assets/css/elegant-icons-style.css" rel="stylesheet"/>
    <!-- Custom styles -->
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/admineff.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet"/>
  </head>
  <body onload= "myfun()">
    <?php
      require_once 'includes/connection.php';
      require 'models/categories.php';
      require 'models/dept.php';
      require_once 'models/modelwrapper.php';
      $pager = 'categories.php';
      $categoryObj = new Categories();
      $deptObj = new Dept();
      $modelObj = new ModelWrapper();
      $allCategory = $categoryObj->selectAll();
      if (isset($_GET['del'])) {
        $delId = $_GET['del'];
        $records = $categoryObj->delete($delId);
      }
      if (isset($_POST['submit'])) {
        $id = $_POST['cid'];
        $name = $_POST['cname'];
        $categoryData = array("name"=>$name);
        $updateDept = $categoryObj->update($categoryData,$id);
      }
      // fetch all department records
        $deptObj = $deptObj->selectAll(); 
        $rowsObj = $modelObj->numRows($deptObj);
        $select = $modelObj->fetchAssoc($deptObj,$rowsObj);
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

    <!--Department Table-->
    <section id="main-content">
      <section id="container" >
        <!-- Body section -->
        <div class=" col-lg-12  col-xs-12">
          <section class="card" style="size: 100px;">
            <header class="panel-heading">Categories 
              <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#reg" href="#">ADD
              <i class="icon_plus_alt2"></i></button>
            </header>
            <div style="overflow-x:auto;">
              <table class="table table-striped table-advance table-hover" id="myTable">
                <thead>
                  <tr>
                    <th> S.NO</th>
                     <th><i class="icon_cogs"></i> DeptID</th>
                    <th><i class="icon_profile"></i> Name</th>
                    <th><i class="icon_calendar"></i> Created At</th>
                    <th><i class="icon_cogs"></i> Actions</th>
                    <th><i class="icon_cogs"></i> Update</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i=1;
                    $callFun = $modelObj->numRows($allCategory);
                    if($callFun > 0)
                    {
                      while ($row = $modelObj->fetchArray($allCategory))
                      {
                        echo "<tr>
                          <td>".$i++."</td>
                          <td>".$row['deptId']."</td>
                           <td>".$row['name']."</td>
                          <td>". date('F d, Y', strtotime($row['createdAt'])) . "</td>
                          <div class='btn-group'>
                            <td>
                              <a class='btn btn-danger' href='categories.php?del={$row['id']}'><i class='icon_trash'></i>DELETE</a>
                            </td>
                          </div>
                          <div class='btn-group'>
                            <td>
                              <b><button>
                                <a href='categories.php?update={$row['id']}'>UPDATE</a>
                              </button></b>
                            </td>
                          </div>
                        </tr>";
                      }
                    }
                  ?>
                </tbody>
              </table>
          </div>
          </section>
        </div>
        <!-- End Body section -->
      </section>
    </section>
    
    <!-- Add Category Modal -->
    <div class="modal fade" id="reg" tabindex="-1" role="dialog" >
      <div class="modal-dialog">
        <!-- Modal content-->
        <form name="form"  id="form" method="POST"  action="#">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">ADD Categories</h4>
            </div>
            <div class="modal-body">
              <label>DEPARTMENT</label>
                <select name="dept[]" id = "dept" class="form-control" >
                  <option > --select-- </option>
                  <?= $select ?>
                </select><br>
              <label>CategoryName</label>
              <input type="text" class = "form-control" name="name" id="name"><br>
            </div>
            <div class="modal-footer">
              <input type="button" name="register" id="add" value="ADD">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
        <!-- End Modal content-->
      </div>  
    </div>

    <!-- UPDATE FORM-->
    <?php
      echo "<section id='main-content' > ";
      echo "<section id='container' >";
      echo "<div class=' col-lg-10 col-lg-offset-2 col-xs-12'>";
      echo "<section class='card' style='size: 100px;'>";
    
      if (isset($_GET['update'])) {
        $update = $_GET['update'];
        $query = $categoryObj->selectById($update);
        while ($row = $modelObj->fetchArray($query)) {
          echo "<div class='panel-body'>";
          echo "<form class='form align' method='post'>";
          echo "<header class='panel-heading'>Update Categories</header>";
          echo"<input class='input' type='hidden' name='cid' value='{$row['id']}' />";
          echo "<br />";
          echo "<label>" . "Name:" . "</label>" . "<br />";
          echo"<input class='input form-control' type='text' name='cname' value='{$row['name']}' />";
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

    <!-- page end-->
    <!-- Pagination -->
    <script>
      function myfun(){
        $('#myTable').DataTable(
        {
          searching: false,
          lengthChange: false,
          pageLength: 5,
        });
      }
    </script>
    <!-- Include Js Files Here..  -->
        <script src="assets/js/bootstrap.min.js"></script>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script type="text/javascript" src="assets/js/addCategory.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="assets/js/jquery.js"></script>
    <!-- nicescroll -->
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/toggle.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    <script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
  </body>
</html>
