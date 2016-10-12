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
?>

<div class="panel panel-primary">
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
                    <div class="col-md-6 row-buttons">
                        <div>
                        <button type="button" class="btn btn-default pull-right hidden cmd-delete"  aria-label="Left Align">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                         <button type="button" class="btn btn-default pull-right hidden cmd-duplicate" aria-label="Left Align">
                            <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                        </button>
                         <button type="button" class="btn btn-default pull-right hidden cmd-edit" aria-label="Left Align">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                            </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="button" id="add_question"  class="btn btn-primary">Add Question</button>
            </div>

            <div class="panel panel-primary send-form">
                <div class="panel-heading ">
                    Form and page settings
                </div>
                <div class="panel-body">


                    <div class="checkbox">
                        <label><input type="checkbox"  id ="single_response" value="">Only allow one response per person (requires login)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="shuffle_question" value="">Shuffle question order</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="edit_response" value="">Allow responders to edit responses after submitting</label>
                    </div>
                    </form>  
                    
                </div>
                </div>
                <div class="form-group">
                        <button type="button" id="submit-question"  class="btn btn-primary">Submit</button>
                    </div>
               
