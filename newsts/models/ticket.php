<?php
// @Author: Ramarao
session_start();
require_once 'includes/dbconnect.php';


class Ticket 
{
// @desc add tickets to ticket table
// @param $title,
// @param $deptSelectedOption,
// @param $catSelectedOption,
// @param $description,
// @param $id,
// @param $id1
public function addTicket($title, $deptSelectedOption, $catSelectedOption, $description, $id, $id1)
	{
			$dbConnectObject= new DatabaseConnection();
			$dbConnectObject->conn;

		$sql = "INSERT INTO ticket (subject, deptId, categoryId, description, createdBy, updatedBy ) VALUES ('$title', '$deptSelectedOption', '$catSelectedOption', '$description', '$id', '$id1')";

		if (mysqli_query($dbConnectObject->conn, $sql)) {
		    $ticketStatus = true;
		} else {
			$ticketStatus =  mysqli_error($dbConnectObject->conn);
		}
		return $ticketStatus;

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
// @desc update ticket status of particular ticket
// @param $ticket
public function updateTicket($ticket)
    {
        $dbConnectObject= new DatabaseConnection();
        $dbConnectObject->conn;

        $sql = "UPDATE ticket SET isActive='0' WHERE id = $ticket";
        
        if (mysqli_query($dbConnectObject->conn, $sql)) {
            $status = true;
        } else {
            $status = false;
            }
            return $status;

    }
	
}

?>