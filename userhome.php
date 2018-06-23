<?php
// echo "mmm";
// die;
require_once('models/ticket.php');
$tableData = "";
$ticketObject = new Ticket();
$tableData = $ticketObject->getTicket();
require_once('models/dept.php');
require_once('models/categories.php');
$deptObj = new Dept();
$select = $deptObj->getDept();

$catObj= new Categories();
$selects = $catObj->getCat();

$statusMsg = "";

if(isset($_POST["Submit"]))
  {
    $check = true;

    if(!isset($_POST["title"]) ||$_POST["title"] === "")
    {
      $check = false;
      $error="*";
    }
    else
    {
      $title = $_POST["title"];
    }

    if(!isset($_POST["deptSel"]) ||$_POST["deptSel"] === "")
    {
      $check = false;
      // $error="*";
    }
    else
    {
      $dept = $_POST["deptSel"];
      $deptSelectedOption=implode("",$dept);
    }

    if(!isset($_POST["catSel"]) ||$_POST["catSel"] === "")
    {
      $check = false;
      // $error="*";
    }
    else
    {
      $catSel = $_POST["catSel"];
      $catSelectedOption=implode("",$catSel);
    }

    if(!isset($_POST["message"]) ||$_POST["message"] === "")
    {
      $check = false;
      // $error="*";
    }
    else
    {
      $description = $_POST["message"];
    }

    if($check == true)
    {
      $id = $_SESSION["id"];
      $ticketObject = new Ticket();
      $addData = array("subject"=>$title,
                        "deptId"=>$deptSelectedOption,
                        "categoryId"=>$catSelectedOption, 
                        "description"=>$description, 
                        "createdBy"=>$id, 
                        "updatedBy"=>$id );
       $ticketStatus = $ticketObject->insert($addData);
      

      if($ticketStatus == true)
      {
        // $statusMsg = "Ticket Added successfully";
        header("Location:userhome.php");
      }

    }
  } 

if(isset($_POST["name"])){

  $ticket = $_POST["name"];
  $ticketData = array("isActive"=>0);
  $updateStatus = $ticketObject->update($ticketData,$ticket,"userhome.php");
  //$updateStatus = $ticketObject->updateTicket($ticket);
  if($updateStatus = true)
  {
    header("Location:userhome.php");
  }
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>home page</title>

	<link rel="icon" type="image/png" href="assets/img/icons/credencys.ico"/>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/userhome.css">
</head>
<body>
  <div class="header">
  	<nav class="navbar navbar-expand-lg bg-dark navbar-dark ">
    		<a class="navbar-brand" href="https://www.credencys.com/">Credencys</a>
    		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      		
    		</button>
    		<div class="collapse navbar-collapse " id="collapsibleNavbar">
            <ul class="nav navbar-nav mr-auto"></ul>
            <ul class="navbar-nav ">
              	<li class="nav-item">
                  <a class="nav-link" href="userhome.php">Home</a>
              	</li>
      			    <li class="nav-item">
      			    	<a class="nav-link" href="#">News</a>
      			    </li>
            		<li class="nav-item">
                  <a class="nav-link" href="#">About</a>
            		</li>
                <li class="nav-item ">
                  
                  <div class="dropdown">
                    <a class="nav-link " data-toggle="dropdown" href="#"><i class="fa fa-user-circle fa-lg" ></i></a>
                    
                    <div class="dropdown-menu dropdown-menu-right">
                      <i class="fa fa-pencil "> <a href="editprofile.php">Profile </a> </i>
                      <hr>
                      <i class="fa fa-sign-out "> <a href="userlogout.php"> Logout </a> </i>
                      
                    </div>
                  </div>

                </li>   
      		  </ul>
    		</div>  
	  </nav>
  </div>


		
    <div class="row">
      <div class="col-md-3">
          <div class="card" >
              <img class="card-img-top" src="uploads/<?=$_SESSION["image"]?>" alt="Card image" >
                <div class="card-body">
                  <h4 class="card-title"> <?= $_SESSION["name"]?>  </h4>
                  <hr>
                  <i class="fa fa-phone"> <?= $_SESSION["mobile"]?> </i>
                  <hr>
                  <i class="fa fa-briefcase"> <?= $_SESSION["deptName"] ?></i>
                </div>
          </div>

          <div class="card">
            <a type="button" class="btn btn-success addticket" href="#addticket" Data-toggle="modal" data-target="#myModal">Add Ticket</a>
            <!-- <input type="submit" class="btn btn-success addticket" name=" " value="My Tickets"> -->

            <!-- The Modal -->
            <div class="modal" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">ADD TICKET</h4>
                    <button type="button" class="close" data-dismiss="modal">&Xopf;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <form action="<?php $_PHP_SELF ?>" method="POST">
                      <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="title" id="title" placeholder="Title*" required="required">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" id="deptSel" name="deptSel[]" required="required">
                                  <option value="0"> --Select Department-- </option>
                                  <?= $select ?>
                              </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <select required="required" class="form-control" id="catSel" name="catSel[]" >
                                  <option value="" data-val = "0"> --select Category-- </option>
                                  <?= $selects ?>
                              </select>
                        </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <textarea id="message" name="message"  placeholder="Describe Issue*" required></textarea>
                          </div>
                      </div>
                      <div class="center">
                        <input class="ticketbtn" type="submit" name="Submit">
                        <p class="statusMsg"> <?= $statusMsg?> </p>
                      </div>
                    </form>
                  </div>

                 
                </div>
              </div>
            </div>

          </div>
      </div>
      
      <div class="col-md-9">
        <div class="card">
            <h3>SUPPRORT TICKETING SYSYTEM</h3>
            
        </div>
        <div  class="card">
          <div style="overflow-x:auto;">
            <form action="<?php $_PHP_SELF ?>" method="POST">
            <table class="data-table" id="myTable" >
                <thead>
                    <tr>
                        <th>SNO</th>
                        <th>CREATEDAT</th>
                        <th>USER</th>
                        <th>DESCRIPTION</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                  <?= $tableData ?>
                </tbody>
             </table>
            </form>
           </div>
        </div>

       
      </div>
  </div> <!-- row closing div -->
	<div class="footer">   
    <div class="row">
      <div class="col-md-6">
          <p>&copy; 2018 Credencys Solutions Inc.</p>
      </div>
      <div class="col-md-6 text-right">
        <a class="footerIcon" href="https://twitter.com/Credencys" title="Twitter"><i class="fa fa-twitter"></i></a>
        <a class="footerIcon" href="https://www.facebook.com/credencys/" title="Facebook"><i class="fa fa-facebook"></i></a>
        <a class="footerIcon" href="https://www.linkedin.com/company/credencys" title="linkedin"><i class="fa fa-linkedin"></i></a>
        
       
      </div>


    </div>
  </div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    
<script src="http://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/tabletest.js"></script>
</body>
</html>
