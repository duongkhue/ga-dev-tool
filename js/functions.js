/**
 * Created by Coder on 5/9/2015.
 */
var clientid = '439758828010-ta0ar73a378a56413qbne1q4p17mu2f5.apps.googleusercontent.com';
var container = 'embed-api-auth-container';

(function(w,d,s,g,js,fs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
    js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
    js.src='https://apis.google.com/js/platform.js';
    fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));


/**
 * Authorize the user immediately if the user has already granted access.
 * If no access has been created, render an authorize button inside the
 * element with the ID "embed-api-auth-container".
 */
function authorize(){
    gapi.analytics.auth.authorize({
        container: container,
        clientid: clientid
    });
}



/////basic page

function getData(objMetrics, objDimensions, objSort){

    $.ajax({
        url:"https://www.googleapis.com/analytics/v3/metadata/ga/columns?pp=1",
        success:function(data) {
            if(data && data['items'].length > 0 ){
                var metric = [];
                var dimension =[];
                for(i = 0 ; i< data['items'].length; i++){
                    if (data['items'][i]['attributes']['type'] == 'DIMENSION') {
                        dimension.push(data['items'][i]);
                    } else if (data['items'][i]['attributes']['type'] == 'METRIC') {
                        metric.push(data['items'][i]);
                    }
                }
                if(metric && metric.length > 0){
                    var strMetric = '';
                    var strSort = '';
                    strSort += "<option value=''>---select sort---</option>";
                    strMetric += "<option value=''>---select metric---</option>";
                    for(j = 0; j < metric.length; j++){
                        if (objMetrics && objMetrics == metric[j]['id']){
                            strMetric += "<option value='" + metric[j]['id'] + "' selected='selected' >" + metric[j]['id'] + "</option>";
                        } else {
                            strMetric += "<option value='" + metric[j]['id'] + "'>" + metric[j]['id'] + "</option>";
                        }
                        if (objSort && objSort == metric[j]['id']) {
                            strSort += "<option value='" + metric[j]['id'] + "' selected='selected'>" + metric[j]['id'] + "</option>";
                        } else {
                            strSort += "<option value='" + metric[j]['id'] + "'>" + metric[j]['id'] + "</option>";
                        }
                    }

                    $('#metrics').append(strMetric);
                    $('#sort').append(strSort);
                }
                if(dimension && dimension.length > 0) {
                    var strDimension = '';
                    strDimension += "<option value=''>---select dimension---</option>";

                    var arrDimensions = objDimensions.split(',');

                    for (var i = 0; i < arrDimensions.length; i++) {
                        for (var k = 0; k < dimension.length; k++) {
                            if (arrDimensions[i] == dimension[k]['id']) {
                                strDimension += "<option value='" + dimension[k]['id'] + "' selected='selected'>" + dimension[k]['id'] + "</option>";
                            } else {
                                strDimension += "<option value='" + dimension[k]['id'] + "'>" + dimension[k]['id'] + "</option>";
                            }
                        }
                    }
                    $('#dimensions').append(strDimension);
                }

            }
        },
        error: function(data) {
            console.log("error: " + data);
        }
    });
}

