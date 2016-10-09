<?php

require_once 'mysql_model.php';

class UserAnswer extends Mysql_model {

    public function __construct() {
        $this->table = 'user_answers';
        parent::__construct();
    }

    public function getUserAnswersforSurvey($sid, $uid) {
        try {
            $stmt = $this->conn->prepare("SELECT answers.* , user_answers.* 
FROM answers
LEFT JOIN user_answers ON answers.id = user_answers.answer_id
where user_answers.user_id =:userID and answers.survey_id =:survey_id");
            $stmt->bindparam(":survey_id", $sid);
            $stmt->bindparam(":userID", $uid);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getUserAnswerIdForSurvey($sid, $uid) {
        try {
            $stmt = $this->conn->prepare("SELECT answers.id  
FROM answers
LEFT JOIN user_answers ON answers.id = user_answers.answer_id
where user_answers.user_id =:userID and answers.survey_id =:survey_id");
            $stmt->bindparam(":survey_id", $sid);
            $stmt->bindparam(":userID", $uid); //
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function getUserAnswers($sid, $uid, $qid) {
        try {
            $stmt = $this->conn->prepare("SELECT answers.* , user_answers.* 
FROM answers
LEFT JOIN user_answers ON answers.id = user_answers.answer_id
where user_answers.user_id =:userID and answers.survey_id =:survey_id and answers.question_id =:question_id");
            $stmt->bindparam(":survey_id", $sid);
            $stmt->bindparam(":userID", $uid);
            $stmt->bindparam(":question_id", $qid);
            $stmt->execute();
            //$row = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            $rows = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function updateRecord($newaid, $uid, $oldaid) {
        try {
            //update user_answers set answer_id = 63 where user_id=1 and  answer_id =64;
            $stmt = $this->conn->prepare("UPDATE user_answers SET answer_id = :newanswer_id WHERE user_id=:user_id and  answer_id =:oldanswer_id");
            $stmt->bindparam(":newanswer_id", $newaid);
            $stmt->bindparam(":user_id", $uid);
            $stmt->bindparam(":oldanswer_id", $oldaid);
            $stmt->execute();
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function answerIsGiven($uid, $aid) {
        try {
            //select * from user_answers where user_id=1 and  answer_id =63;
            $stmt = $this->conn->prepare("SELECT * FROM user_answers WHERE user_id=:user_id and  answer_id =:answer_id");
            $stmt->bindparam(":user_id", $uid);
            $stmt->bindparam(":answer_id", $aid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function deleteRecord($uid, $aid) {
        try {
            //select * from user_answers where user_id=1 and  answer_id =63;
            $stmt = $this->conn->prepare("DELETE FROM user_answers WHERE user_id=:user_id and  answer_id =:answer_id");
            $stmt->bindparam(":user_id", $uid);
            $stmt->bindparam(":answer_id", $aid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function deleteQuestionAnswers($uid, $surveyId, $questionId) {
        try {
            //select * from user_answers where user_id=1 and  answer_id =63;
            $stmt = $this->conn->prepare("DELETE FROM user_answers WHERE user_id=:user_id and  answer_id IN (SELECT id FROM answers where question_id = :question_id AND survey_id = :survey_id)");
            $stmt->bindparam(":user_id", $uid);
            $stmt->bindparam(":question_id", $questionId);
            $stmt->bindparam(":survey_id", $surveyId);
            $stmt->execute();
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
           // return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    public function deleteAnswersForSurvey($uid, $surveyId) {
        try {
            //select * from user_answers where user_id=1 and  answer_id =63;
            $stmt = $this->conn->prepare("DELETE FROM user_answers WHERE user_id=:user_id and  answer_id IN (SELECT id FROM answers where survey_id = :survey_id)");
            $stmt->bindparam(":user_id", $uid);   
            $stmt->bindparam(":survey_id", $surveyId);
            $stmt->execute();
            //$row = $stmt->fetch(PDO::FETCH_ASSOC);
           // return $row;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

}
