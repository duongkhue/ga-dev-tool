<!DOCTYPE html>
<html>
<head>
    <title>Embed API Demo</title>
    <link href="css/main.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!--begin datetime picker-->
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
          href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
    <!--end datetime picker-->
</head>
<body class="Site is-authorized">
<?php include('menu_left.php');?>
<div class="Site-main">
    <div class="Content">
        <!-- Step 1: Create the containing elements. -->
        <header class="Dashboard-header">
            <!--<div id="active-users-container" style="width:20%;float:right;"></div>-->
            <h3 class="H3--underline">
                Select a view
            </h3>
            <div id="view-selector-container"></div>
            <!--begin search-->
            <?php include('query.php');?>
            <!--end search-->
        </header>
        <div class="Dashboard Dashboard--full">
            <ul class="FlexGrid FlexGrid--halves">
                <li class="FlexGrid-item">
                    <div class="Chartjs">
                        <header class="Titles">
                            <h1 class="Titles-main">Pageview</h1>
                            <div class="Titles-sub">This week</div>
                        </header>
                        <div id="chart-1-container"></div>
                        <div class="Chartjs-legend" id="legend-1-container"></div>
                    </div>
                </li>
                <li class="FlexGrid-item">
                    <div class="Chartjs">
                        <header class="Titles">
                            <h1 class="Titles-main">Pageview</h1>
                            <div class="Titles-sub">Last week</div>
                        </header>
                        <div id="chart-2-container"></div>
                        <div class="Chartjs-legend" id="legend-2-container"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script src="js/functions.js"></script>

<!-- Step 2: Load the library. -->

<!-- Include the ViewSelector2 component script. -->
<script src="js/view-selector2.js"></script>


<script>

    $('.blockMetrics').css('display','block');
    //$().datepicker('setDate', new Date());
    gapi.analytics.ready(function() {

        authorize();
        var startDate = document.getElementById('startDate').value.toString();
        var endDate = document.getElementById('endDate').value.toString();

        var arr =[]
        arr = {
            metrics: 'ga:pageviews',
            dimensions: 'ga:date',
            startDate: startDate,
            endDate: endDate

        };
        loadChartMultiDate(arr);

        document.getElementById('runQuery').onclick = function(event){
            var arr=[];
            var metrics = document.getElementById('metrics').value.toString();
            var dimensions = document.getElementById('dimensions').value.toString();
            var startDate = document.getElementById('startDate').value.toString();
            var endDate = document.getElementById('endDate').value.toString();

            arr = {
                metrics: metrics,
                dimensions: dimensions,
                startDate : startDate,
                endDate: endDate
            };
            loadChartMultiDate(arr);
        }
        //get metrics and dimension
        getData('ga:pageviews', 'ga:date');
    });
</script>
</body>
</html>

