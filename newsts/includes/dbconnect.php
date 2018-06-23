<?php

// DatabaseConnection class calls the connection to a database by construct keyword
//@param $message
//@param $conn
class DatabaseConnection 
{

public $message;
public $conn;


//@desc function connects to database using construct
//@param $serverName
//@param $userName
//@param $password
//@param $dbName
public function __construct() 
	{
	// Create connection
	$this->conn = mysqli_connect('localhost', 'root', '123', 'sts');

		if (!$this->conn) 
			{
		    	die("Connection failed: " . mysqli_connect_error());
			}
			else
			{
				$this->message =  "Connected successfully ";
			}
	}	
}

?>