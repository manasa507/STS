<?php
	
	/**
   	@ desc Ticket class for all CRUD functionalities performs here.. 
    @ PHP version: 7.1.15
    @ date: 11-06-2018
    **/
    session_start();
	require_once 'includes/connection.php';
	require_once 'includes/dbconnect.php';
	require_once 'models/modelwrapper.php';
	class Ticket 
	{
		/**
		@ desc selectAll function for fetch all no.of records in a particular table. 
		@ return STRING $allFields
		**/
		public function selectAll(){
			$tableName = 'ticket';
			$columnName = '*';
			$wrapperObj = new ModelWrapper();
        	$allRecords = $wrapperObj->selectAll($tableName,$columnName);
        	return $allRecords;
		}
		/**
		@ desc selectById function for fetch all no.of records in a table.
		@ param  STRING $columnName
		@ param  int $id
		@ return STRING $response
		**/
		public function selectById($columnName,$id){
			$tableName = 'ticket';
			$partRecrd = 'id';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->selectById($tableName,$columnName,$partRecrd,$id);
        	return $response;
		}
		/**
		@ author: Sridevi
		@ desc deleteRec function for delete record by Id.
		@ param INT $id 
		@ return STRING $response
		**/	
		public function delete($id){
			$table = 'ticket';
			$pager = 'tickets.php';
			$wrapperObj = new ModelWrapper();
        	$response = $wrapperObj->delete($table,$id,$pager);
        	return $response;
		}
		/**
		@ desc update function for update user formData.
		@ param  STRING $formData 
		@ param  STRING $id  
		@ return STRING $response
		**/
		function update($formData,$id,$pager)
		{
			$tableName = 'ticket';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->update($tableName,$pager,$formData,"WHERE id = '$id'");
		    return $query;
		}
		/**
		@ desc insert function for insert user formData.
		@ param  STRING $formData 
		@ return STRING $response
		**/
		function insert($formData)
		{
			$tableName = 'ticket';
			$wrapperObj = new ModelWrapper();
        	$query = $wrapperObj->insert($tableName, $formData);
        	return $query;
        }

		// @desc Fetch tickets from ticket table

		public function getTicket()
		    {
		        $dbConnectObject= new DatabaseConnection();
		        $dbConnectObject->conn;

		        $sql = "SELECT ticket.id as catid, user.name as name ,ticket.createdBy as createdBy ,ticket.isActive as isActive, description, ticket.createdAt as createdAt  FROM ticket inner join user on ticket.createdBy = user.id ORDER BY createdAt desc";
		        $result = mysqli_query($dbConnectObject->conn, $sql);

		        $tableData = "";
		        
		        if (mysqli_num_rows($result) > 0) 
		        {
		            $i = 1;
		            $status = $disable = "";
		            while($row = mysqli_fetch_array($result))
		            {

		                if($row["isActive"] == 0){$status = "close"; $btn = "btn btn-danger";}
		                else{$status = "open";$btn = "btn btn-success";}
		                if($row["createdBy"] != $_SESSION["id"] || $row["isActive"] == 0 ){$disable = "disabled"; }
		                else{$disable = ""; }

		                $catid = $row["catid"];
		                $user = $row["name"];
		                $tableData .= '<tr>
		                        <td>'.$i++.'</td>
		                        <td>'. date('F d, Y', strtotime($row['createdAt'])) . '</td>
		                        <td>'.$user.'</td>
		                        
		                        <td>'.$row['description'].'</td>
		                        <td>
		                            <button class = "'.$btn.'" name = "name" value = '.$catid.' '.$disable.' >'.$status.'</button>
		                        </td>
		                                                  
		                    </tr> ';
		            }
		        } 
		        else 
		        {
		            echo  mysqli_error($dbConnectObject->conn);;
		        }
		        return $tableData;
		    }
	  	}

        /*
        @desc add tickets to ticket table
		@param STRING $title
 		@param STRING $deptSelectedOption
		@param STRING $catSelectedOption
  		@param STRING $description
		@param INT $id
 		@param INT $id1
 		@return STRING $ticketStatus
		*/
		public function addTicket($title, $deptSelectedOption, $catSelectedOption, $description, $id, $id1)
		{
			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;

			$sql = "INSERT INTO ticket (subject, deptId, categoryId, description, createdBy, updatedBy ) VALUES ('$title', '$deptSelectedOption', '$catSelectedOption', '$description', '$id', '$id1')";

			if (mysqli_query($dbConnectObject->conn, $sql)) 
			{
			    $ticketStatus = true;
			}
			else
			{
				$ticketStatus =  mysqli_error($dbConnectObject->conn);
			}
			return $ticketStatus;

		}

		/*
		@desc Fetch tickets from ticket table
		@return STRING $tableData
		*/

		public function getTicket()
    	{
	        $dbConnectObject= new DatabaseConnection();
	        $dbConnectObject->conn;

	        $sql = "SELECT ticket.id as catid, user.name as name ,ticket.createdBy as createdBy ,ticket.isActive as isActive, description, ticket.createdAt as createdAt  FROM ticket inner join user on ticket.createdBy = user.id ORDER BY createdAt desc";
	        $result = mysqli_query($dbConnectObject->conn, $sql);

	        $tableData = "";
	        
	        if (mysqli_num_rows($result) > 0) 
	        {
	            $i = 1;
	            $status = $disable = "";
	            while($row = mysqli_fetch_array($result))
	            {

	                if($row["isActive"] == 0){$status = "close"; $btn = "btn btn-danger";}
	                else{$status = "open";$btn = "btn btn-success";}
	                if($row["createdBy"] != $_SESSION["id"] || $row["isActive"] == 0 ){$disable = "disabled"; }
	                else{$disable = ""; }

	                $catid = $row["catid"];
	                $user = $row["name"];
	                $tableData .= '<tr>
	                        <td>'.$i++.'</td>
	                        <td>'. date('F d, Y', strtotime($row['createdAt'])) . '</td>
	                        <td>'.$user.'</td>
	                        
	                        <td>'.$row['description'].'</td>
	                        <td>
	                            <button class = "'.$btn.'" name = "name" value = '.$catid.' '.$disable.' >'.$status.'</button>
	                        </td>
	                                                  
	                    </tr> ';
	            }
	        } 
	        else 
	        {
	            echo  mysqli_error($dbConnectObject->conn);;
	        }
	        return $tableData;
    	}

    	/*
    	@desc update ticket status of particular ticket
		@param STRING $ticket
		@return STRING $status

		*/
		public function updateTicket($ticket)
    	{
	        $dbConnectObject= new DatabaseConnection();
	        $dbConnectObject->conn;

	        $sql = "UPDATE ticket SET isActive='0' WHERE id = $ticket";
	        
	        if (mysqli_query($dbConnectObject->conn, $sql)) 
	        {
	            $status = true;
	        } 
	        else 
	        {
	            $status = false;
	       	}
	         return $status;

	    }
    }
>>>>>>> bcd17b0faa0785e7b8e710d0a91224c025891ff6
?>