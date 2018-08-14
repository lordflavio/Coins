@extends('layouts.system')

@section('content')

    <section class="content-header">
        <h1>
            Euro
            <small>Cotações</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Euro</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua-active">
                    <span class="info-box-icon"><i class="fa fa-eur"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Compra</span>
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
                    <span class="info-box-icon"><i class="fa fa-eur"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Venda</span>
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

            <div class="col-md-8">
                <div class="box box-success">
                    <div style="margin-top: 10px" id="div_g" class="chart"></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header ">
                        <h3 class="box-title">Últimos 7 dias</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">Dia</th>
                                <th>Compra</th>
                                <th>Venda</th>
                            </tr>
                            @for($i = 0; $i < count($week['$']); $i++)
                                <?php  $ex = explode("-",$week['date'][$i]); ?>
                                <tr>
                                    <td>{{$ex[2]}}</td>
                                    @if($i != count($week['$']) - 1 )
                                        @if($week['$'][$i] > $week['$'][$i + 1])
                                            <td style="color: green">R$ {{$week['$'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                        @else
                                            <td style="color: red">R$ {{$week['$'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                        @endif

                                        @if($week['&'][$i] > $week['&'][$i + 1])
                                            <td style="color: green">R$ {{$week['&'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                        @else
                                            <td style="color: red">R$ {{$week['&'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                        @endif

                                    @else
                                        <td>R$ {{$week['$'][$i]}}</td>
                                        <td>R$ {{$week['&'][$i]}}</td>
                                    @endif


                                </tr>
                            @endfor
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">

                <a href="#"><button class="btn-lg btn-primary" data-toggle="modal" data-target="#myModal"> Gerar previsões <i class="fa fa-cog" aria-hidden="true"></i></button></a>

            </div>
        </div>

    </section>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-center">
            <div class="modal-dialog .modal-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><h3 class="text-center">Previsões do dolar</h3> </h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <form action="{{route('prediction')}}" method="POST">
                        {{ csrf_field() }}
                        <input style="display: none" type="text" name="coins" value="Euro">
                        <div class="modal-body">
                            <!-- /.form-group -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dias</label>
                                    <select class="form-control" name="days" style="width: 100%;">
                                        <option value="5" selected="selected">5</option>
                                        <option value="10" > 10 </option>
                                        <option value="15" > 15 </option>
                                        {{--<option value="20" > 20 </option>--}}
                                        {{--<option value="30" > 30  </option>--}}
                                        {{--<option value="45" > 45 </option>--}}
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center" style="color: #0b93d5">Cada dia corresponde a uma previsão de valor futura </h5>
                            </div><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
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