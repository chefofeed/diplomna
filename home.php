<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//main page - all forms


session_start();
require_once 'class.user.php';
require_once 'survey_model.php';
$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('index.php');
}
$survey = new Survey();
$surveys = $survey->listData(array('user_id' => $user_home->getUser()));
$blank = array('title' => 'BLANK', 'description' => 'Create blank survey', 'create_date' => 'today', 'id' => 'blank');
$surveys[] = $blank;

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$rows = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html class="no">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Poll page</title>
        <!-- Bootstrap -->
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link  type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link type="text/css" href="assets/styles.css" rel="stylesheet" media="screen">
    </head>
    <body >
        <!--<div class="navbar navbar-defaul">-->
        <!--            <div class="navbar-inner">-->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="brand" href="home.php"> HOME</a>
                <div class="nav-collapse collapse">
                    Split button 
                    <div class="btn-group">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            POll
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="pol" aria-labelledby="dropdownMenu1">
                            <li><a href="#">Create poll</a></li>
                            <li><a href="#">Delete </a></li>
                        </ul>
                    </div>


                    <button type="button"  id="pol" class="btn btn-danger">Poll</button>
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Options</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Create poll</a></li>
                        <li><a href="#">Delete poll</a></li>
                    </ul>
                </div>
                
                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        All polls
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#"> Poll Action</a></li>
                        <li><a href="#">Another  poll action</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Poll results
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Poll share
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </div>
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> 
                            <?php echo $row['userEmail']; ?> <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div> 
            <!--            </div>       -->
            <!--        </div>        -->
            <!--/.fluid-container-->
        </nav>
        <div class="row">
            <div class ="col-md-8 col-md-offset-2">
                <div class="container" id="page_content">    
                    <div class="row">
                        <?php
                        $openTag = 0;
                        $closeTag = 0;
                        foreach ($surveys as $key => $value) {
                            if ($key % 4 == 0) {
                                echo "<div class =row>";
                                $openTag++;
                            }
                            $panel = '<div class="col-md-3">
                                <div class="panel ';
                            $panel .= $value['title'] == 'BLANK' ? 'panel-primary blank' : 'panel-success survey';
                            $panel .= '" id="' . $value['id'] . '">
                                <div class="panel-heading">' .
                                    $value['title']
                                    . '</div>
                                <div class="panel-body">' .
                                    $value ['description']
                                    . '</div>
                                <div class="panel-footer">
                                    Created on: ' . $value['create_date'] .
                                    '</div>
                                </div>
                            </div>';
                            echo $panel;
                            if ($key % 4 == 3) {
                                echo "</div>";
                                $closeTag++;
                            }
                        }
                        if ($openTag > $closeTag) {
                            echo "</div>";
                        }
                        
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/scripts.js"></script>

    </body>
</html>