function loadChartBasic(obj){
    var dataChart = new gapi.analytics.googleCharts.DataChart({
        query: {
            metrics: obj['metrics'],
            dimensions: obj['dimensions'],
            'start-date': obj['startDate'],
            'end-date': obj['endDate']
        },
        chart: {
            container: 'chart-container',
            type: 'LINE',
            options: {
                width: '100%'
            }
        }
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
     * Render the dataChart on the page whenever a new view is selected.
     */
    viewSelector.on('change', function(ids) {

        //document.getElementById('ids').value = ids;
        dataChart.set({query: {ids: ids}}).execute();

    });
}

function loadChartMultiDate(obj){
    /**
     * Create a new DataChart instance for pageviews over the past 7 days.
     * It will be rendered inside an element with the id "chart-1-container".
     */
    var dataChart1 = new gapi.analytics.googleCharts.DataChart({
        query: {
            metrics: obj['metrics'],
            dimensions: obj['dimensions'],
            'start-date': obj['startDate'],
            'end-date': obj['endDate']
        },
        chart: {
            container: 'chart-1-container',
            type: 'LINE',
            options: {
                width: '100%'
            }
        }
    });

    //begin get 8 days ago and 15 days ago
    var eightDaysAgo = new Date(new Date(obj['startDate']).getFullYear(), new Date(obj['startDate']).getMonth(), new Date(obj['startDate']).getDate() - 8);
    var fifteenDaysAgo = new Date(new Date(obj['startDate']).getFullYear(), new Date(obj['startDate']).getMonth(), new Date(obj['startDate']).getDate() - 15);
    //format number month and day
    var monthEightDaysAgo = ((new Date(eightDaysAgo).getMonth() + 1) < 10 ? '0' : '') + (new Date(eightDaysAgo).getMonth() + 1);
    var dayEightDaysAgo = (new Date(eightDaysAgo).getDate() < 10 ? '0' : '') + new Date(eightDaysAgo).getDate();
    var monthFifteenDaysAgo = ((new Date(fifteenDaysAgo).getMonth() + 1) < 10 ? '0' : '') + (new Date(fifteenDaysAgo).getMonth() + 1);
    var dayFifteenDaysAgo = (new Date(fifteenDaysAgo).getDate() < 10 ? '0' : '') + new Date(fifteenDaysAgo).getDate();

    var strEightDaysAgo = '';
    var strFifteenDaysAgo = '';
    strEightDaysAgo += new Date(eightDaysAgo).getFullYear() + '-' + monthEightDaysAgo + '-' + dayEightDaysAgo;
    strFifteenDaysAgo += new Date(fifteenDaysAgo).getFullYear() + '-' + monthFifteenDaysAgo + '-' + dayFifteenDaysAgo;
    //end get 8 days ago and 15 days ago

    /**
     * Create a new DataChart instance for pageviews over the 7 days prior
     * to the past 7 days
     * It will be rendered inside an element with the id "chart-2-container".
     */
    var dataChart2 = new gapi.analytics.googleCharts.DataChart({
        query: {
            metrics: obj['metrics'],
            dimensions: obj['dimensions'],
            'start-date': strFifteenDaysAgo,
            'end-date': strEightDaysAgo
        },
        chart: {
            container: 'chart-2-container',
            type: 'LINE',
            options: {
                width: '100%'
            }
        }
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
     * Render both dataCharts on the page whenever a new view is selected.
     */
    viewSelector.on('viewChange', function(data) {
        dataChart1.set({query: {ids: data.ids}}).execute();
        dataChart2.set({query: {ids: data.ids}}).execute();
    });
}

function loadChartMultiView(obj){
    /**
     * Create a ViewSelector for the first view to be rendered inside of an
     * element with the id "view-selector-1-container".
     */
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
        container: 'view-selector-container'
    })
        .execute();

    /**
     * Create the first DataChart for top countries over the past 30 days.
     * It will be rendered inside an element with the id "chart-1-container".
     */
    var dataChart1 = new gapi.analytics.googleCharts.DataChart({
        query: {
            metrics: obj['metrics'],
            dimensions: obj['dimensions'],
            'start-date': obj['startDate'],
            'end-date': obj['endDate'],
            'max-results': obj['maxResult'],
            sort: "-" + obj['sort']
        },
        chart: {
            container: 'chart-1-container',
            type: 'PIE',
            options: {
                width: '100%'
            }
        }
    });
    /**
     * Update the first dataChart when the first view selecter is changed.
     */
    viewSelector.on('viewChange', function(data) {
        dataChart1.set({query: {ids: data.ids}}).execute();
    });
}


function loadInteractiveChart(obj){
    /**
     * Create a new ViewSelector instance to be rendered inside of an
     * element with the id "view-selector-container".
     */
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
        container: 'view-selector-container'
    })
        .execute();

    /**
     * Create a table chart showing top browsers for users to interact with.
     * Clicking on a row in the table will update a second timeline chart with
     * data from the selected browser.
     */
    var mainChart = new gapi.analytics.googleCharts.DataChart({
        query: {
            'dimensions': obj['dimensions'],
            'metrics': obj['metrics'],
            'sort': '-' + obj['sort'],
            'max-results': obj['maxResult']
        },
        chart: {
            type: 'TABLE',
            container: 'main-chart-container',
            options: {
                width: '100%'
            }
        }
    });


    /**
     * Create a timeline chart showing sessions over time for the browser the
     * user selected in the main chart.
     */
    var breakdownChart = new gapi.analytics.googleCharts.DataChart({
        query: {
            'dimensions': obj['dimensions'],
            'metrics': obj['metrics'],
            'start-date': obj['startDate'],
            'end-date': obj['endDate']
        },
        chart: {
            type: 'LINE',
            container: 'breakdown-chart-container',
            options: {
                width: '100%'
            }
        }
    });


    /**
     * Store a refernce to the row click listener variable so it can be
     * removed later to prevent leaking memory when the chart instance is
     * replaced.
     */
    var mainChartRowClickListener;


    /**
     * Update both charts whenever the selected view changes.
     */
    viewSelector.on('viewChange', function(data) {
        var options = {query: {ids: data.ids}};

        // Clean up any event listeners registered on the main chart before
        // rendering a new one.
        if (mainChartRowClickListener) {
            google.visualization.events.removeListener(mainChartRowClickListener);
        }

        mainChart.set(options).execute();
        breakdownChart.set(options);

        // Only render the breakdown chart if a browser filter has been set.
        if (breakdownChart.get().query.filters) breakdownChart.execute();
    });


    /**
     * Each time the main chart is rendered, add an event listener to it so
     * that when the user clicks on a row, the line chart is updated with
     * the data from the browser in the clicked row.
     */
    mainChart.on('success', function(response) {

        var chart = response.chart;
        var dataTable = response.dataTable;

        // Store a reference to this listener so it can be cleaned up later.
        mainChartRowClickListener = google.visualization.events
            .addListener(chart, 'select', function(event) {

                // When you unselect a row, the "select" event still fires
                // but the selection is empty. Ignore that case.
                if (!chart.getSelection().length) return;

                var row =  chart.getSelection()[0].row;
                var browser =  dataTable.getValue(row, 0);
                var options = {
                    query: {
                        filters: 'ga:browser==' + browser
                    },
                    chart: {
                        options: {
                            title: browser
                        }
                    }
                };

                breakdownChart.set(options).execute();
            });
    });
}

