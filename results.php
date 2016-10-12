<?php
require_once 'class.user.php';
require_once 'survey_model.php';
require_once 'question_model.php';
require_once 'answer_model.php';

$id = isset($_POST['id']) ? $_POST['id'] : 72;//////////////////////////////id

$survey = new Survey();
$question = new Question();
$answer = new Answer();
$surveyData = $survey->getById($id);
$questionData = $question->listData(array('survey_id' => $id));

$answerData = array();
foreach ($questionData as $key => $value) {
    $answerData[$value['id']] = $answer->listData(array('question_id' => $value['id'], 'survey_id' => $id));
}
//error_log(var_export($answerData, true));
?>
<html>
    <head>
        <title>Results</title>
        <!-- Bootstrap -->
        <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link  type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link type="text/css" href="assets/styles.css" rel="stylesheet" media="screen">

      
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages': ['corechart']});

<?php
foreach ($questionData as $key => $value) {
    if ($value['type'] == 'radio' || $value['type'] == 'checkbox' || $value['type'] == 'hidden') {
        echo 'google.charts.setOnLoadCallback(drawChart' . $value['id'] . ');';

        $function = " function drawChart" . $value['id'] . "() {
                            // Create the data table.
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Answer');
                            data.addColumn('number', 'Count');";
        $data = array();
        foreach ($answerData[$value['id']] as $key => $ans) {
            //error_log($ans['text']);
            if (isset($ans['text'])) {
                $data[] = [$ans['text'], isset($ans['count']) ? intval($ans['count']) : 0];
            }
        }
        $function .= "data.addRows(" . json_encode($data) . ");

                            // Set chart options
                            var options = {'title': '" . $value['text'] . "',
                                'width': 400,
                                'height': 300};

                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.PieChart(document.getElementById('chart_div" . $value['id'] . "'));
                            chart.draw(data, options);
                        }";
        echo $function;
    }
}
?>
        </script>

    </head>
    <body  class="base-body2" >
            <div class="row">
                <div class="col-md-8 col-md-offset-2" id="result-header">
                    <h1 class="page-header">Results from the votes</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-primary" >
                        <div class="panel-heading resulthead">
                            Results in chart and table view
                        </div>

                        <div class="panel-body">

                            

                                <?php
                                foreach ($questionData as $key => $value) {
                                    if ($value['type'] == 'radio' || $value['type'] == 'checkbox' || $value['type'] == 'hidden') {
                                        echo '<div class="switchable row">';
                                        echo '<div class="question-chart hidden col-md-12"><div class="panel panel-primary">
                                                <div class="panel-heading"><div class="pull-right"><button class="btn btn-default show-table">Show Table</button></div><div class="clearfix"></div></div><div class="panel-body"><div id="chart_div' . $value['id'] . '""></div></div></div></div>';
                                        $html = '
                                    <div class="col-md-12 question-table ">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading"><div class="pull-left">'
                                                .$value['text'].'</div><div class="pull-right"><button class="btn btn-default show-chart ">Show Chart</button></div><div class="clearfix"></div>'
                                           .' </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <div class="dataTable_wrapper">
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables'.$value['id'].'">
                                                        <thead>
                                                            <tr>
                                                                <th>Answer</th>
                                                                <th>Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
                                                        foreach ($answerData[$value['id']] as $key => $ans) {
                                                            $html .= '<tr><td>'.$ans['text'].'</td><td>'.$ans['count'].'</td></tr>';
                                                        }
                                                        $html .= '</tbody>
                                                    </table>
                                                </div>
                                                <!-- /.table-responsive -->

                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-lg-12 -->

                                </div>';
                                        echo $html;
                                    }
                                    else{
                                        $html = '<div class="panel panel-primary" id="table-format">
                                        <div class="panel-heading">'.$value['text'].'</div>
                                        <div class="panel-body">';
                                         foreach ($answerData[$value['id']] as $key => $ans) {
                                            $html .= '<blockquote>'.$ans['text'].'</blockquote>';
                                        }
                                        $html .= '</div>
                                      </div>';
                                        echo $html;
                                    }
                                }
                                ?>

                        </div>
                    </div>               
                </div>
            </div>
        
    </body>
      <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/scripts.js"></script>
</html>
