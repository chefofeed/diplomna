<?php

require_once 'mysql_model.php';

class Question extends Mysql_model {
    public function __construct() {
        $this->table = 'question';
        parent::__construct();
    }
      public function deleteQuestionsForSurvey($sid) {
      try {
          $query = "DELETE FROM " . $this->table . " WHERE survey_id=:survey_id";
          $stmt = $this->conn->prepare($query);
          $stmt->bindparam(":survey_id", $sid);
          $row = $stmt->execute();

          return $row;
      } catch (PDOException $ex) {
          echo $ex->getMessage();
      }
    }
}