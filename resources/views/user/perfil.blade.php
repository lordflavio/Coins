@extends('layouts.system')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="../../system/dist/img/user4-128x128.jpg" alt="User profile picture">

                        <h3 class="profile-username text-center">Nina Mcintire</h3>

                        <p class="text-muted text-center">Software Engineer</p>

                        <a href="#" class="btn btn-primary btn-block"><b>Alterar Imagem</b></a>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li><a href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="timeline">

                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="settings">
                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group col-md-8">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope-o"></i>
                                            </div>
                                            <input type="text" disabled value="flavioedez@hotmail.com" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Nome</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="text" name="apelido"  value="Flavio" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Mudar Senha: Senha Atual </label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </div>
                                            <input type="password"  name="password" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Mudar Senha: Nova Senha</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </div>
                                            <input type="password"  class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Mudar Senha: Confime nova Senha</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-key"></i>
                                            </div>
                                            <input type="password"  class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <div class="col-xs-12">
                                        <button type="submit" style="width: 150px" class="btn btn-success center-block">Salva</button>
                                    </div>

                                </form>
                            </div>

                                <h3 style="font-weight: 700">Informações Principais</h3>

                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group col-md-8">
                                        <label>Nome Completo:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>CPF:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="cpf" class="form-control" data-inputmask='"mask": "999.999.999-99"' data-mask required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>CEP:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="postal_code" class="form-control" data-inputmask='"mask": "99999-999"' data-mask required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-6">
                                        <label>Endereço:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-map-marker"></i>
                                            </div>
                                            <input type="text" name="street" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-2">
                                        <label>Numero:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-sort-numeric-desc"></i>
                                            </div>
                                            <input type="text" name="number" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>


                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Bairro:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="street" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Complemento:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="street" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>


                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Cidade:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="street" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Estado:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-id-card"></i>
                                            </div>
                                            <input type="text" name="street" class="form-control" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- /.form-group -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>País</label>
                                            <select class="form-control" name="pais" style="width: 100%;">
                                                <option selected="selected">Alabama</option>
                                                <option>Alaska</option>
                                                <option disabled="disabled">California (disabled)</option>
                                                <option>Delaware</option>
                                                <option>Tennessee</option>
                                                <option>Texas</option>
                                                <option>Washington</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <!-- text input -->
                                    <div class="form-group col-md-4">
                                        <label>Telefone/Celular:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" name="postal_code" class="form-control" data-inputmask='"mask": "(99)99999-9999"' data-mask required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>

                                    <!-- Date dd/mm/yyyy -->
                                    <div class="form-group col-md-4" >
                                        <label>Data Nascimento</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control" name="birth_date" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <!-- /.form group -->

                                    <div class="col-xs-12">
                                        <button type="submit" style="width: 150px" class="btn btn-success center-block">Salva</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="system/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="system/plugins/input-mask/jquery.inputmask.js"></script>
<script src="system/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="system/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="system/bower_components/moment/min/moment.min.js"></script>
<script src="system/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="system/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="system/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="system/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<script src="system/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="system/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="system/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="system/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="system/dist/js/demo.js"></script>
<!-- Page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>


@endpush



