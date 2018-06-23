<?php
   require 'models/ticket.php';
   
   // Fetching Values from URL.
   $subject=$_POST['subject1']; 
   $description=$_POST['description1'];
   $dept=$_POST['dept1'];
   $category=$_POST['category1']; 
   $ticketObj = new Ticket();
   $categoryData = array("subject"=>$subject,
                           "deptId"=>$dept,
                           "categoryId"=>$category,
                           "description"=>$description);
   $query = $ticketObj->insert($categoryData);
   if($query){
      echo "You have Successfully Add Tickets.....";
   }else
   {
      echo "Error....!!";
   }
      
      
?>
