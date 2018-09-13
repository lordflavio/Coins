<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Previsão</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    {{--<link rel="stylesheet" href="css/estilo-lista.css" />--}}

</head>
<body>

<div class="container-fluid">
    <header>
        <div id="logo" class="col-md-1">
            <img src="images/logo.png" width="300" style="float: left; margin-top: 10px" alt="Logo Prediction">
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
            <h4 style="text-transform: uppercase"> PREVISÃO DE {{$coins}} </h4>
            <h5><b> De {{date('d/m/Y', strtotime($week->date[0]))}} até {{date('d/m/Y', strtotime($week->date[$day-1]))}} </b></h5>
        </div>
        <div class="espacamento-tabela">
            <div class="row">
                <div class="span5">
                    <table class="table table-striped" style="text-align: center">
                        <thead>
                        <tr>
                            <th class="text-center">DATA/HORA/MINUTO</th>
                            <th class="text-center">VALOR R$</th>
                        </tr>
                        </thead>
                        <tbody>

                        @for($i = 0; $i < count($week->date); $i++)
                            <tr style="font-size: 14px">
                                <td class="text-center">{{$week->date[$i]}}</td>
                                <td class="text-center">{{$week->valor[$i]}}</td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    <h4 class="text-center">
                        {{date('d/m/Y')}}
                    </h4>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @import url('https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700');

    /*header #logo img{*/
    /*width: 330px;*/
    /*height: 200px;*/
    /*!*margin-top: -10px;*!*/
    /*}*/
    header{
        text-align: right;
    }

    .linha-header{
        margin-top: 28px;
        height: 15px;
        width: 100%;
        background-color: #005E89;
    }

    header #descricao{
        margin-top: 35px;
        text-align: right;
    }
    header #descricao p{
        margin: 0;
    }
    header #descricao p {
        color: #005E89;
        font-size: 14px;

    }

    #corpo{
        /*height: 800px;*/
        /*width: 100%;*/
        background-color: #fff;
        font-family: 'Ubuntu', sans-serif;
    }
    #corpo .espacamento{
        color: #000;
        margin-top: 30px;
        text-align: center;
    }
    #corpo .espacamento b{
        color: #005E89;
    }
    #corpo .espacamento span{
        font-size: 1.0rem;
    }
    #corpo .espacamento-tabela{
        margin-top: 35px;
    }
    #corpo .espacamento-tabela .span5{
        width: 100%;
    }
    #corpo thead{
        background-color: #005E89;
        color: #fff;
        font-size: 14px;
    }


    footer {
        background-color: #005E89;
        color: #fff;
        width: 100%;
    }
    footer .espacamento-footer{
        height: 80px;
        width: 100%;
        background-color: #fff;
    }
</style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>
