<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tickets Database</title>
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
    <link href="assets/css/style-responsive.css" rel="stylesheet"/>
  </head>
  <body onload= "myfun()">
    <?php
      require_once 'includes/connection.php';
      require_once 'models/ticket.php';
      require_once 'models/dept.php';
      require_once 'models/categories.php';
      require_once 'models/modelwrapper.php';
   
      $pager = "tickets.php";
      $ticketObj = new Ticket();
      $deptObj = new Dept();
      $categoryObj = new Categories();
      $modelObj = new ModelWrapper();

      $allUsers = $ticketObj->selectAll();
      if (isset($_GET['del'])){
        $id = $_GET['del'];
        $records = $ticketObj->delete($id);
      }
      //for update tickets status
      if(isset($_POST['Submit']))
      {
        $id =$_POST['Submit'];
        $status = $ticketObj->selectById("isActive",$id);
        while($row = $modelObj->fetchArray($status))
        {
          $status = $row['isActive'];
          if($status == 0){
              $changeStatus = 1;
            }
            else{
               $changeStatus = 0;
            }
          $updateData = array("isActive"=>$changeStatus);
          $update = $ticketObj->update($updateData,$id,$pager);
        }
      }
      // for update tickets issues
      if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $subject = $_POST['subject'];
        $description = $_POST['description'];
        $updateTicket = array("subject"=>$subject,
                              "description"=>$description);
        $updateDept = $ticketObj->update($updateTicket,$id,$pager);
      }
      // fetch all department records
        $deptFields='id,name';
        $fetchDept = $deptObj->selectAll(); 
        $rowsObj = $modelObj->numRows($fetchDept);
        $select = $modelObj->fetchAssoc($fetchDept,$rowsObj);
        // fetch all category records
        $categoryFields='id,name';
        $fetchCategory = $categoryObj->selectAll(); 
        $rowsObj = $modelObj->numRows($fetchCategory);
        $selectCategory = $modelObj->fetchAssoc($fetchCategory,$rowsObj);
    ?>
    <!--Department Table-->
    <section id="container" >
      <header class="header dark-bg"> 
        <a href="admin.php" class="pull-left logo"><i class="icon_house_alt"></i>STS <span class="lite">Admin</span></a>
      </header>
      <div class="col-lg-offset-2 col-lg-9 col-lg-offset-1 col-md-12 col-xs-12">
        <section class="card">
          <header class="panel-heading">Tickets 
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#reg" href="#">ADD
            <i class="icon_plus_alt2"></i></button>
          </header>
          <form action="<?php $_PHP_SELF?>" method="POST">
            <table class="table table-striped table-advance table-hover" id="myTable">
              <thead>
                <tr>
                  <th> S.NO</th>
                  <th><i class="icon_profile"></i> Subject</th>
                  <th><i class="icon_profile"></i> Description</th>
                  <th><i class="icon_profile"></i> Status</th>
                  <th><i class="icon_calendar"></i> Created At</th>
                  <th><i class="icon_cogs"></i> ChangeStatus</th>
                  <th><i class="icon_cogs"></i> Delete</th>
                  <th><i class="icon_cogs"></i> Update</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i=1;
                  $noOfRows = $modelObj->numRows($allUsers);
                  if( $noOfRows > 0)
                  {
                    while ($row = $modelObj->fetchArray($allUsers))
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
                        <td>".$row['subject']."</td>
                         <td>".$row['description']."</td>
                         <td>".$row['isActive']."</td>
                        <td>". date('F d, Y', strtotime($row['createdAt'])) . "</td>
                        <div class='btn-group'>
                            <td><button name='Submit' class='btn btn-default' value='$id'>$changeStatus</button>
                            </td>
                        </div>
                        <div class='btn-group'>
                            <td><a class='btn btn-danger' href='tickets.php?del={$row['id']}'><i class='icon_trash'></i>DELETE</a>
                            </td>
                        </div>
                        <div class='btn-group'>
                            <td><b><button><a href='tickets.php?update={$row['id']}'>UPDATE</a></button></b>
                            </td>
                        </div>
                      </tr>";
                    }
                  }
                ?>  
              </tbody>
            </table>
          </form>
        </section>
      </div>
    </section>
    <!-- Add Tickets Modal -->
    <div class="modal fade" id="reg" tabindex="-1" role="dialog" >
      <div class="modal-dialog">
      <!-- Modal content-->
        <div class="modal-content">
          <form class="form" method="post" id="form" action="#">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">ADD Tickets</h4>
            </div>
            <div class="modal-body">
               <label>DEPARTMENT</label>
                <select name="dept[]" id = "dept" class="form-control" >
                  <option > --select-- </option>
                  <?= $select ?>
                </select><br>
                <label>CATEGORY</label>
                <select name="category[]" id = "category" class="form-control" >
                  <option > --select-- </option>
                  <?= $selectCategory ?>
                </select><br>
              <label>Subject</label>
              <input type="text" class = "form-control" name="subject" id="subject" value=""><br>
              <label>Description</label>
              <input type="text" class = "form-control" name="description" id="description" value=""><br>
            </div>
            <div class="modal-footer">
              <input type="button" name="register" id="add" value="ADD">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>  
    </div>

    <!-- Update Modal -->
    <?php
      echo "<section id='container' >";
      echo "<div class='col-lg-offset-2 col-lg-9 col-lg-offset-1 col-xs-12'>";
      echo "<section class='card' style='size: 100px;'>";
      if (isset($_GET['update'])) {
        $update = $_GET['update'];
        $query = $ticketObj->selectById("*",$update);
        while ($row = $modelObj->fetchArray($query)) {
          echo "<div class='panel-body'>";
          echo "<form class='form align' method='post'>";
          echo "<header class='panel-heading'>Update Categories</header>";
          echo"<input class='input' type='hidden' name='id' value='{$row['id']}' />";
          echo "<br />";
          echo "<label>" . "Subject:" . "</label>" . "<br />";
          echo"<input class='input form-control' type='text' name='subject' value='{$row['subject']}' />";
          echo "<br />";
          echo "<label>" . "Description:" . "</label>" . "<br />";
          echo"<input class='input form-control' type='text' name='description' value='{$row['description']}' />";
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
    ?>
    <!-- page end-->
    
    <script >
      function myfun(){
        $('#myTable').DataTable(
        {
          searching: false,
          lengthChange: false,
          pageLength: 5,
        });
      }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/addticket.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- nicescroll -->
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
    <script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
  </body>
</html>
