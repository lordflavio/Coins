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

        <div class="col-xs-4">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Fazer nova previsão </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="{{route('prediction')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-md-4">
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
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Moeda</label>
                                <select class="form-control" name="coins" style="width: 100%;">
                                    <option value="Moeda" > Selecione a modeda </option>
                                    <option value="Bitcois" > Bitcois </option>
                                    <option value="Dolar" > Dolar </option>
                                    <option value="Euro" > Euro </option>
                                    <option value="Libra" > Libra  </option>
                                    {{--<option value="45" > 45 </option>--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <button class="btn btn-success" type="submit">Fazer previsão</button>
                            </div>
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

</section>
@endsection

@push('scripts')

@endpush