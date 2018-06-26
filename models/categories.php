<?php
	
	/**
   	@ desc Select class for all CRUD functionalities performs here.. 
    @ PHP version: 7.1.15
    @ date: 11-06-2018
    @ author: Saimanasa
    **/
	require_once 'includes/dbconnect.php';
	require_once 'models/modelwrapper.php';
	class Categories 
	{	
		/**
		@author: Saimanasa
		@ desc selectAll function for fetch all no.of records in a particular table.
		@ return STRING $allRecords
		**/
		public function selectAll(){
			$tableName = 'categories';
			$columnName = 'id,deptId,name,createdAt';
			$wrapperObj = new ModelWrapper();
        	$allRecords = $wrapperObj->selectAll($tableName,$columnName);
        	return $allRecords;
			
		}
		/**
		@author: Saimanasa
		@ desc selectById function for fetch all no.of records in a table.
		@ param  STRING $id 
		@ return STRING $response
		**/
		public function selectById($id){
			$tableName ='categories';
			$columnName = '*';
			$partRecrd = 'id';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->selectById($tableName,$columnName,$partRecrd,$id);
        	return $response;
		}
		/**
		@ author: Sridevi
		@ desc delete function for delete record by Id.
		@ param INT $id 
		@ return STRING $response
		**/	
		public function delete($id){
			$table = 'categories';
			$pager = 'categories.php';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->delete($table,$id,$pager);
        	return $response;
		}
		/**
		@author: Saimanasa
		@ desc update function for update user formData.
		@ param  ARRAY $formData 
		@ param  STRING $id  
		@ return STRING $response
		**/
		function update($formData,$id,$pager)
		{
			$tableName = 'categories';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->update($tableName,$pager,$formData,"WHERE id = '$id'");
        	// run and return the query result
		    return $query;
		}
		/**
		@author: Saimanasa
		@ desc insert function for insert user formData.
		@ param  ARRAY $formData 
		@ return STRING $response
		**/
		function insert($formData)
		{
			$tableName = 'categories';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->insert($tableName, $formData);
        	return $query;
        }
     

	    /**
  		@author: ramarao
        @ desc fetchAssoc function for Fetch a result row as an associative array
        @ param STRING  $catObj 
        @ param STRING  $rowsObj 
        @ return STRING $selects
        **/
		public function fetchAssoc($catObj,$rowsObj)
        {
            $dbConnectObject= new DatabaseConnection();
            $dbConnectObject->conn;
			$selects ="";
            if ($rowsObj > 0) 
            {
                while($row = mysqli_fetch_assoc($catObj)) {
                     $selects.='<option value="'.$row['id'].'" data-val="'.$row['deptId'].'" >'.$row['name'].'</option>';
                }
            } 
            else 
            {
                echo  mysqli_error($dbConnectObject->conn);;
            }
            return $selects;
        }
	}
?>