<!DOCTYPE html>
<html>
<head>
    <title>Embed API Demo</title>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!--begin datetime picker-->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
    <!--end datetime picker-->
</head>
<body class="Site is-authorized">
<?php include('menu_left.php');?>
<div class="Site-main">
    <div class="Content">
        <header class="Dashboard-header">
            <h3 class="H3--underline">
                Select a view
            </h3>
            <div id="view-selector-container"></div>
            <?php include('query.php');?>
        </header>
        <div class="Dashboard">
            <div id="chart-container"></div>
        </div>
    </div>
</div>

<script src="js/functions.js"></script>
<script src="js/view-selector2.js"></script>
<script>
    $('.blockMetrics').css('display','block');
gapi.analytics.ready(function() {

    authorize();
    var startDate = document.getElementById('startDate').value.toString();
    var endDate = document.getElementById('endDate').value.toString();
    var arr=[];
    arr={
        startDate : startDate,
        endDate : endDate,
        metrics : 'ga:sessions',
        dimensions : 'ga:date'
    };
    loadChartBasic(arr);

    document.getElementById('runQuery').onclick = function(event){

        var arr = [];
        var startDate = document.getElementById('startDate').value.toString();
        var endDate = document.getElementById('endDate').value.toString();
        var metrics = document.getElementById('metrics').value.toString();
        var dimensions = document.getElementById('dimensions').value.toString();

        arr = {
            startDate:startDate,
            endDate: endDate,
            metrics:metrics,
            dimensions: dimensions
        };
        loadChartBasic(arr);
    }

    getData('ga:sessions', 'ga:date','');
});
</script>
</body>
</html>

