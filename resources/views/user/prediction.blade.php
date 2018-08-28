@extends('layouts.system')

@section('content')<br>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">A Previsão do {{$coins}} </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px">Dia</th>
                            <th class="text-center">Previsão</th>
                        </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < count($week['$']); $i++)
                                <tr>
                                    <td class="text-center">{{$week['date'][$i]}}</td>
                                    <td class="text-center">R$ {{$week['$'][$i]}}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        @if(count($cotacoes) > 1)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua-active">
                <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Compra Hoje </span>
                    <span class="info-box-number">R$ {{$cotacoes[1]}}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">

                        </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green-active">
                <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Venda Hoje </span>
                    <span class="info-box-number">R$ {{$cotacoes[0]}}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                        </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        @else
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua-active">
                    <span class="info-box-icon"><i class="fa fa-dollar"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"> 1 Bitcoins </span>
                        <span class="info-box-number">R$ {{$cotacoes[0]}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">

                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        @endif

        <div class="col-md-8">
            <div class="box box-success">
                <div style="margin-top: 10px" id="div_g" class="chart"></div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">

            <a href="/list/{{$day}}/{{$coins}}/{{'asfasdf'}}"><button class="btn-lg btn-primary"> Baixar Previsão PDF <i class="fa fa-download" aria-hidden="true"></i></button></a>

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

</section>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

                var jdate = <?php echo $json_data; ?>;

                var data = "";

                for(i = 0; i < jdate["$"].length; i++){
                    data = data + jdate['date'][i]+","+ jdate['$'][i] + "\n";
                }

                new Dygraph(
                        document.getElementById("div_g"),
                        data,
                        {
                            labels: ['Data','R$'],
                            underlayCallback: function(canvas, area, g) {

                                canvas.fillStyle = "rgba(255, 255, 102, 1.0)";

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
                                var dow = d.getUTCDay();

//                                var w = min_data_x;
//                                // starting on Sunday is a special case
//                                if (dow === 0) {
//                                    highlight_period(w,w+12*3600*1000);
//                                }
//                                // find first saturday
//                                while (dow != 6) {
//                                    w += 24*3600*1000;
//                                    d = new Date(w);
//                                    dow = d.getUTCDay();
//                                }
//                                // shift back 1/2 day to center highlight around the point for the day
//                                w -= 12*3600*1000;
//                                while (w < max_data_x) {
//                                    var start_x_highlight = w;
//                                    var end_x_highlight = w + 2*24*3600*1000;
//                                    // make sure we don't try to plot outside the graph
//                                    if (start_x_highlight < min_data_x) {
//                                        start_x_highlight = min_data_x;
//                                    }
//                                    if (end_x_highlight > max_data_x) {
//                                        end_x_highlight = max_data_x;
//                                    }
//                                    highlight_period(start_x_highlight,end_x_highlight);
//                                    // calculate start of highlight for next Saturday
//                                    w += 7*24*3600*1000;
//                                }
                            }
                        });
            }
    );
</script>
@endpush