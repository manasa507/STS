<?php
	
	/**
   	@ desc Select class for all CRUD functionalities performs here.. 
    @ PHP version: 7.1.15
    @ date: 11-06-2018
    **/
	require_once 'includes/dbconnect.php';
	require_once 'models/modelwrapper.php';
	class Dept 
	{	
		/**
		@author: Saimanasa
		@ desc selectAll function for fetch all no.of records in a particular table.
		@ return STRING $allRecords
		**/
		public function selectAll(){
			$tableName = 'dept';
			$columnName = 'id,name,createdAt';
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
			$tableName = 'dept';
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
			$tableName = 'dept';
			$pager = 'deptinfo.php';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->delete($tableName,$id,$pager);
        	return $response;
		}
		
		/**
		@author: Saimanasa
		@ desc update function for update user formData.
		@ param  STRING $formData 
		@ param  int $id  
		@ return STRING $response
		**/
		function update($formData,$id,$pager)
		{
			$tableName = 'dept';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->update($tableName,$pager,$formData,"WHERE id = '$id'");
        	// run and return the query result
		    return $query;
		}
		/**
		@author: Saimanasa
		@ desc insert function for insert user formData.
		@ param  STRING $formData 
		@ return STRING $response
		**/
		function insert($formData)
		{
			$tableName = 'dept';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->insert($tableName, $formData);
        	return $query;
        }

	}

?>