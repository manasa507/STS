<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="shortcut icon" href="assets/img/credencys.png">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="assets/css/bootstrap-theme.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/admineff.css" rel="stylesheet">
  
    <!-- font icon -->
    <link href="assets/css/elegant-icons-style.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.css" rel="stylesheet" />
    <link href="assets/css/widgets.css" rel="stylesheet" />

  </head>
   
  <body>

    <?php
      /*
       @ desc admin.php file have a dashbord and fetch all records in a table no.of users  and no.of open and close tickets.... 
       @ PHP version: 7.1.15
       @ date: 11-06-2018
       @ author: Saimanasa
      */
      
      require_once "models/user.php";
      require_once "models/ticket.php";
      require_once 'models/modelwrapper.php';
      // Here Parameters Declaration for fetch all table records ... 
      $partRecrd = 'isActive';
      $statusClose = '0';
      $statusOpen = '1';
      $roleRecrd = 'role';
      $roleValue = 'user';

      $fetchAllUser = new User();
      $fetchAllTicket = new Ticket();
      $modelObj = new ModelWrapper();
      // fetch all no.of tickets 
      $allRecords = $fetchAllTicket->selectAll();
      $allTickets = $modelObj->numRows($allRecords);
      // fetch all no.of users
      $all = $fetchAllUser->selectById($roleRecrd,$roleValue);
      $allUsers = $modelObj->numRows($all);
      // fetch all no.of opentickets 
      $open= $fetchAllTicket->selectById($partRecrd,$statusOpen);
      $openTickets  = $modelObj->numRows($open);
      // fetch all no.of closetickets 
      $close = $fetchAllTicket->selectById($partRecrd,$statusClose);
      $closeTickets  = $modelObj->numRows($close);
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

      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <!--overview start-->
          <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <h4 class="page-header"><i class="icon_laptop"></i>Dashboard</h4>
            </div>
          </div>
          <!-- start widgets -->
          <!-- start info-box -->

          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-pink hover-expand-effect">
                <div class="icon">
                  <i class="icon_box-checked"></i>
                </div>
                <div class="content">
                  <div class="text">ALL Tickets</div>
                  <div class="count"><?php echo $allTickets; ?></div>
                  <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-cyan hover-expand-effect">
                <div class="icon">
                  <i class="icon_folder-open"></i>
                </div>
                <div class="content">
                  <div class="text">OPEN TICKETS</div>
                  <div class="count"><?php echo $openTickets; ?></div>
                  <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                </div>
              </div>
            </div>
              
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-light-green hover-expand-effect">
                <div class="icon">
                  <i class=" icon_close_alt"></i>
                </div>
                <div class="content">
                  <div class="text">CLOSED TICKETS</div>
                  <div class="count"><?php echo $closeTickets; ?></div>
                  <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                </div>
              </div>
            </div>
              
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="info-box bg-orange hover-expand-effect">
                <div class="icon">
                  <i class="  icon_group"></i>
                </div>
                <div class="content">
                  <div class="text">ALL USERS</div>
                  <div class="count"><?php echo $allUsers; ?></div>
                  <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                </div>
              </div>
            </div>
          </div>
            <!-- #END# Widgets -->
            <!--/.info-box-->
        </section>
      </section>
    </section>
    <!-- container section end -->
  
    <!-- Include Js files here -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- toggle hide/show -->
    <script src="assets/js/toggle.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="assets/js/scripts.js"></script> 
  </body>
</html>
