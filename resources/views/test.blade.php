@extends('layouts.system')

@section('content')
    <br>
    <div class="col-md-11">
        <div class="box box-success">
            <div style="margin-top: 10px" id="div_g" class="chart"></div>
        </div>
    </div>

    <style>
        .chart {
            width: auto;
            min-height: 300px;
        }
        .row {
            margin:0 !important;
        }
    </style>
@endsection

@push('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

                var jdate = <?php echo $json_data; ?>;

                var data = "";

                for(i = 0; i < jdate["$"].length; i++){
                    var x = new Date(0);
                    x.setUTCSeconds(jdate['date'][i]);
                    data = data + x +","+ jdate['$'][i] +","+jdate['&'][i]+ "\n";
                }

        new Dygraph(document.getElementById("div_g"), data, {
            labels: [ "Date", "Real", "Previsto" ],
                underlayCallback: function(canvas, area, g) {
                function highlight_period(x_start, x_end) {
                    var canvas_left_x = g.toDomXCoord(x_start);
                    var canvas_right_x = g.toDomXCoord(x_end);
                    var canvas_width = canvas_right_x - canvas_left_x;
                    canvas.fillRect(canvas_left_x, area.y, canvas_width, area.h);
                }

                    var min_data_x = g.getValue(0,0);
                    var max_data_x = g.getValue(g.numRows()-1,0);

                    // get day of week
                    var d = new Date(min_data_x);
                    var dow = d.getUTCDay();},

            title: 'Valor Real do Bitcoins vs. Previsto pelo Sistema'

        });
            }
    );
</script>

@endpush