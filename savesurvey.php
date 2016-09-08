<?php

//date_default_timezone_set('Europe/Sofia');
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'class.user.php';

session_start();
$user = new USER();
$data = $_POST;

//error_log('get user:');
$row = $user->getUserById($user->getUser());
//error_log(var_export($row,TRUE));

$survey['title'] = isset($data['formtitle']) ? $data['formtitle'] : '';
$survey['description'] = isset($data['description']) ? $data['description'] : '';
$survey['single_response']= filter_var($data['single_response'], FILTER_VALIDATE_BOOLEAN)? 1: 0;
$survey['edit_response']= filter_var($data['edit_response'], FILTER_VALIDATE_BOOLEAN)? 1: 0;
$survey['shuffle_question']= filter_var($data['shuffle_question'], FILTER_VALIDATE_BOOLEAN)? 1: 0;
$survey['user_id'] = $user->getUser();
$survey['create_date'] = gmdate('Y-m-d H:i:s');
$survey['token']= md5($row['userID'].$row['userName'].$survey['title']);
//error_log(var_export($row,TRUE));
$surveyModel = new Survey();
$surveyModel->insert($survey);
$surveyId = $surveyModel->lastInsertId();

$questionModel = new Question();
$answerModel = new Answer();
foreach ($data['questions'] as $key => $value) {
    $question['text'] = $value['question'];
    $question['type'] = isset($value['type']) ? $value['type'] : '';
    $question['survey_id'] = $surveyId;
    //insert question
    $questionModel->insert($question);
    $questionId = $questionModel->lastInsertId();
    foreach ($data['questions'][$key]['answers'] as $k => $v) {
        $answer['text'] = $v;
        $answer['question_id'] = $questionId;
        $answer['survey_id'] = $surveyId;
        $answerModel->insert($answer);
    }


    
    echo json_encode($data);
}