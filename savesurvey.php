<?php

require_once 'survey_model.php';
$data = $_POST;

 $survey = new Survey();
 $survey->insert(array('title'=>'NEW title', 'htext'=>'TEsting', 'surveyuser_id'=>88));

echo json_encode($_POST);