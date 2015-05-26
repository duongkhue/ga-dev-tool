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
        <!-- Step 1: Create the containing elements. -->
        <header class="Dashboard-header">
            <!--<div id="active-users-container" style="width:20%;float:right;"></div>-->

            <div id="view-selector-container"></div>
            <input type="hidden" name="ids" id="ids">
        </header>

        <ul class="FlexGrid FlexGrid--halves">
            <li class="FlexGrid-item">
                <div class="Chartjs">
                    <header class="Titles">
                        <h1 class="Titles-main">Top Countries</h1>
                        <div class="Titles-sub">By sessions</div>
                        <div class="FormControl FormControl--inline">
                            <span class="blockMetrics">
                                <label class="mg-label">Metrics</label>
                                <select name="metrics" id="metrics"></select>
                            </span>
                        </div>
                        <div class="FormControl FormControl--inline">
                            <span class="blockDimensions">
                                <label class="mg-label">Dimensions</label>
                                <select name="dimensions" id="dimensions" multiple></select>
                            </span>
                        </div>
                        <div class="FormControl FormControl--inline">
                            <span class="blockStartDate">
                                <label class="mg-label">Start date</label>
                                <div id="datetimepickerStartDate" class="input-append date">
                                    <!--<input type="text" data-format="yyyy-MM-dd"  id="startDate" value="30daysAgo">-->
                                    <input type="text" data-format="yyyy-MM-dd"  id="startDate">
                                        <span class="add-on">
                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                        </span>
                                </div>

                                <script type="text/javascript">

                                    $('#datetimepickerStartDate').datetimepicker({
                                        pickTime: false,
                                        setDate: new Date()
                                    });
                                </script>
                            </span>
                            <span class="blockEndDate">
                                <label class="mg-label">End date</label>
                                <div id="datetimepickerEndDate" class="input-append date">
                                    <input type="text" data-format="yyyy-MM-dd" id="endDate">
                                                    <span class="add-on">
                                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                                                    </span>
                                </div>

                                <script type="text/javascript">
                                    $('#datetimepickerEndDate').datetimepicker({
                                        pickTime: false
                                    });
                                </script>
                            </span>
                        </div>

                        <div class="FormControl FormControl--inline">
                            <button class="Button Button--action" id="runQuery">Run Query</button>
                        </div>
                    </header>
                    <div class="Chartjs-figure" id="chart-1-container"></div>
                    <div class="Chartjs-legend" id="legend-1-container"></div>
                </div>
            </li>
            <li class="FlexGrid-item">
                <div class="Chartjs">
                    <header class="Titles">
                        <h1 class="Titles-main">Top Countries</h1>
                        <div class="Titles-sub">By sessions</div>
                    </header>
                    <div class="Chartjs-figure" id="chart-2-container"></div>
                    <div class="Chartjs-legend" id="legend-2-container"></div>
                </div>
            </li>
            <li class="FlexGrid-item">
                <div class="Chartjs">
                    <header class="Titles">
                        <h1 class="Titles-main">Top Countries</h1>
                        <div class="Titles-sub">By sessions</div>
                    </header>
                    <div class="Chartjs-figure" id="chart-3-container"></div>
                    <div class="Chartjs-legend" id="legend-3-container"></div>
                </div>
            </li>
            <li class="FlexGrid-item">
                <div class="Chartjs">
                    <header class="Titles">
                        <h1 class="Titles-main">Top Countries</h1>
                        <div class="Titles-sub">By sessions</div>
                    </header>
                    <div class="Chartjs-figure" id="chart-4-container"></div>
                    <div class="Chartjs-legend" id="legend-4-container"></div>
                </div>
            </li>
        </ul>
    </div>
</div>

<script src="js/functions.js"></script>

<!-- This demo uses the Chart.js graphing library and Moment.js to do date
     formatting and manipulation. -->
<script src="js/Chart.min.js"></script>
<script src="js/moment.min.js"></script>

<!-- Include the ViewSelector2 component script. -->
<script src="js/view-selector2.js"></script>

<!-- Include the DateRangeSelector component script. -->
<script src="js/date-range-selector.js"></script>

<!-- Include the ActiveUsers component script. -->
<script src="js/active-users.js"></script>

<script>
    $('.blockMetrics').css('display','block');
// == NOTE ==
// This code uses ES6 promises. If you want to use this code in a browser
// that doesn't supporting promises natively, you'll have to include a polyfill.

gapi.analytics.ready(function() {

    authorize();


    /**
     * Create a new ActiveUsers instance to be rendered inside of an
     * element with the id "active-users-container" and poll for changes every
     * five seconds.
     */
    var activeUsers = new gapi.analytics.ext.ActiveUsers({
        container: 'active-users-container',
        pollingInterval: 5
    });


    /**
     * Add CSS animation to visually show the when users come and go.
     */
    activeUsers.once('success', function() {
        var element = this.container.firstChild;
        var timeout;

        this.on('change', function(data) {
            var element = this.container.firstChild;
            var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
            element.className += (' ' + animationClass);

            clearTimeout(timeout);
            timeout = setTimeout(function() {
                element.className =
                    element.className.replace(/ is-(increasing|decreasing)/g, '');
            }, 3000);
        });
    });


    /**
     * Create a new ViewSelector2 instance to be rendered inside of an
     * element with the id "view-selector-container".
     */
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
        container: 'view-selector-container'
    })
        .execute();


    /**
     * Update the activeUsers component, the Chartjs charts, and the dashboard
     * title whenever the user changes the view.
     */
    viewSelector.on('viewChange', function(data) {

        $('#ids').val(data.ids);
        var arr = [];
        var ids = document.getElementById('ids').value.toString();
        var metrics = document.getElementById('metrics').value.toString();
        var dimensions = document.getElementById('dimensions').value.toString();
        var startDate = document.getElementById('startDate').value.toString();
        var endDate = document.getElementById('endDate').value.toString();
        arr = {
            ids : data.ids,
            metrics: metrics,
            dimensions: dimensions,
            startDate: startDate,
            endDate: endDate
        };
        // Start tracking active users for this view.
        //activeUsers.set(data).execute();

        // Render all the of charts for this view.
        renderWeekOverWeekChart(arr);
        renderYearOverYearChart(data.ids);
        renderTopBrowsersChart(data.ids);
        renderTopCountriesChart(data.ids);
    });

    $('#runQuery').on('click', function(){
        var arr = [];
        var ids = document.getElementById('ids').value.toString();
        var metrics = document.getElementById('metrics').value.toString();
        var dimensions = document.getElementById('dimensions');
        var startDate = document.getElementById('startDate').value.toString();
        var endDate = document.getElementById('endDate').value.toString();
        var strDimensions = '';
        for (var i = 0; i < dimensions.options.length; i++) {
            if(dimensions.options[i].selected ==true){
                if (strDimensions){
                    strDimensions += ',';
                }
                strDimensions += dimensions.options[i].value;
            }
        }
        arr = {
            ids : ids,
            metrics: metrics,
            dimensions: strDimensions,
            startDate: startDate,
            endDate: endDate
        };
        renderWeekOverWeekChart(arr);

    });

    // Set some global Chart.js defaults.
    Chart.defaults.global.animationSteps = 60;
    Chart.defaults.global.animationEasing = 'easeInOutQuart';
    Chart.defaults.global.responsive = true;
    Chart.defaults.global.maintainAspectRatio = false;

});
getData('ga:sessions', 'ga:date,ga:nthDay','');
</script>
</body>
</html>
