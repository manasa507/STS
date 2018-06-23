
<?php

include_once('includes/dbconnect.php');
//@desc dept class is used to diplay categery option in registe and addticket form
class Dept
{
//@desc selects multiple data from database
 
public function getDept()
    {
        $dbConnectObject= new DatabaseConnection();
        $dbConnectObject->conn;

        $sql = "SELECT id, name FROM dept";
        $result = mysqli_query($dbConnectObject->conn, $sql);
        $select = "";
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) {
                $select.='<option value="'.$row['id'].'">'.$row['name'].'</option>';
                $x = $row['id'];
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
