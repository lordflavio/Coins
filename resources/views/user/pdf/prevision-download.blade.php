<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Previsão</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilo-lista.css" />

</head>
<body>

<div class="container-fluid">
    <header>
        <div id="logo" class="col-md-1">
            <img src="./imagens/logo.png" width="200" style="float: left" alt="Logo Tec">
        </div>
        <div id="descricao" class="col-md-12">
            <p><b>PREVISÃO DE SERIÉS TEMPORAIS (DÓLAR, EURO, LIBRA , BITCOINS)</b></p>
            {{--<p>Av. Capitão Pedro Rodrigues, nº 105 UPE – Garanhuns – PE</p>--}}
            <p>www.prediction.com.br - empresa.prediction@gmail.com</p>
            <p>Telefone: (87) 9.8122-7402</p>
            {{--<p>CNPJ: 17.281.120/0001-07</p>--}}
        </div>
    </header>

    {{--<div class=" linha-header"></div>--}}

    <section id="corpo">
        <div class="espacamento">
            <h4> PREVISÃO DE  </h4>
            {{--<h5><b> Atividade: {{date('d/m/Y', strtotime($date1))}} à {{date('d/m/Y', strtotime($date2))}} </b></h5>--}}
        </div>
        <div class="espacamento-tabela">
            <div class="row">
                <div class="span5">
                    <table class="table table-striped" style="text-align: center">
                        <thead>
                        <tr>
                            <th class="text-center">DATA</th>
                            <th class="text-center">VALOR R$</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for($i = 0; $i < count($week['$']); $i++)
                            <tr style="font-size: 14px">
                                <td class="text-center">{{$week['$'][$i]}}</td>
                                <td class="text-center">{{$week['date'][$i]}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
