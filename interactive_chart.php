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
<main class="Site-main">
    <div class="Content">
        <header class="Dashboard-header">
            <h3 class="H3--underline">
                Select a view
            </h3>
            <div id="view-selector-container"></div>
            <?php include('query.php');?>
        </header>
    <!-- Step 1: Create thehe containing elements. -->
        <ul class="FlexGrid FlexGrid--halves">
            <li class="FlexGrid-item">
                <div class="Chartjs">
                    <div id="main-chart-container"></div>
                    <div id="breakdown-chart-container"></div>
                </div>
            </li>
        </ul>
    </div>
</main>
<script src="js/functions.js"></script>
<script src="js/view-selector2.js"></script>
<!-- Step 2: Load the library. -->

<script>
    $('.blockMaxResult').css('display','block');
    gapi.analytics.ready(function() {

        authorize();

        var arr = [];
        var startDate = document.getElementById('startDate').value.toString();
        var endDate = document.getElementById('endDate').value.toString();
        arr = {
            startDate: startDate,
            endDate: endDate,
            metrics: 'ga:sessions',
            dimensions: 'ga:date',
            maxResult: '6',
            sort: 'ga:sessions'
        };
        loadInteractiveChart(arr);

        document.getElementById('runQuery').onclick = function(event){

            var arr = [];
            var startDate = document.getElementById('startDate').value.toString();
            var endDate = document.getElementById('endDate').value.toString();
            var dimensions = document.getElementById('dimensions').value.toString();
            var maxResult = document.getElementById('maxResult').value.toString();

            arr = {
                startDate: startDate,
                endDate: endDate,
                metrics: 'ga:sessions',
                dimensions: dimensions,
                maxResult: maxResult,
                sort: 'ga:sessions'
            };
            loadInteractiveChart(arr);
        }

        getData('ga:sessions', 'ga:date', 'ga:sessions');

    });


</script>

</body>
</html>
