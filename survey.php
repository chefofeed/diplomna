<?php
//get survey from db
//
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';
require_once 'useranswers_model.php';

$user_home = new USER();

$token = $_GET['token'];
$survey = new Survey();
$question = new Question();
$answer = new Answer();
$useranswer = new UserAnswer();
$surveyData = $survey->getByToken($token);
if($surveyData['single_response'] == 1){
    if (!$user_home->is_logged_in()) {
        $user_home->redirect('index.php?token='.$token);
    }
}

if ($user_home->is_logged_in()) {
    $votes = $useranswer->getUserAnswerIdForSurvey($surveyData['id'], $user_home->getUser());
}
$votes = $votes === false? array(): $votes;
///$votes = array_column($votes, 'id');

$questionData = $question->listData(array('survey_id' => $surveyData['id']));
if( $surveyData['shuffle_question'] ){
    shuffle($questionData);
}
//error_log(var_export($questionData, true));
$answerData = array();
foreach ($questionData as $key => $value) {
    $answerData[] = $answer->listData(array('question_id' => $value['id'], 'survey_id' => $surveyData['id']));
}
?>
<!--//show html/form to vote-->
<html>
    <head>
        <title>Form to vote</title>
        <!-- Bootstrap -->
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link  type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link type="text/css" href="assets/styles.css" rel="stylesheet" media="screen">
    </head>
    <body  class="base-body vote-page">


        
        <div class="row">
            <div class="col-lg-4 col-md-offset-4" id="forms-vote-title">
                <h1 class="page-header ">Forms</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-offset-3">
                <div class="panel panel-yellow" id="QAsurv">
                    <div class="panel-heading">
                        Basic Form Elements
                    </div>
                    <div class="panel-body fvote">
                        <div class="alert alert-info" id="ftitle" survey-id="<?php echo $surveyData['id']; ?>"><h5><?php echo $surveyData['title'] ?></h5></div>
                        <div class="well"> <small><?php echo $surveyData['description'] ?></small></div>


                        <form id="myForm">
                                
                            <?php
                           
                            //error_log(var_export($questionData, true));
                            foreach ($questionData as $key => $question) {
                                $qa_content = '<div class="question_vote" id="'.$question['id'].'" type="'.$question['type'].'">';
                                if ($question['type'] == 'text') {
                                    if(!empty($answerData[$key]) && in_array($answerData[$key][0]['id'], $votes)){
                                        $text = $answerData[$key][0]['text'];
                                        $id = 'id="'.$answerData[$key][0]['id'].'"';
                                    }
                                    else{
                                        $text = '';
                                        $id = '';
                                    }
                                    $qa_content .= '<div class="form-group"><div class="form-group text">
                                            <div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div></div>
                                            <input  type = "text"  '.$id.' class="form-control"   value="'.$text.'" placeholder ="Type your answer here" >
                                           </div>';
                                    
                                }
                                if ($question['type'] == 'textarea') {
                                    if(!empty($answerData[$key]) && in_array($answerData[$key][0]['id'], $votes)){
                                        $text = $answerData[$key][0]['text'];
                                        $id = 'id="'.$answerData[$key][0]['id'].'"';
                                    }
                                    else{
                                        $text = '';
                                        $id = '';
                                    }
                                    $qa_content .= '<div class="form-group"><div class="form-group texterea">
                                      <div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div></div> 
                                           <textarea class="form-control"  rows="3" '.$id.' placeholder="Type your answer here" >'.$text.'</textarea>                                            
                                        </div>';
                                   
                                }
                                // if ($question['type'] == 'textarea') {
//                                    if(!empty($answerData[$key]) && in_array($answerData[$key][0]['id'], $votes)){
//                                        $text = $answerData[$key][0]['text'];
//                                        $id = 'id="'.$answerData['key'][0]['id'].'"';
//                                    }
//                                    else{
//                                        $text = '';
//                                        $id = '';
//                                    }
//                                    $qa_content .= '<div class="form-group"><div class="form-group texterea">
//                                      <div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div></div> 
//                                           <textarea class="form-control"  rows="3" '.$id.' placeholder="Type your answer here" value="'.$text.'"></textarea>                                            
//                                        </div>';
//                                   
//                                }
////
                                switch ($question['type']) {
                                    case 'radio':
                                        $qa_content .= '<div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div>';
                                        foreach ($answerData[$key] as $k => $answer) {
                                            if(in_array($answer['id'], $votes)){
                                                $checked = 'checked="checked"';
                                            }
                                            else{
                                                $checked = '';
                                            }
                                            $qa_content .='<div class="form-group">
                                                <div class="radio">
                                                    <label>';
                                                $qa_content .= '<input type="radio" name="optionsRadio" id="'.$answer['id'].'"'.$checked.'><span>' . $answer['text'] . '</span>
                                                   </label>
                                                </div></div>';
                                            
                                        }
                                        break;
                                    case 'checkbox':

                                        $qa_content .= '<div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div>';
                                        foreach ($answerData[$key] as $key => $answer) {
                                            if(in_array($answer['id'], $votes)){
                                                $checked = 'checked="checked"';
                                            }
                                            else{
                                                $checked = '';
                                            }
                                            $qa_content .='<div class="form-group">
                                            <div class="checkbox"> 
                                            <label>';
                                            $qa_content .= '<input id="'.$answer['id'].'" type="checkbox" name="vote_check" '.$checked.'>' . $answer['text'] . '
                                                </label>
                                            </div></div>';
                                        }

                                        break;
                                    case 'hidden':
  
                                        $qa_content .= '<div class="form-group">
                                            <div class="list">
                                                <div class="panel panel-primary"><span class="glyphicon glyphicon-question-sign"></span> '.$question['text'].' </div></div>
                                                <select class="form-control" >';
                                        
                                        foreach ($answerData[$key] as $k => $answer) {
                                            if(in_array($answer['id'], $votes)){
                                                $selected = ' selected ';
                                            }
                                            else{
                                                $selected = '';
                                            }
                                            $qa_content .= '<option value="' . $answer['id'] . '"'.$selected.'>' . $answer['text'] . "</option>";
                                        }
                                        $qa_content .= "</select> </div>";
         
                                        break;
                                }
                                $qa_content .= '</div>';
                                echo $qa_content;
                            }
                            ?>

                        </form>
                        <button type="button" class="btn btn-primary" id="submit-vote">Submit</button>
                    </div>
                </div>               
            </div>
        </div>
        




    </body>

    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/scripts.js"></script>
</body>
</html>
