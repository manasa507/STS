<?php
	require 'models/categories.php';
 	// Fetching Values from URL.
 	$dept=$_POST['dept1']; 
	$name=$_POST['name1']; 
	$categoryObj = new Categories();
	$categoryData = array("deptId"=>$dept,
							"name"=>$name);
	$query = $categoryObj->insert($categoryData);
	if($query){
		echo "You have Successfully Add Category.....";
	}else
	{
		echo "Error....!!";
	}
?>
