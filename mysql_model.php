<?php

require_once 'dbconfig.php';

class Mysql_model {

    //@var $con PDO 
    protected $conn;
    protected $table;
    protected $tableStruct;

    public function __construct() {
        //$database = new Database();
        //$db = $database->dbConnection();
        $this->conn = Database::getInstance()->getConnection();
        $query = $this->conn->query('DESCRIBE '.$this->table);
        $this->tableStruct = $query->fetchAll(PDO::FETCH_COLUMN, 'Field');
        error_log('DESCRIBE '.$this->table);
        error_log(var_export($this->tableStruct, TRUE));
    }

    public function insert($data) {
        try {
            $this->checkFields($data);
            $stmt = $this->conn->prepare("INSERT INTO ".$this->table."(userName,userEmail,userPass,tokenCode) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name", $uname);
            $stmt->bindparam(":user_mail", $email);
            $stmt->bindparam(":user_pass", $password);
            $stmt->bindparam(":active_code", $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function update() {
        
    }

    public function delete($id) {
        try {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name", $uname);
            $stmt->bindparam(":user_mail", $email);
            $stmt->bindparam(":user_pass", $password);
            $stmt->bindparam(":active_code", $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    private function query() {
        
    }
    
    private function checkFields(&$data){
        foreach ($data as $key => $value) {
            if(!in_array($key, $this->tableStruct)){
                unset($data[$key]);
            }
        }
    }

}
