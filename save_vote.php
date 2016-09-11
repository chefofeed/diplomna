<?php
//get survey from db

session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$user_home = new USER();

$token = $_GET['token'];

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

$survey = new Survey();
$question = new Question();
$answer = new Answer();
$surveyData = $survey->getByToken($token);

$questionData = $question->listData(array('survey_id' => $surveyData['id']));

$answerData = array();
foreach ($questionData as $key => $value) {
    $answerData[] = $answer->listData(array('question_id' => $value['id'], 'survey_id' => $surveyData['id']));
}
                           
                            
                            foreach ($questionData as $key => $question) {
                                 $qa_content = '';
                                if ($question['type'] == 'text'  ) {
                                    
                                    
                                }
                                if ($question['type'] == 'textarea') {
                                    
                                   
                                }
                            }
                               