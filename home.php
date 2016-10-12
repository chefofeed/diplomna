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
<html>
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
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body id="body-style" >
       <div class="container">
        <!--<div class="navbar navbar-defaul">-->
        <!--            <div class="navbar-inner">-->
        <nav class="navbar navbar-dark bg-primary navbar-fixed-top">
            <div class="container-fluid">
                <a class="brand" href="home.php"> HOME</a>

                <div class="btn-group">
                    <button type="button" class="btn btn-danger create-poll">Create poll</button>
                </div>


                <div class="btn-group">
                    <button type="button" class="btn btn-danger delete-poll">Delete poll</button>
                </div>


                <div class="btn-group">
                    <button type="button" class="btn btn-danger show-results">Poll results</button>
                </div>
                <form class="hidden" method="POST" action="results.php" id="result-form"> 
                    <input name="id" type="hidden">
                </form>

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

        </nav>
        <div class="row">
            <div class ="col-md-8 ">
                <div class="loader hidden"><img class="loader-gif" src="bootstrap/img/ajax-loader.gif"></div>
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
                            $panel .= $value['title'] == 'BLANK' ? 'panel-success blank' : 'panel-primary survey';
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
</div>
</body>
</html>