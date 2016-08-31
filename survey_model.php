<?php

require_once 'mysql_model.php';

class Survey extends Mysql_model {

    public function __construct() {
        $this->table = 'survey';
        parent::__construct();
    }

    public function getSurvey($id) {
        try {
            $stmt = $this->conn->prepare("SELECT survey.*,question.*,answers.text as answer
                FROM survey
                LEFT JOIN question ON survey.id=question.survey_id
                RIGHT JOIN answers ON question.id= answers.question_id");
//        $stmt->bindparam(":survey_id",$id);
//        $stmt->bindparam(":question_id",$id);
            //$stmt->bindparam("id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log(var_export($row, true));
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
