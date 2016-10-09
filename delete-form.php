<?php
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'useranswers_model.php';

$user = new USER();
$surveyId = $_POST['survey-id'];
//error_log($surveyId);
//error_log($questionId);
$survey = new Survey();
$question = new Question();
$answer = new Answer();
$useranswerModel = new UserAnswer;
$deleted = $useranswerModel->deleteAnswersForSurvey($user->getUser() ,$surveyId);
$row = $answer->deleteAnswersForSurvey($surveyId);
if($row){
    $row = $question->deleteQuestionsForSurvey($surveyId);
}
if($row){
    $row = $survey->delete($surveyId);
}
if($row){
    echo json_encode(array('success'=>$row));
}

 ?>
