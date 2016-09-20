<?php

//get survey from db
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$user_home = new USER();
$questions = $_POST['questions'];
$surveyId = $_POST['survey-id'];

$survey = new Survey();
$answerModel = new Answer();
$answer = array();
foreach ($questions as $key => $question) {
    switch ($question['type']) {
        case 'text':
            if (!empty($question['text'])) {
                $answer['question_id'] = $question['qid'];
                $answer['survey_id'] = $surveyId;
                $answer['text'] = $question['text'];
                $answerModel->insert($answer);
            }
            break;
        case 'textarea':
            if (!empty($question['textarea'])) {
                $answer['question_id'] = $question['qid'];
                $answer['survey_id'] = $surveyId;
                $answer['text'] = $question['text'];
                $answerModel->insert($answer);
            }
            break;
        case 'radio':
            $answerModel->incrementCount($question['id']);
            break;
        case 'hidden':
            $answerModel->incrementCount($question['id']);
            break;
        case 'checkbox': 
            foreach ($question['id'] as $key => $id) {
                $answerModel->incrementCount($id);
            }
            break;
    }

}
                           