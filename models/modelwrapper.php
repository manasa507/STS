<?php
	
	/**
   	@ desc Ticket class for all CRUD functionalities performs here.. 
    @ PHP version: 7.1.15
    @ date: 11-06-2018
    @ author: Saimanasa
    **/
    require_once 'includes/connection.php';
	class ModelWrapper
	{
		/**
		@ desc selectAll function for fetch all no.of records in a particular table.
		@ param STRING  $tableName 
		@ param  STRING $columnName  
		@ return STRING $sql
		**/
		public function selectAll($tableName,$columnName){

			$dbConnectObject = new DatabaseConnection('localhost','root','Credencys','sts');
			$dbConnectObject->conn;
			$sql = mysqli_query($dbConnectObject->conn, "SELECT $columnName FROM $tableName");
			return $sql;
		}
		/**
		@ desc selectById function for fetch all no.of records in a table.
		@ param STRING  $tableName 
		@ param  STRING $columnName
		@ param  STRING $partRecrd is a field name
		@ return STRING $sql
		**/
		public function selectById($tableName,$columnName,$partRecrd,$id){

			$dbConnectObject = new DatabaseConnection('localhost','root','Credencys','sts');
			$dbConnectObject->conn;
		
			$sql = mysqli_query($dbConnectObject->conn, "SELECT $columnName FROM $tableName where $partRecrd = '$id'");
			return $sql;
		}

		/**
		@ author: Sridevi
		@ desc deleteRec function for delete record by Id.
		@ param STRING  $table 
		@ param INT $id 
		@ param STRING  $pager 
		@ return STRING $deleteQuery
		**/	
		public function delete($table,$id,$pager){
			$dbConnectObject= new DatabaseConnection('localhost','root','Credencys','sts');
			$dbConnectObject->conn;
     		//SQL query for deletion.
			$deleteQuery = mysqli_query($dbConnectObject->conn,"DELETE from $table where id=$id");
			if($deleteQuery === TRUE){
			    header("location:$pager");
			}
			return $deleteQuery;
  		}
  		/**
		@ desc update function for update user Information.
		@ param STRING  $tableName 
		@ param  STRING $pager 
		@ param  STRING $formData 
		@ param  STRING $whereClauseClause 
		@ return STRING $query
		**/
		function update($tableName, $pager ,$formData, $whereClause='$id')
		{

			$dbConnectObject= new DatabaseConnection('localhost','root','Credencys','sts');
			$dbConnectObject->conn;
		    // check for optional where clause
		    $whereSQL = '';
		    if(!empty($whereClause))
		    {
		        // check to see if the 'where' keyword exists
		        if(substr(strtoupper(trim($whereClause)), 0, 5) != 'WHERE')
		        {
		            // not found, add key word
		            $whereSQL = " WHERE ".$whereClause;
		        } else
		        {
		            $whereSQL = " ".trim($whereClause);
		        }
		    }
		    // start the actual SQL statement
		    $sql = "UPDATE ".$tableName." SET ";
		    // loop and build the column /
		    $sets = array();
		    foreach($formData as $column => $value)
		    {
		         $sets[] = "`".$column."` = '".$value."'";
		    }
		    $sql .= implode(', ', $sets);
		    // append the where statement
		    $sql .= $whereSQL;
		    $query = mysqli_query($dbConnectObject->conn,$sql);
		    if($query === TRUE){
			    header("location:$pager");
			}
			// run and return the query result
		    return $query;
		}
		/**
		@ desc insert function for insert users into users table. 
		@ param STRING  $tableName 
		@ param  STRING $formData  
		@ return STRING $query
		**/
		function insert($tableName, $formData)
		{
			$dbConnectObject= new DatabaseConnection('localhost','root','Credencys','sts');
			$dbConnectObject->conn;
		    // retrieve the keys of the array (column titles)
		    $fields = array_keys($formData);
		    // build the query
		    $sql = "INSERT INTO ".$tableName."
		    (`".implode('`,`', $fields)."`)
		    VALUES('".implode("','", $formData)."')";
		    // run and return the query result resource
		    $query = mysqli_query($dbConnectObject->conn,$sql);
		    return $query;
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
		
  		/**
        @ desc fetchAssoc function for Fetch a result row as an associative array
        @ param STRING  $deptObj 
        @ param STRING  $rowsObj 
        @ return STRING $select
        **/
        public function fetchAssoc($deptObj,$rowsObj)
        {
            $dbConnectObject= new DatabaseConnection('localhost','root','Credencys','sts');
            $dbConnectObject->conn;
			$select ="";
            if ($rowsObj > 0) 
            {
                while($row = mysqli_fetch_assoc($deptObj)) {
                    $select.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
                }
            } 
            else 
            {
                echo  mysqli_error($dbConnectObject->conn);;
            }
            return $select;
        }
  	}
?>