/**
 * Draw the a chart.js line chart with data from the specified view that
 * overlays session data for the current week over session data for the
 * previous week.
 */
function renderWeekOverWeekChart(obj) {

    // Adjust `now` to experiment with different days, for testing only...
    var now = moment(); // .subtract(3, 'day');
    console.log(obj['dimensions']);
    var thisWeek = query({
        'ids': obj['ids'],
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': obj['metrics'],
        'start-date': obj['startDate'],
        'end-date': obj['endDate']
    });

    var lastWeek = query({
        'ids': obj['ids'],
        'dimensions': 'ga:date,ga:nthDay',
        'metrics': obj['metrics'],
        'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
            .format('YYYY-MM-DD'),
        'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
            .format('YYYY-MM-DD')
    });

    Promise.all([thisWeek, lastWeek]).then(function(results) {

        var data1 = results[0].rows.map(function(row) { return +row[2]; });
        var data2 = results[1].rows.map(function(row) { return +row[2]; });
        var labels = results[1].rows.map(function(row) { return +row[0]; });

        labels = labels.map(function(label) {
            return moment(label, 'YYYYMMDD').format('ddd');
        });

        var data = {
            labels : labels,
            datasets : [
                {
                    label: 'Last Week',
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#fff",
                    data : data2
                },
                {
                    label: 'This Week',
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff",
                    data : data1
                }
            ]
        };

        new Chart(makeCanvas('chart-1-container')).Line(data);
        generateLegend('legend-1-container', data.datasets);
    });
}




/**
 * Draw the a chart.js bar chart with data from the specified view that
 * overlays session data for the current year over session data for the
 * previous year, grouped by month.
 */
function renderYearOverYearChart(ids) {

    // Adjust `now` to experiment with different days, for testing only...
    var now = moment(); // .subtract(3, 'day');

    var thisYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
        'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastYear = query({
        'ids': ids,
        'dimensions': 'ga:month,ga:nthMonth',
        'metrics': 'ga:users',
        'start-date': moment(now).subtract(1, 'year').date(1).month(0)
            .format('YYYY-MM-DD'),
        'end-date': moment(now).date(1).month(0).subtract(1, 'day')
            .format('YYYY-MM-DD')
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
        var data1 = results[0].rows.map(function(row) { return +row[2]; });
        var data2 = results[1].rows.map(function(row) { return +row[2]; });
        var labels = ['Jan','Feb','Mar','Apr','May','Jun',
            'Jul','Aug','Sep','Oct','Nov','Dec'];

        // Ensure the data arrays are at least as long as the labels array.
        // Chart.js bar charts don't (yet) accept sparse datasets.
        for (var i = 0, len = labels.length; i < len; i++) {
            if (data1[i] === undefined) data1[i] = null;
            if (data2[i] === undefined) data2[i] = null;
        }

        var data = {
            labels : labels,
            datasets : [
                {
                    label: 'Last Year',
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    data : data2
                },
                {
                    label: 'This Year',
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    data : data1
                }
            ]
        };

        new Chart(makeCanvas('chart-2-container')).Bar(data);
        generateLegend('legend-2-container', data.datasets);
    })
        .catch(function(err) {
            console.error(err.stack);
        })
}


