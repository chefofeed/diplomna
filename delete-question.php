<?php
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$surveyId = $_POST['survey-id'];
error_log($surveyId);
$questionId = $_POST['question-id'];
error_log($questionId);
$question = new Question();
$answer = new Answer();
$row = $answer->deleteAnswers($questionId,$surveyId);
if($row){
    $row = $question->delete($questionId);
}

echo json_encode(array('success'=>$row));
 ?>

 