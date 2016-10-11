<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'mysql_model.php';


$survey = new Survey();
//$questionData = $question->listData(array('survey_id' => $surveyData['id']));
$surveyId = $_SESSION['current-survey'];
$surveyData = $survey->getById($surveyId);;

//zimame token po survey id
  echo "http://" . $_SERVER['SERVER_NAME'] ."/". "diplomna/survey.php?token=". $surveyData['token'];
