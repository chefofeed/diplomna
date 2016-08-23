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
        <div class="navbar navbar-default">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <a class="brand" href="#"> HOME</a>
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
                            Poll options
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="#">Add question</a></li>
                            <li><a href="#">Choose question</a></li>

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
                            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> 
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
            </div>       
        </div>        
        <! --/nav-bar
        <div class="container ">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
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
                                                <span class="input-group-addon type">
                                                    <input type="radio" aria-label="...">
                                                </span>
                                                <input type="text" class="form-control" aria-label="..."class="form-control answer" value="Option 1">
                                            </div><!-- /input-group -->
                                        </div> 
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <button type="button" id="submit-question"  class="btn btn-primary">Submit</button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.fluid-container-->
        <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/scripts.js"></script>





    </body>
</html>
