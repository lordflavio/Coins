@extends('layouts.system')

@section('content')

    <section class="content-header">
        <h1>
            Bitcoins
            <small>Cotações</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bitcoins</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green-active">
                    <span class="info-box-icon"><i class="fa fa-btc"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"> Open </span>
                        <span class="info-box-number">R$ {{round( $coinsToday['open'][1] * $dolar,2)}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            {{date('d/m/Y', $coinsToday['date'][1])}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-aqua-active">
                    <span class="info-box-icon"><i class="fa fa-btc"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"> Close </span>
                        <span class="info-box-number">R$ {{round( $coinsToday['close'][1] * $dolar,2)}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            {{date('d/m/Y', $coinsToday['date'][1])}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box bg-green-active">
                    <span class="info-box-icon"><i class="fa fa-btc"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text"> Volume </span>
                        <span class="info-box-number">{{$coinsToday['volumeto'][1]}}</span>

                        <div class="progress">
                            <div class="progress-bar" style="width: 70%"></div>
                        </div>
                        <span class="progress-description">
                            {{date('d/m/Y', $coinsToday['date'][1])}}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-12">
                <div class="btn-group">
                    <a type="button" class="btn btn-app" href="/btc/day"><i class="fa fa-sun-o" aria-hidden="true"></i>Dias</a>
                    <a type="button" class="btn btn-app" href="/btc/hour"><i class="fa fa-hourglass-end" aria-hidden="true"></i>Horas</a>
                    <a type="button" class="btn btn-app" href="/btc/minute"><i class="fa fa-hourglass-half" aria-hidden="true"></i>Minutos</a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box box-success">
                    <div style="margin-top: 10px" id="div_g" class="chart"></div>
                </div>
            </div>

            @if($type == 0)
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
                                <th><i class="fa fa-btc"></i> 1 Bitcoins </th>
                            </tr>
                            @for($i = 0; $i < count($week['$']); $i++)
                                <?php  $ex = explode("-",$week['date'][$i]);?>
                                <tr>
                                    <td>{{$ex[2]}}</td>
                                    @if($i != count($week['$']) - 1 )
                                        @if($week['$'][$i] > $week['$'][$i + 1])
                                            <td style="color: green">R$ {{$week['$'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                        @else
                                            <td style="color: red">R$ {{$week['$'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                        @endif

                                    @else
                                        <td>R$ {{$week['$'][$i]}}</td>
                                    @endif
                                </tr>
                            @endfor
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            @elseif($type == 1)
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header ">
                            <h3 class="box-title">Últimos 7 horas </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 50px">Horas</th>
                                        <th><i class="fa fa-btc"></i> 1 Bitcoins </th>
                                    </tr>
                                    @for($i = 0; $i < count($week['$']); $i++)
                                        <?php  $ex = explode(":",$week['time'][$i]);?>
                                        <tr>
                                            <td>{{$week['time'][$i]}}</td>
                                            @if($i != count($week['$']) - 1 )
                                                @if($week['$'][$i] > $week['$'][$i + 1])
                                                    <td style="color: green">R$ {{$week['$'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="color: red">R$ {{$week['$'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                                @endif

                                            @else
                                                <td>R$ {{$week['$'][$i]}}</td>
                                            @endif
                                        </tr>
                                    @endfor
                                </table>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            @elseif($type == 2)
                <div class="col-md-4">
                    <div class="box box-success">
                        <div class="box-header ">
                            <h3 class="box-title">Últimos 7 Minutos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tr>
                                        <th style="width: 50px">Minutos</th>
                                        <th><i class="fa fa-btc"></i> 1 Bitcoins </th>
                                    </tr>
                                    @for($i = 0; $i < count($week['$']); $i++)
                                        <?php  $ex = explode(":",$week['time'][$i]);?>
                                        <tr>
                                            <td>{{$week['time'][$i]}}</td>
                                            @if($i != count($week['$']) - 1 )
                                                @if($week['$'][$i] > $week['$'][$i + 1])
                                                    <td style="color: green">R$ {{$week['$'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                                @else
                                                    <td style="color: red">R$ {{$week['$'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                                @endif

                                            @else
                                                <td>R$ {{$week['$'][$i]}}</td>
                                            @endif
                                        </tr>
                                    @endfor
                                </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            @endif

            <div class="col-md-4 col-sm-6 col-xs-12">

                <a href="#"><button class="btn btn-app" data-toggle="modal" data-target="#myModal"> <i class="fa fa-cog" aria-hidden="true"></i> Gerar previsões </button></a>

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
                    <form action="{{route('coins')}}" method="POST">
                        {{ csrf_field() }}
                        <input style="display: none" type="text" name="coins" value="Bitcoins">
                        <div class="modal-body">
                            <!-- /.form-group -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dias</label>
                                    <select class="form-control" name="days" style="width: 100%;">
                                        <option value="1" selected="selected">1</option>
                                        <option value="3" > 3 </option>
                                        <option value="7" > 7 </option>
                                        <option value="15" > 15 </option>
                                        <option value="30" > 30  </option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prever Para:</label>
                                    <select class="form-control" name="time" style="width: 100%;">
                                        <option value="day" selected="selected">Dias</option>
                                        <option value="hour" > Horas </option>
                                        <option value="minute" > Minutos </option>
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Prever</button>
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
                    data = data + jdate['date'][i] +","+ jdate['$'][i]+ "\n";
                }

                console.log(data);

                new Dygraph(document.getElementById("div_g"), data, {
                    labels: [ "Date", "R$" ],
                    underlayCallback: function(canvas, area, g) {
                        function highlight_period(x_start, x_end) {
                            var canvas_left_x = g.toDomXCoord(x_start);
                            var canvas_right_x = g.toDomXCoord(x_end);
                            var canvas_width = canvas_right_x - canvas_left_x;
                            canvas.fillRect(canvas_left_x, area.y, canvas_width, area.h);
                        }

//                        var min_data_x = g.getValue(0,0);
//                        var max_data_x = g.getValue(g.numRows()-1,0);
//
////                         get day of week
//                        var d = new Date(min_data_x);
//                        var dow = d.getUTCDay();
                    },

                });
            }
    );

</script>

@endpush