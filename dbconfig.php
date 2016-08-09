<?php
require_once 'Singleton.php';
class Database extends Singleton
{
     
    private $host = "localhost";
    private $db_name = "datab";
    private $username = "root";
    private $password = "";
    protected $conn;
     
    protected function __construct()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        //return $this->conn;
    }
    
    public function getConnection(){
        return $this->conn;
    }
}
?>