/**
 * Draw the a chart.js doughnut chart with data from the specified view that
 * show the top 5 browsers over the past seven days.
 */
function renderTopBrowsersChart(ids) {

    query({
        'ids': ids,
        'dimensions': 'ga:browser',
        'metrics': 'ga:pageviews',
        'sort': '-ga:pageviews',
        'max-results': 5
    })
        .then(function(response) {

            var data = [];
            var colors = ['#4D5360','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];

            response.rows.forEach(function(row, i) {
                data.push({ value: +row[1], color: colors[i], label: row[0] });
            });

            new Chart(makeCanvas('chart-3-container')).Doughnut(data);
            generateLegend('legend-3-container', data);
        });
}


/**
 * Draw the a chart.js doughnut chart with data from the specified view that
 * compares sessions from mobile, desktop, and tablet over the past seven
 * days.
 */
function renderTopCountriesChart(ids) {
    query({
        'ids': ids,
        'dimensions': 'ga:country',
        'metrics': 'ga:sessions',
        'sort': '-ga:sessions',
        'max-results': 5
    })
        .then(function(response) {

            var data = [];
            var colors = ['#4D5360','#949FB1','#D4CCC5','#E2EAE9','#F7464A'];

            response.rows.forEach(function(row, i) {
                data.push({
                    label: row[0],
                    value: +row[1],
                    color: colors[i]
                });
            });

            new Chart(makeCanvas('chart-4-container')).Doughnut(data);
            generateLegend('legend-4-container', data);
        });
}


/**
 * Create a visual legend inside the specified element based off of a
 * Chart.js dataset.
 * @param {string} id The id attribute of the element to host the legend.
 * @param {Array.<Object>} items A list of labels and colors for the legend.
 */
function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
        var color = item.color || item.fillColor;
        var label = item.label;
        return '<li><i style="background:' + color + '"></i>' + label + '</li>';
    }).join('');
}

/**
 * Extend the Embed APIs `gapi.analytics.report.Data` component to
 * return a promise the is fulfilled with the value returned by the API.
 * @param {Object} params The request parameters.
 * @return {Promise} A promise.
 */
function query(params) {
    return new Promise(function(resolve, reject) {
        var data = new gapi.analytics.report.Data({query: params});
        data.once('success', function(response) { resolve(response); })
            .once('error', function(response) { reject(response); })
            .execute();
    });
}


/**
 * Create a new canvas inside the specified element. Set it to be the width
 * and height of its container.
 * @param {string} id The id attribute of the element to host the canvas.
 * @return {RenderingContext} The 2D canvas context.
 */
function makeCanvas(id) {
    var container = document.getElementById(id);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    //container.innerHTML = "";
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;
    container.appendChild(canvas);

    return ctx;
}

//Create a date object using the current time
var nowStartDate = new Date();
var nowEndDate = new Date();
var startDate = nowStartDate.setDate(nowStartDate.getDate()-7);
var endDate = nowEndDate.setDate(nowEndDate.getDate()-1);
var strStartDate = '';
var strEndDate = '';
//format number month and day
var currentMonthStartDate = ((new Date(startDate).getMonth() + 1) < 10 ? '0' : '') + (new Date(startDate).getMonth() + 1);
var currentDayStartDate = (new Date(startDate).getDate() < 10 ? '0' : '') + new Date(startDate).getDate();
var currentMonthEndDate = ((new Date(endDate).getMonth() + 1) < 10 ? '0' : '') + (new Date(endDate).getMonth() + 1);
var currentDayEndDate = (new Date(endDate).getDate() < 10 ? '0' : '') + new Date(endDate).getDate();

strStartDate += new Date(startDate).getFullYear() + '-' + currentMonthStartDate + '-' + currentDayStartDate;
strEndDate += new Date(endDate).getFullYear() + '-' + currentMonthEndDate + '-' + currentDayEndDate;
$('#startDate').val(strStartDate);
$('#endDate').val(strEndDate);
