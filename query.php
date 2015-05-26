<!--begin search-->
<h3 class="H3--underline">
    Set query parameters
</h3>
<div>
    <div class="FormControl FormControl--inline">
        <span class="blockMetrics">
            <label class="mg-label">Metrics</label>
            <select name="metrics" id="metrics"></select>
        </span>
        <span class="blockDimensions">
            <label class="mg-label">Dimensions</label>
            <select name="dimensions" id="dimensions"></select>
        </span>
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
        <span class="blockMaxResult">
            <label class="mg-label">Max result</label>
            <input type="text" name="maxResult" class="maxResult" id="maxResult" value="6">
        </span>
        <span class="blockSort">
            <label class="mg-label">Sort</label>
            <select name="sort" id="sort"></select>
        </span>

    </div>
    <div class="FormControl FormControl--inline">
        <button class="Button Button--action" id="runQuery">Run Query</button>
    </div>
</div>
<!--end search-->