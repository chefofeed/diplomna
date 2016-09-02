<?php

session_start();
require_once 'class.user.php';
$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

$id = isset($_POST['id'])? $_POST['id']: 0;

$survey = new Survey();
$question = new Question();
$answer = new Answer();

$surveyData = $survey->getById($id);
$questionData = $question->listData(array('survey_id'=> $id));
$answerData = array();
foreach ($questionData as $key => $value) {
    $answerData[] = $answer->listData(array('question_id'=>$value['id'], 'survey_id'=>$id));
}
//dorabotka

error_log($surveyData)

?>

<!--html dorabotka-->
 <div class="panel panel-info">
                        <div class="panel-heading">
                            Page 1/1
                        </div>
                        <div class="panel-body">
                            <form id="survey">
                                <div class="form-group">
                                    <input type="text" name="formtitle" placeholder="Form title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="formdescription" placeholder="Form Description" class="form-control"> 
                                </div>
                                <div class="question">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h2>Untitled Question</h2> 
                                            </div>
                                            <input type="hidden" name="htext" >   
                                            <div class="input-group option">
                                                <span class="input-group-addon">
                                                    <input type="radio" aria-label="..." class="type">
                                                </span>
                                                <input type="text" class="form-control" aria-label="..."class="form-control answer" value="Option 1">
                                            </div>  
                                        </div> 
                                    </div>
                                </div>  
                            </form>    
                        </div>
                    </div>
          