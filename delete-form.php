
<?php
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$surveyId = $_POST['survey-id'];
$questionId = $_POST['question-id'];

$survey = new Survey();
$question = new Question();
$answer = new Answer();

$row = $answer->deleteAnswers($questionId,$surveyId);
if($row){
    $row = $question->delete($questionId);// sichki Q Del//////////////////////
    $row = $survey->delete($surveyId);
}

echo json_encode(array('success'=>$row));
 ?>

