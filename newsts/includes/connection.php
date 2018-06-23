<?php

class Connection 
{
	public $conn;
	/*
		@desc establishing a connection to the database
		@param string $serverName 
		@param string $userName 
		@param string $password 
		@param string $dbName 
		*/
	public function __construct($serverName, $userName, $password, $dbName) 
	{
		$this->conn = mysqli_connect($serverName, $userName, $password, $dbName);
		if (!$this->conn) 
		{
		    die("Connection failed: " . mysqli_connect_error());
		}
	}	
}

?>