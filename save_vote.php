<?php
//get survey from db
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$user_home = new USER();

$questions = $_POST['questions'];
//$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
//$stmt->execute(array(":uid" => $_SESSION['userSession']));
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
//$rows = $stmt->fetch(PDO::FETCH_ASSOC);

$survey = new Survey();
$question = new Question();
$answer = new Answer();
                           
foreach ($questions as $key => $question) {
    $qa_content = '';
    if ($question['type'] == 'text'  ) {
        //zapazvame v bazata
        $query = "UPDATE " . $this->table ." SET "; //.$data. " WHERE id = :id";
            foreach ($data as $key => $val) {
                $query .= $key.'='.':'.$key;
            }
            $query .= 'WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":id", $id);
            foreach ($data as $key => $value) {
                 $stmt->bindparam(":".$key, $value);
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if ($question['type'] == 'textarea') {

$query = "UPDATE " . $this->table ." SET "; //.$data. " WHERE id = :id";
            foreach ($data as $key => $val) {
                $query .= $key.'='.':'.$key;
            }
            $query .= 'WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":id", $id);
            foreach ($data as $key => $value) {
                 $stmt->bindparam(":".$key, $value);
            }
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
                               