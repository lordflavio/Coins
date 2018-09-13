<?php

namespace App\Http\Controllers;
use App\Models\Cryptocoins\BTC;
use App\Models\Cryptocoins\DASH;
use App\Models\Cryptocoins\LTC;
use App\Models\Cryptocoins\XMR;
use App\Models\MLP;
use App\Models\MLP_AG;
use App\Models\Petr4;
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

    public function petr4(){

        $base = Petr4::readGlobalStock();

       // dd($base);

        $values = array();

        for ($i = 0; $i < count($base['close']); $i++){
            $values['$'][$i] = round($base['close'][$i], 4);
            $values['&'][$i] = round($base['open'][$i], 4);
            $values['date'][$i] = $base['date'][$i];
        }

        $cotacoes[1] = $values['$'][0];
        $cotacoes[0] = $values['&'][0];

        $week = array();

        $cont = 0;

        for ($j = 0; $j < 8; $j++ ){
            $week['$'][$cont] = $values['&'][$j];
            $week['&'][$cont] = $values['$'][$j];
            $week['date'][$cont] = $values['date'][$j];

            $cont++;
        }

        //dd($week);

        $json_data = json_encode($values);

        // dd($json_data);

        // echo  $week['$'][0] + $values['$'][0];


        return view('user/actions/petr4',compact('cotacoes', 'json_data','week'));

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


        $base =  BTC::readHour();

       // dd($base);

                    /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
        $m = new MLP($base['close'],0.90,0.10,0.30,10,0.01,150,1,2,2,0.8,0.8,0.2);

        $k = $m->start(100);

        //dd($base);

        $value = array();

        for ($i = 0; $i < count($k); $i++){
            $value['$'][$i] = round( $base['close'][$i],2);
            $value['&'][$i] = round( $k[$i],2);
            $value['date'][$i] = $base['date'][$i];
        }

        $json_data = json_encode($value);

        return view('test',compact('json_data'));

    }


    /**
     * Crypitoncoins
     */

    public function btc ($option = "day"){
        if($option == "day"){$type = 0;}else if($option == "hour"){$type = 1;}else if($option == "minute"){$type = 2;}

        $soap = new Soap();
        $client = $soap->getSoap();
        $dolar = $client->getUltimoValorVO(1)->ultimoValor->valor;

        $btcDay = BTC::readDay();
        $btcHour = BTC::readHour(24);
        $btcMinute = BTC::readMinute(60);

        $coins = array();


        if($type == 0){
            for ($i = 0; $i < count($btcDay['date']); $i++){
                $coins['$'][$i] = round( $btcDay['close'][$i] *  $dolar,2);
                $coins['date'][$i] =  date('Y-m-d',$btcDay['date'][$i]);
            }
        }else if ($type == 1){
            for ($i = 0; $i < count($btcHour['date']); $i++){
                $coins['$'][$i] = round( $btcHour['close'][$i] *  $dolar,2);
                $coins['date'][$i] = date('Y-m-d H:i',$btcHour['date'][$i]);
            }
        }else if ($type == 2){
            for ($i = 0; $i < count($btcMinute['date']); $i++){
                $coins['$'][$i] = round( $btcMinute['close'][$i] *  $dolar,2);
                $coins['date'][$i] =  date('Y-m-d H:i',$btcMinute['date'][$i]);
            }
        }

        //dd($coins);

        $week = array();

        $cont = 0;

        for ($j = (count($coins['$']) -1); $j > (count($coins['$']) - 8); $j-- ){
            $date = $coins['date'][$j];
            $week['$'][$cont] = $coins['$'][$j];
            $week['date'][$cont] = substr($date, 0, 10);
            $week['time'][$cont] = substr($date, 11, 8);
            $cont++;
        }

        $json_data = json_encode($coins);

        $coinsToday = BTC::readDay(0);

        //echo date('d/m/Y', $coinsToday['date'][1]);



        return view('user/coins/cryptocoins/btc',compact('json_data','coinsToday','week','dolar','type'));
    }

    public function dash (){
        return view('');
    }

    public function eth (){
        return view('');
    }

    public function ltc (){
        return view('');
    }

    public function xmr (){
        return view('');
    }
}
