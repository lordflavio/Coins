<?php

namespace App\Http\Controllers;

use App\Models\MLP;
use App\Models\MLP_AG;
use App\Models\Soap;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Soap $soap)
    {

        $client = $soap->getSoap();

        $array[0] = 1;
        $array[1] = 21619;
        $array[2] = 21623;

        // $client->getUltimoValorVO(1)->ultimoValor->valor;

        //  Dollar americano compra e venda
        $cotacoes[0] = round($client->getUltimoValorVO(1)->ultimoValor->valor,2);
        $cotacoes[1] = round($client->getUltimoValorVO(10813)->ultimoValor->valor,2);

        //  Euro  compra e venda
        $cotacoes[2] = round($client->getUltimoValorVO(21619)->ultimoValor->valor,2);
        $cotacoes[3] = round($client->getUltimoValorVO(21620)->ultimoValor->valor,2);

        //  Libra esterlina compra e venda
        $cotacoes[4] = round($client->getUltimoValorVO(21623)->ultimoValor->valor,2);
        $cotacoes[5] = round($client->getUltimoValorVO(21624)->ultimoValor->valor,2);

        $json = json_decode($this->getYesterday());

        foreach ($json->bpi as $j){
            $bitCoins = $j;
        }

        $bitCoins =  round( $bitCoins *  $cotacoes[1],2);

        return view('user/home',compact('data', 'cotacoes','bitCoins'));
    }

    public function dolar(Soap $soap){
        $client = $soap->getSoap();

        $array[0] = 1;
        $array[1] = 10813;
        //  Dollar americano compra e venda
        $cotacoes[0] = round($client->getUltimoValorVO(1)->ultimoValor->valor,3);
        $cotacoes[1] = round($client->getUltimoValorVO(10813)->ultimoValor->valor,3);

        $date =  date('d/m/Y');

        $date2 = "01/01/".date('Y');

        $v = $client->getValoresSeriesVO($array, $date2, $date);

       // dd($v);

        $values = array();

        for ($i = 0; $i < count($v[0]->valores); $i++){
            $values['$'][$i] = round($v[0]->valores[$i]->valor, 4);
            $values['&'][$i] = round($v[1]->valores[$i]->valor, 4);
            $values['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
        }

        $week = array();

        $cont = 0;

        for ($j = (count($values['$']) -1); $j > (count($values['$']) - 8); $j-- ){
                $week['$'][$cont] = $values['$'][$j];
                $week['&'][$cont] = $values['&'][$j];
                $week['date'][$cont] = $values['date'][$j];

            $cont++;
        }

        $json_data = json_encode($values);

       // dd($json_data);

       // echo  $week['$'][0] + $values['$'][0];


        return view('user/coins/dolar',compact('cotacoes', 'json_data','week'));

    }

    public function euro(Soap $soap){
        $client = $soap->getSoap();

        $array[0] = 21619;
        $array[1] = 21620;

        //  Euro  compra e venda
        $cotacoes[0] = round($client->getUltimoValorVO(21619)->ultimoValor->valor,2);
        $cotacoes[1] = round($client->getUltimoValorVO(21620)->ultimoValor->valor,2);


        $date =  date('d/m/Y');

        $date2 = "01/01/".date('Y');

        $v = $client->getValoresSeriesVO($array, $date2, $date);

        // dd($v);

        $values = array();

        for ($i = 0; $i < count($v[0]->valores); $i++){
            $values['$'][$i] = round($v[0]->valores[$i]->valor, 4);
            $values['&'][$i] = round($v[1]->valores[$i]->valor, 4);
            $values['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
        }

        $week = array();

        $cont = 0;

        for ($j = (count($values['$']) -1); $j > (count($values['$']) - 8); $j-- ){
            $week['$'][$cont] = $values['$'][$j];
            $week['&'][$cont] = $values['&'][$j];
            $week['date'][$cont] = $values['date'][$j];

            $cont++;
        }

        $json_data = json_encode($values);

        // dd($json_data);

        // echo  $week['$'][0] + $values['$'][0];


        return view('user/coins/euro',compact('cotacoes', 'json_data','week'));

    }

    public function libra(Soap $soap){
        $client = $soap->getSoap();

        $array[0] = 21623;
        $array[1] = 21624;

        //  Libra esterlina compra e venda
        $cotacoes[0] = round($client->getUltimoValorVO(21623)->ultimoValor->valor,2);
        $cotacoes[1] = round($client->getUltimoValorVO(21624)->ultimoValor->valor,2);

        $date =  date('d/m/Y');

        $date2 = "01/01/".date('Y');

        $v = $client->getValoresSeriesVO($array, $date2, $date);

        // dd($v);

        $values = array();

        for ($i = 0; $i < count($v[0]->valores); $i++){
            $values['$'][$i] = round($v[0]->valores[$i]->valor, 4);
            $values['&'][$i] = round($v[1]->valores[$i]->valor, 4);
            $values['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
        }

        $week = array();

        $cont = 0;

        for ($j = (count($values['$']) -1); $j > (count($values['$']) - 8); $j-- ){
            $week['$'][$cont] = $values['$'][$j];
            $week['&'][$cont] = $values['&'][$j];
            $week['date'][$cont] = $values['date'][$j];

            $cont++;
        }

        $json_data = json_encode($values);

        // dd($json_data);

        // echo  $week['$'][0] + $values['$'][0];


        return view('user/coins/libra',compact('cotacoes', 'json_data','week'));

    }

    public function bitcoin(Soap $soap){

        $client = $soap->getSoap();
        $cotacoes[1] = round($client->getUltimoValorVO(10813)->ultimoValor->valor,2);



       // $date =  date('Y-m-d');

        $date =  date('Y-m-d', strtotime('-1 day'));

        $date2 = date('Y').'-01-01';

        $json = json_decode($this->getRange($date2,$date));

        $bitCoins = array();

        $i = 0;

        foreach ($json->bpi as $j => $a){
            $bitCoins['$'][$i] = round( $a *  $cotacoes[1],2);
            $bitCoins['date'][$i] = $j;
            $i++;
        }

        $week = array();

        $cont = 0;

        for ($j = (count($bitCoins['$']) -1); $j > (count($bitCoins['$']) - 8); $j-- ){
            $week['$'][$cont] = $bitCoins['$'][$j];
            $week['date'][$cont] = $bitCoins['date'][$j];
            $cont++;
        }

        $json_data = json_encode($bitCoins);


        $bit = json_decode($this->getYesterday());

        foreach ($bit->bpi as $j => $a){
            $bitValue = $a;
        }

      //  dd($json);


        $bitcoinValue =  round( $bitValue *  $cotacoes[1],2);

        return view('user/coins/bitcoin',compact('cotacoes','bitcoinValue','json_data','week'));

    }

    static public function getYesterday(){
        //	$url = "http://api.coindesk.com/v1/bpi/historical/close.json?start=$start_date&end=$end_date";

        $url = "http://api.coindesk.com/v1/bpi/historical/close.json?for=yesterday";

        //for debug
        //echo $url;

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return $output;
    }

    static public function getRange($start_date,$end_date){
        $url = "http://api.coindesk.com/v1/bpi/historical/close.json?start=$start_date&end=$end_date";

      //  $url = "http://api.coindesk.com/v1/bpi/historical/close.json?for=yesterday";

        //for debug
        //echo $url;

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return $output;
    }

    public function test (Soap $soap){

          $client = $soap->getSoap();
          $cotacoes[1] = round($client->getUltimoValorVO(10813)->ultimoValor->valor,2);
//
        $date =  date('d/m/Y');

        $date2 = "01/01/".date('Y');

//        $date =  date('Y-m-d', strtotime('-1 day'));
//
//        $date2 = date('Y').'-01-01';
//
        $array[0] = 1;
        $v = $client->getValoresSeriesVO($array, $date2,$date);

//       //  dd($v);
//
        $base = array();
        $base2 = array();
////
        for ($i = 0; $i < count($v[0]->valores); $i++){
            $base['$'][$i] = round($v[0]->valores[$i]->valor, 4);
            $base2[$i] = round($v[0]->valores[$i]->valor, 4);
            $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
        }


//        $json = json_decode($this->getRange($date2,$date));
//
//        $base = array();
//
//        $i = 0;
//
//        foreach ($json->bpi as $j => $a){
//            $base['$'][$i] = $a;
//            $base['date'][$i] = $j;
//            $i++;
//        }

//        $base = [3.273,3.263,3.233,3.213,3.206,3.21,3.192,3.215,3.166,3.203,3.223,3.21,3.221,3.211,3.192,3.161,3.165,3.169,3.18,3.16,3.132,3.127,3.148,3.12,3.124,3.118,
//            3.13,3.126,3.119,3.116,3.118,3.1,3.078,3.051,3.095,3.092,3.097,3.082,3.064,3.099,3.098,3.114,3.136,3.111,3.119,3.148,3.174,3.162,3.154,3.164,3.163,3.108,
//            3.108,3.09,3.077,3.094,3.125,3.128,3.126,3.13,3.123,3.125,3.168,3.117,3.123,3.092,3.116,3.13,3.141,3.142,3.146,3.127,3.104,3.096,3.129,3.145,3.125,3.158,
//            3.185,3.176,3.198,3.172,3.149,3.178,3.176,3.194,3.186,3.161,3.156,3.129,3.101,3.092,3.108,3.381,3.288,3.286,3.265,3.263,3.282,3.261,3.271,3.266,3.244,3.231,
//            3.24,3.282,3.282,3.275,3.284,3.274,3.299,3.321,3.284,3.289,3.298,3.315,3.325,3.336,3.334,3.313,3.317,3.303,3.295,3.308,3.302,3.305,3.319,3.306,3.29,3.265,
//            3.252,3.226,3.211,3.19,3.182,3.167,3.153,3.14,3.126,3.146,3.156,3.166,3.151,3.146,3.131,3.116,3.127,3.119,3.122,3.127,3.132,3.146,3.154,3.17,3.189,3.198,
//            3.167,3.16,3.165,3.144,3.154,3.157,3.14,3.146,3.156,3.17,3.164,3.147,3.133,3.139,3.12,3.113,3.091,3.085,3.114,3.134,3.135,3.126,3.124,3.132,3.128,3.135,
//            3.129,3.141,3.167,3.193,3.187,3.168,3.164,3.15,3.132,3.135,3.165,3.177,3.169,3.164,3.157,3.161,3.177,3.167,3.173,3.183,3.2,3.247,3.239,3.244,3.28,3.255,
//            3.277,3.274,3.292,3.285,3.273,3.251,3.252,3.266,3.287,3.283,3.281,3.279,3.262,3.259,3.256,3.237,3.23,3.222,3.223,3.214,3.262,3.264,3.251,3.232,3.235,3.289,
//            3.281,3.285,3.315,3.304,3.333,3.318,3.288,3.288,3.291,3.305,3.321,3.32,3.303,3.308,3.308,3.27,3.254,3.232,3.241,3.236,3.24,3.247,3.23,3.22,3.196,3.222,3.232,
//            3.213,3.209,3.193,3.225,3.197,3.139,3.145,3.166,3.166,3.162,3.173,3.206,3.236,3.261,3.247,3.269,3.282,3.254,3.221,3.238,3.235,3.251,3.256,3.26,3.242,3.235,
//            3.238,3.245,3.262,3.261,3.258,3.225,3.232,3.252,3.25,3.261,3.249,3.258,3.286,3.291,3.291,3.298,3.292,3.303,3.304,3.303,3.326,3.338,3.324,3.31,3.314,3.354,
//            3.32,3.367,3.39,3.42,3.405,3.386,3.411,3.426,3.404,3.384,3.398,3.41,3.442,3.467,3.504,3.498,3.468,3.481,3.542,3.548,3.531,3.546,3.579,3.594,3.557,3.572,
//            3.61,3.675,3.68,3.687,3.75,3.707,3.65,3.651,3.644,3.659,3.709,3.729,3.737,3.741,3.742,3.775,3.819,3.9,3.786,3.691];


        /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
        // $m = new MLP($base['$'],0.90,0.10,0.30,10,0.01,200,1,2,2,0.8,0.8,0.2);

         $m = new  MLP_AG($base['$'],0.90,0.10,0.30,6,0.01,100,1,3,0.7,0.2);

         $k = $m->start(100);

        $value = array();

        for ($i = 0; $i < count($k); $i++){
            $value['$'][$i] = round( $base['$'][$i],2);
            $value['&'][$i] = round( $k[$i],2);
            $value['date'][$i] = $base['date'][$i];
        }

        $json_data = json_encode($value);

        return view('test',compact('json_data'));

    }

    public function prevision (Soap $soap){

          $client = $soap->getSoap();
          $cotacoes = round($client->getUltimoValorVO(10813)->ultimoValor->valor,4);
//
//        $date =  date('d/m/Y');
//
//        $date2 = "01/01/".date('Y');

        $date =  date('Y-m-d', strtotime('-1 day'));

        $date2 = date('Y').'-01-01';

//        $array[0] = 1;
//        $v = $client->getValoresSeriesVO($array, $date2,$date);
//
//       //  dd($v);
//
//        $base = array();
//        $base2 = array();
////
//        for ($i = 0; $i < count($v[0]->valores); $i++){
//            $base['$'][$i] = round($v[0]->valores[$i]->valor, 4);
//            $base2[$i] = round($v[0]->valores[$i]->valor, 4);
//            $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
//        }


        $json = json_decode($this->getRange($date2,$date));

        $base = array();

        $i = 0;

        foreach ($json->bpi as $j => $a){
            $base['$'][$i] = $a;
            $base['date'][$i] = $j;
            $i++;
        }

//        $base = [3.273,3.263,3.233,3.213,3.206,3.21,3.192,3.215,3.166,3.203,3.223,3.21,3.221,3.211,3.192,3.161,3.165,3.169,3.18,3.16,3.132,3.127,3.148,3.12,3.124,3.118,
//            3.13,3.126,3.119,3.116,3.118,3.1,3.078,3.051,3.095,3.092,3.097,3.082,3.064,3.099,3.098,3.114,3.136,3.111,3.119,3.148,3.174,3.162,3.154,3.164,3.163,3.108,
//            3.108,3.09,3.077,3.094,3.125,3.128,3.126,3.13,3.123,3.125,3.168,3.117,3.123,3.092,3.116,3.13,3.141,3.142,3.146,3.127,3.104,3.096,3.129,3.145,3.125,3.158,
//            3.185,3.176,3.198,3.172,3.149,3.178,3.176,3.194,3.186,3.161,3.156,3.129,3.101,3.092,3.108,3.381,3.288,3.286,3.265,3.263,3.282,3.261,3.271,3.266,3.244,3.231,
//            3.24,3.282,3.282,3.275,3.284,3.274,3.299,3.321,3.284,3.289,3.298,3.315,3.325,3.336,3.334,3.313,3.317,3.303,3.295,3.308,3.302,3.305,3.319,3.306,3.29,3.265,
//            3.252,3.226,3.211,3.19,3.182,3.167,3.153,3.14,3.126,3.146,3.156,3.166,3.151,3.146,3.131,3.116,3.127,3.119,3.122,3.127,3.132,3.146,3.154,3.17,3.189,3.198,
//            3.167,3.16,3.165,3.144,3.154,3.157,3.14,3.146,3.156,3.17,3.164,3.147,3.133,3.139,3.12,3.113,3.091,3.085,3.114,3.134,3.135,3.126,3.124,3.132,3.128,3.135,
//            3.129,3.141,3.167,3.193,3.187,3.168,3.164,3.15,3.132,3.135,3.165,3.177,3.169,3.164,3.157,3.161,3.177,3.167,3.173,3.183,3.2,3.247,3.239,3.244,3.28,3.255,
//            3.277,3.274,3.292,3.285,3.273,3.251,3.252,3.266,3.287,3.283,3.281,3.279,3.262,3.259,3.256,3.237,3.23,3.222,3.223,3.214,3.262,3.264,3.251,3.232,3.235,3.289,
//            3.281,3.285,3.315,3.304,3.333,3.318,3.288,3.288,3.291,3.305,3.321,3.32,3.303,3.308,3.308,3.27,3.254,3.232,3.241,3.236,3.24,3.247,3.23,3.22,3.196,3.222,3.232,
//            3.213,3.209,3.193,3.225,3.197,3.139,3.145,3.166,3.166,3.162,3.173,3.206,3.236,3.261,3.247,3.269,3.282,3.254,3.221,3.238,3.235,3.251,3.256,3.26,3.242,3.235,
//            3.238,3.245,3.262,3.261,3.258,3.225,3.232,3.252,3.25,3.261,3.249,3.258,3.286,3.291,3.291,3.298,3.292,3.303,3.304,3.303,3.326,3.338,3.324,3.31,3.314,3.354,
//            3.32,3.367,3.39,3.42,3.405,3.386,3.411,3.426,3.404,3.384,3.398,3.41,3.442,3.467,3.504,3.498,3.468,3.481,3.542,3.548,3.531,3.546,3.579,3.594,3.557,3.572,
//            3.61,3.675,3.68,3.687,3.75,3.707,3.65,3.651,3.644,3.659,3.709,3.729,3.737,3.741,3.742,3.775,3.819,3.9,3.786,3.691];


        /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
         $m = new MLP($base['$'],0.80,0.10,0.30,10,0.01,100,1,2,2,0.8,0.8,0.2);

         $k = $m->start(100);


        $bit = json_decode($this->getYesterday());
        $bitValue = 0;
        foreach ($bit->bpi as $j => $a){
            $bitValue = $a;
        }

        //  dd($json);


        //$bitcoinValue =  round( $bitValue *  $cotacoes[1],2);

        $s = "";
        $aux = 0;
        for($n = 0; $n < 20; $n++){
            if($n == 0){
                $aux = $m->prevision($bitValue);
                $s .= round( $aux *  $cotacoes,2)."<br>";
            }else{
                $aux = $m->prevision($aux);
                $s .= round( $aux *  $cotacoes,2)."<br>";
            }
        }

        echo $s;

        $value = array();

        for ($i = 0; $i < count($k); $i++){
            $value['$'][$i] = round( $base['$'][$i] *  $cotacoes,2);
            $value['&'][$i] = round( $k[$i] *  $cotacoes,2);
            $value['date'][$i] = $base['date'][$i];
        }

        $json_data = json_encode($value);

        return view('test',compact('json_data'));

    }
}
