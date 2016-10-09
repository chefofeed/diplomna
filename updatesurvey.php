<?php

require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'class.user.php';

session_start();
$user = new USER();
$data = $_POST;
$user->getUserById($user->getUser());
$surveyId = $_POST['survey-id'];

$surveyModel = new Survey();
$questionModel = new Question();
$answerModel = new Answer();

$survey['title'] = isset($data['formtitle']) ? $data['formtitle'] : '';
$survey['description'] = isset($data['description']) ? $data['description'] : '';
$survey['single_response'] = filter_var($data['single_response'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
$survey['edit_response'] = filter_var($data['edit_response'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
$survey['shuffle_question'] = filter_var($data['shuffle_question'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
//$survey['user_id'] = $user->getUser();
$survey['change_date'] = gmdate('Y-m-d H:i:s');

$surveyModel->update($surveyId, $survey);

foreach ($data['questions'] as $key => $value) {
    $question['text'] = $value['text'];
    $question['type'] = isset($value['type'])?$value['type']:'';
    $question['id'] = isset($value['id'])?$value['id']:'';
    if ($question['type'] == 'radio' || $question['type'] == 'checkbox' || $question['type'] == 'hidden') {
        if (isset($value['id'])) {
            $questionModel->update($value['id'], $question);
            foreach ($value['answers'] as $k => $v) {
                if (isset($v['id'])) {
                    $answer['text'] = $v['text'];
                    $answerModel->update($v['id'], $answer);
                } else {
                    $answer['text'] = $v['text'];
                    $answer['question_id'] = $value['id'];
                    $answer['survey_id'] = $surveyId;
                    $answerModel->insert($answer);
                }
            }
        } else {
            $question['survey_id'] = $surveyId;
            $questionModel->insert($question);
            $qid = $questionModel->lastInsertId();
            foreach ($value['answers'] as $k => $v) {
                $answer['text'] = $v['text'];
                $answer['question_id'] = $qid;
                $answer['survey_id'] = $surveyId;
                $answerModel->insert($answer);
            }
        }
    }
    else{
        if (isset($value['id'])) {
        $questionModel->update($value['id'], $question);
        }else{
        $question['survey_id'] = $surveyId;
        $questionModel->insert($question);
        }
    }
    //else
}


