<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$rows = $stmt->fetch(PDO::FETCH_ASSOC);

$id = isset($_POST['id']) ? $_POST['id'] : 0;

$survey = new Survey();
$question = new Question();
$answer = new Answer();
$surveyData = $survey->getById($id);
$questionData = $question->listData(array('survey_id' => $id));
error_log(var_export($questionData, true));
$answerData = array();
foreach ($questionData as $key => $value) {
    $answerData[] = $answer->listData(array('question_id' => $value['id'], 'survey_id' => $id));
}
error_log(var_export($answerData, true));
//generate random token
//$token = md5(uniqid(rand()));
//echo $token;
?>




<!--html dorabotka-->
<div class="panel panel-info">
    <div class="panel-heading">
        Page 1/1
    </div>
    <div class="panel-body">
        <form id="survey">
            <div class="form-group">
                <input type="text" name="formtitle" placeholder="Form title" class="form-control" value="<?php echo $surveyData['title'] ?>">
            </div>
            <div class="form-group">
                <input type="text" name="formdescription" placeholder="Form Description" class="form-control" value=" <?php echo $surveyData['description'] ?>">
            </div>
<?php
$qa_content = '';
$a_content = '';
foreach ($questionData as $key => $question) {
    $qa_content = '<div class="question">
                                    <div class="row">
                                        <div class="col-lg-6">';

    $qa_content.= "<h2>" . $question['text'] . "</h2>";
    $qa_content.= '<input type="hidden" name="htext">';
    if($question['type'] == 'text'){
         $qa_content .= '<div class="row"><div class="col-lg-6"><div class="form-group">' .
                            '<input type="text" class="form-control answer" aria-label="..." value="Add your text here!" disabled="disabled"> 
                            </div></div></div></div>';
                   // continue;
    }
    if($question['type'] == 'textarea'){
         $qa_content .= '<div class="row"><div class="col-lg-6"><div class="form-group">' .
                            '<input type="texterea" class="form-control answer" aria-label="..." value="    text here!" disabled="disabled"> 
                            </div></div></div></div>';
         //continue;
    }
    foreach ($answerData[$key] as $k => $answer) {
                                            
            switch ($question['type']) {
            case 'radio':
                     $qa_content .= '<div class="input-group option">
                                    <span class="input-group-addon">';
                     $qa_content.='<input type="radio" aria-label="..." class="type">
                                      </span>
                                          <input type="text" class="form-control" aria-label="..."class="form-control answer" value="'.$answer['text'].'">
                                       </div>' ;
            break;
            case 'checkbox':
                 $qa_content .= '<div class="input-group option">
                                    <span class="input-group-addon">';
                     $qa_content.='<input type="checkbox" aria-label="..." class="type">
                                      </span>
                                          <input type="text" class="form-control" aria-label="..."class="form-control answer" value="'.$answer['text'].'">
                                       </div></div>' ;
            break;
            case 'hidden':
                 $qa_content .= '<div class="input-group option">
                                    <span class="input-group-addon">';
                     $qa_content.='<input type="hidden" aria-label="..." class="type">
                                      </span>
                                          <input type="text" class="form-control" aria-label="..."class="form-control answer" value="'.$answer['text'].'">
                                       </div><div</div></div>' ;
            break;
            }
                                           
            $a_content.=   '</div> 
           </div>
       </div>';
    }
}
echo $qa_content;
?>
        </form>    
    </div>
</div>
<div>
    <button type="button" id="submit-question"  class="btn btn-primary">Send form</button>
</div>