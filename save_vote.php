<?php

//get survey from db
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'useranswers_model.php';

$user_home = new USER();
$row = $user_home->getUser();
$questions = $_POST['questions'];
$surveyId = $_POST['survey-id'];

$survey = new Survey();
$answerModel = new Answer();
$useranswerModel = new UserAnswer ();
$answer = array();
foreach ($questions as $key => $question) {
    switch ($question['type']) {
        case 'text':
            if (!empty($question['text'])) {
                if (!isset($question['id'])) {  //has id ?
                    $answer['question_id'] = $question['qid'];
                    $answer['survey_id'] = $surveyId;
                    $answer['text'] = $question['text'];
                    $answerModel->insert($answer);
                    $ansId = $answerModel->lastInsertId();
                    
                    if ($user_home->is_logged_in()) {
                        $user_answers['answer_id'] = $ansId;
                        $user_answers['user_id'] = $row;
                        $useranswerModel->insert($user_answers);
                    }
                } else {
                    if ($user_home->is_logged_in()) {
                        $text = $question['text'];
                        $answerModel->update($question['id'], array('text'=>$text));
                    }
                }
            }
            break;
        case 'textarea':
            if (!empty($question['text'])) {
                if (!isset($question['id'])) {
                    $answer['question_id'] = $question['qid'];
                    $answer['survey_id'] = $surveyId;
                    $answer['text'] = $question['text'];
                    $answerModel->insert($answer);
                    $ansId = $answerModel->lastInsertId();

                    if ($user_home->is_logged_in()) {
                        $user_answers['answer_id'] = $ansId;
                        $user_answers['user_id'] = $row;
                        $useranswerModel->insert($user_answers);
                    }
                } else {
                    if ($user_home->is_logged_in()) {
                         $text = $question['text'];
                        $answerModel->update($question['id'],array('text'=>$text));
                        //$answerModel->update($question['id'], $answer['text']);
                    }
                }
            }
            break;
        case 'radio':
            $oldAnswer = $useranswerModel->getUserAnswers($surveyId, $row, $question['qid']);
           if (empty($oldAnswer)) {
               $answerModel->incrementCount($question['id']);
                if ($user_home->is_logged_in()) {
                    $user_answers['answer_id'] = $question['id'];
                    $user_answers['user_id'] = $row;
                    $useranswerModel->insert($user_answers);
                }
            }
            else{
                $answerModel->incrementCount($question['id']);
                $answerModel->decrementCount($oldAnswer[0]['id']);
                if ($user_home->is_logged_in()) {
                    $useranswerModel->updateRecord($question['id'] , $row, $oldAnswer[0]['id']);
                }
            }

            break;
        case 'hidden':
           $oldAnswer = $useranswerModel->getUserAnswers($surveyId, $row, $question['qid']);
           if (empty($oldAnswer)) {
               $answerModel->incrementCount($question['id']);
                if ($user_home->is_logged_in()) {
                    $user_answers['answer_id'] = $question['id'];
                    $user_answers['user_id'] = $row;
                    $useranswerModel->insert($user_answers);
                }
            }
            else{
                $answerModel->incrementCount($question['id']);
                $answerModel->decrementCount($oldAnswer[0]['id']);
                if ($user_home->is_logged_in()) {
                    $useranswerModel->updateRecord($question['id'] , $row, $oldAnswer[0]['id']);
                }
            }
            break;
        case 'checkbox':
            $oldAnswer = $useranswerModel->getUserAnswers($surveyId, $row, $question['qid']);
            if(empty($oldAnswer)){
                foreach ($question['id'] as $key => $id) {
                    $answerModel->incrementCount($id);
                    if ($user_home->is_logged_in()) {
                        $user_answers['answer_id'] = $id;
                        $user_answers['user_id'] = $row;
                         $useranswerModel->insert($user_answers);
                    }
                }
            }
            else{
                foreach ($oldAnswer as $key => $value) {
                    if(in_array($value['id'],$question['id'])){
                        unset($oldAnswer[$key]);
                        unset($question['id'][array_search($value[id], $question['id'])]);
                    }
                }

                foreach ($question['id'] as $key => $id) {
                    $answerModel->incrementCount($id);
                    if ($user_home->is_logged_in()) {
                        $user_answers['answer_id'] = $id;
                        $user_answers['user_id'] = $row;
                        $useranswerModel->insert($user_answers);
                    }
                }

                foreach ($oldAnswer as $key => $ans) {
                    $answerModel->decrementCount($ans['id']);
                    if ($user_home->is_logged_in()) {      
                        $useranswerModel->deleteRecord($row, $ans['id']);
                        
                    }
                }
            }
            break;
    }
}
                           