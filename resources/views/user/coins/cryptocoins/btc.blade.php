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
        </div>

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                    <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                    <li><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="box-body">
                            <div class="col-md-8 ">
                                <div  style="margin-top: 10px" id="div_d" class="chart"></div>
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
                                            @for($i = 0; $i < count($weekDay['$']); $i++)
                                                <?php  $ex = explode("-",$weekDay['date'][$i]); ?>
                                                <tr>
                                                    <td>{{$ex[2]}}</td>
                                                    @if($i != count($weekDay['$']) - 1 )
                                                        @if($weekDay['$'][$i] > $weekDay['$'][$i + 1])
                                                            <td style="color: green">R$ {{$weekDay['$'][$i]}} <i class="fa fa-sort-asc" aria-hidden="true"></i></td>
                                                        @else
                                                            <td style="color: red">R$ {{$weekDay['$'][$i]}} <i class="fa fa-sort-desc" aria-hidden="true"></i></td>
                                                        @endif

                                                    @else
                                                        <td>R$ {{$weekDay['$'][$i]}}</td>
                                                    @endif
                                                </tr>
                                            @endfor
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 ">
                                <a href="#"><button class="btn-xs btn-info" data-toggle="modal" data-target="#myModal"> Fazer previsão <i class="fa fa-cog" aria-hidden="true"></i></button></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">


                        <div class="box-body">
                            <div class="col-md-8 ">
                                <div  style="margin-top: 10px" id="div_d" class="chart"></div>
                            </div>
                        </div>


                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="settings">
                        <div class="box-body">

                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
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
                        <input style="display: none" type="text" name="coins" value="Bitcoins">
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

        var jdate1 = <?php echo $json_data1; ?>;

        var dataHour = "";

                for(i = 0; i < jdate1["$"].length; i++){
                    var x = new Date(0);
                    x.setUTCSeconds(jdate1['date'][i]);
                    dataHour = dataHour + x +","+ jdate1['$'][i] + "\n";
                }

               // console.log(dataHour);

                new Dygraph(document.getElementById("div_d"), dataHour, {
                    labels: [ "Date", "R$"],
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

                    title: 'Horas'

                });
            }
    );

</script>

@endpush