<?php
	require_once 'models/dept.php';
	require_once 'models/modelwrapper.php';
 	// Fetching Values from URL.
	$name=$_POST['name1'];
	$deptObj = neW Dept();
	$modelObj = new ModelWrapper();
	$part = 'name';
	$deptValue = $deptObj->selectById("dept","*",$part,$name); 
	$result =  $modelObj->numRows($deptValue);
	if($result == 0)
	{
	$deptData = array("name"=>$name);
	$query = $deptObj->insert($deptData);
	if($query){
		echo "You have Successfully Add Departments.....";
	}else
	{
		echo "Error....!!";
	}
	}else{
		echo "$name Already Exist";
	}

?>
