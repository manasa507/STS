
<?php
// @Author: Ramarao
include_once('includes/dbconnect.php');
// @desc dept class to display categery options depends on selected department optin
class Dept
{
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

     public function getCat()
    {
        $dbConnectObject= new DatabaseConnection();
        $dbConnectObject->conn;

        $sql = "SELECT id, deptId, name FROM categories";
        $result = mysqli_query($dbConnectObject->conn, $sql);
        $selects = "";
        if (mysqli_num_rows($result) > 0) 
        {
            
            while($row = mysqli_fetch_assoc($result)) {
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
