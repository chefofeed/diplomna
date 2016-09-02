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
        $query = $this->conn->query('DESCRIBE ' . $this->table);
        $this->tableStruct = $query->fetchAll(PDO::FETCH_COLUMN, 'Field');
        //error_log('DESCRIBE '.$this->table);
    }

    public function insert($data) {
        try {
            $this->checkFields($data);
            $query = "INSERT INTO " . $this->table . "("; //userName,userEmail,userPass,tokenCode) 
            // VALUES(";
            foreach ($this->tableStruct as $key => $value) {
                if ($value == 'id') {
                    continue;
                }
                $query.= $value . ',';
            }
            $query = rtrim($query, ',');
            $query.= ") VALUES(";
            foreach ($this->tableStruct as $key => $value) {
                if ($value == 'id') {
                    continue;
                }
                $query.= ':' . $value . ',';
            }
            $query = rtrim($query, ',');
            $query.= ')';
            //:user_name, :user_mail, :user_pass, :active_code )";
            $stmt = $this->conn->prepare($query);
            foreach ($this->tableStruct as $key => $value) {
                if ($value == 'id') {
                    continue;
                }
                $stmt->bindparam(":" . $value, $data[$value]);
            }
//            $stmt->bindparam(":user_name", $uname);
//            $stmt->bindparam(":user_mail", $email);
//            $stmt->bindparam(":user_pass", $password);
//            $stmt->bindparam(":active_code", $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    ////////////////////////////////////////////

    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE userID=:userID";
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":userID", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function listData($criteria) {
        if (is_array($criteria)) {
            $query = "SELECT * FROM " . $this->table . " WHERE";
            foreach ($criteria as $key => $value) {
                $query.=" ".$key ."= :" . $key . " AND";
            }
            $query=  rtrim($query,"AND");
            error_log($query);
            try {
                $stmt = $this->conn->prepare($query);
                foreach ($criteria as $key => $value) {
                 $stmt->bindparam(":".$key, $value);   
                }
                
                $stmt->execute();
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $row;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }

    /////////////////////////////////////////////////
    public function update() {
        
    }

    public function delete($id) {
        //TODO
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

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    private function query() {
        
    }

    private function checkFields(&$data) {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->tableStruct)) {
                unset($data[$key]);
            }
        }
    }

}
