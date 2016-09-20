<?php

require_once 'mysql_model.php';

class Answer extends Mysql_model {

    public function __construct() {
        $this->table = 'answers';
        parent::__construct();
    }

    public function deleteAnswers($qid, $sid) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE question_id=:question_id AND survey_id=:survey_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":question_id", $qid);
            $stmt->bindparam(":survey_id", $sid);
            $row = $stmt->execute();

            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function incrementCount($id) {
        $count = $this->getById($id)['count'];
        $count = empty($count) ? 1 : ++$count;
        try {
            $query = "UPDATE " . $this->table . " SET count = :count "; //.$data. " WHERE id = :id";
            $query .= 'WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":id", $id);
            $stmt->bindparam(":count", $count);
            $stmt->execute();
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);

            return true;
        } catch (PDOException $ex) {
            return false;
            echo $ex->getMessage();
        }
    }

}
