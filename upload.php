<?php
	require_once 'includes/dbconnect.php';
 
    class User{
    
		public function selectById($id){

			$tableName = 'user';
			$columnName = '*';
			$partRecrd = 'email';
			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;
			
			$query = "SELECT $columnName FROM $tableName where $partRecrd =  '$id'";
			$sql = mysqli_query($dbConnectObject->conn,$query);
			return $sql;

		}
		/**
		@ desc numRows function for returns the number of rows in a result.
		@ param STRING  $query 
		@ return STRING $response
		**/	
		public function numRows($query){
			$response = mysqli_num_rows($query);
			return $response;
		}

		/**
		@ desc fetchArray function for fetchs a result row as an associative array.
		@ param STRING  $query 
		@ return STRING $response
		**/
		public function fetchArray($query){
			$response =mysqli_fetch_array($query);
			return $response;
		}
		public function update($field,$value,$email){
			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;
			$query = "UPDATE user SET $field = '$value' WHERE email= '$email'";
			$sql = mysqli_query($dbConnectObject->conn,$query);
			 return $sql;
		}
	}
?>