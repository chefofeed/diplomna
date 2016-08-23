<?php

require_once 'survey_model.php';
require_once 'class.user.php';

session_start();
$user = new USER();
$data = $_POST;

$survey['title'] = isset($data['formtitle'])? $data['formtitle']:'';
$survey['description'] = isset($data['description'])? $data['description']:'';
$survey['user_id'] = $user->getUser();

 $surveyModel = new Survey();
 $surveyModel->insert($survey);
 $suerveyId = $surveyModel->lastInsertId();
 
 $surveyModel = new Survey();
 foreach ($data['questions'] as $key => $value) {
    $question['text']=$value['question'];
    $question['type']=$value['type'];
    $question['survey_id'] = $suerveyId;
    
    //insert question
    foreach ($data['questions'][$key]['answers'] as $k => $v) {
        $answer['text'] = $v; 
        $answer['question_id'] = xx;
        $answer['user_id'] = '';
    }
    
}
 
 error_log($_SESSION['userSession']);

echo json_encode($data);