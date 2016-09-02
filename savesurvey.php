<?php

require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'class.user.php';

session_start();
$user = new USER();
$data = $_POST;

$survey['title'] = isset($data['formtitle']) ? $data['formtitle'] : '';
$survey['description'] = isset($data['description']) ? $data['description'] : '';
$survey['user_id'] = $user->getUser();
$survey['create_date'] = gmdate('Y-m-d H:i:s');

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

//    error_log($_SESSION['userSession']);

    echo json_encode($data);
}