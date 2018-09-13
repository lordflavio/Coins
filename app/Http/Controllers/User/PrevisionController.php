<?php

namespace App\Http\Controllers\User;

use App\Models\Cryptocoins\BTC;
use App\Models\Cryptocoins\DASH;
use App\Models\Cryptocoins\ETH;
use App\Models\Cryptocoins\LTC;
use App\Models\Cryptocoins\NEO;
use App\Models\Cryptocoins\WAVES;
use App\Models\Cryptocoins\XMR;
use App\Models\Cryptocoins\XRB;
use App\Models\Cryptocoins\XRP;
use App\Models\Cryptocoins\XVG;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MLP;
use App\Models\Petr4;
use App\Models\Soap;
use App\Models\MLP_AG;
use Illuminate\Support\Facades\Session;

class PrevisionController extends Controller
{
    public function store(Request $request,Soap $soap)
    {

        $date =  date('d/m/Y');
        $date2 = "01/01/".date('Y');

        $day = $request->days;
        $coins = $request->coins;

        $client = $soap->getSoap();


        if($request->coins == "Dolar"){

            $cotacoes[0] = round($client->getUltimoValorVO(1)->ultimoValor->valor,3);
            $cotacoes[1] = round($client->getUltimoValorVO(10813)->ultimoValor->valor,3);

            $array[0] = 1;
            $v = $client->getValoresSeriesVO($array, $date2,$date);

            $base = array();
            $value = array();



            for ($i = 0; $i < count($v[0]->valores); $i++){
                $base['$'][$i] = round($v[0]->valores[$i]->valor, 3);
                $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
            }

            //$m = new MLP($base['$'],0.90,0.10,0.30,10,0.01,100,2,2,2,0.8,0.8,0.2);

            $m = new  MLP($base['$'],0.90,0.10,0.30,15,0.01,50,1,3,0.7,0.2);

            $k = $m->start(100);


            $week = array();

            $b = count($base['$']);

            $cont = 0;

            $week['$'][0] = round( $cotacoes[0],3);
            $week['date'][0] = date('d/m/Y');

            $value['$'][$cont] =  $week['$'][0];
            $value['date'][$cont] = date('Y-m-d');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);
                    $cont++;
                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));

                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;
                    $cont++;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            $json_data = json_encode($value);

            //dd($value);

            return view('user/prediction',compact('week', 'day','coins','json_data','cotacoes'));
        }

        else if($request->coins == "Euro"){

            $cotacoes[0] = round($client->getUltimoValorVO(21619)->ultimoValor->valor,2);
            $cotacoes[1] = round($client->getUltimoValorVO(21620)->ultimoValor->valor,2);

            $array[0] = 21620;
            $v = $client->getValoresSeriesVO($array, $date2,$date);

            $base = array();

            for ($i = 0; $i < count($v[0]->valores); $i++){
                $base['$'][$i] = round($v[0]->valores[$i]->valor, 3);
                $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
            }

            $m = new MLP($base['$'],0.80,0.10,0.30,10,0.01,100,1,2,2,0.8,0.8,0.2);

            $k = $m->start(150);

            $value = array();
            $week = array();

            $b = count($base['$']);

            $cont = 0;

            $week['$'][0] = round( $base['$'][$b-1],3);
            $week['date'][0] = date('d/m/Y');

            $value['$'][$cont] =  $week['$'][0];
            $value['date'][$cont] = date('Y-m-d');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);

                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;

                    $cont++;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));
                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;

                    $cont++;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            $json_data = json_encode($value);

            return view('user/prediction',compact('week', 'day','coins','json_data','cotacoes'));
        }

        else if($request->coins == "Libra"){

            $cotacoes[0] = round($client->getUltimoValorVO(21623)->ultimoValor->valor,2);
            $cotacoes[1] = round($client->getUltimoValorVO(21624)->ultimoValor->valor,2);

            $array[0] = 21623;
            $v = $client->getValoresSeriesVO($array, $date2,$date);

            $base = array();

            for ($i = 0; $i < count($v[0]->valores); $i++){
                $base['$'][$i] = round($v[0]->valores[$i]->valor, 3);
                $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
            }

            $m = new MLP($base['$'],0.80,0.10,0.30,10,0.01,100,1,2,2,0.8,0.8,0.2);

            $k = $m->start(150);

            $value = array();
            $week = array();

            $b = count($base['$']);
            $cont = 0;

            $week['$'][0] = round( $base['$'][$b-1],3);
            $week['date'][0] = date('d/m/Y');

            $value['$'][$cont] =  $week['$'][0];
            $value['date'][$cont] = date('Y-m-d');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);

                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;
                    $cont++;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));
                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;
                    $cont++;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            $json_data = json_encode($value);

            return view('user/prediction',compact('week', 'day','coins','json_data','cotacoes'));
        }

        else if($request->coins == "Petr4"){

            $base = Petr4::readGlobalStock();

            /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
            $m = new MLP($base['close'],0.80,0.10,0.30,10,0.01,100,1,2,2,0.8,0.8,0.2);

            $k = $m->start(100);

           // $b = count($base['close']);

            $value = array();
            $cont = 0;

            //  dd($json);

            $week = array();

            $v[0][0] = round( $base['close'][0],2);

            $cotacoes[0] = $v[0][0];

            $aux = 0;
            for($n = 0; $n <= $request->days; $n++){
                if($n == 0){
                    $aux = $m->prevision($v);

                    $v[0][0] = $aux;

                    $week['$'][$n] = round( $aux,2);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));

                }else{
                    $aux = $m->prevision($v);

                    $v[0][0] = $aux;
                    $cont++;

                    $week['$'][$n] = round( $aux,2);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                    $value['$'][$cont] = $week['$'][$n];
                    $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));

                }
            }

            $json_data = json_encode($value);

            return view('user/prediction',compact('week', 'day','coins','json_data','cotacoes'));
        }

        else{
            Session::flash('info','Selecione uma moeda');
            return back();
        }
    }

    public function cryptocoins (Request $request,Soap $soap){

            $day = $request->days;
            $coins = $request->coins;
            $time = $request->time;

            $client = $soap->getSoap();
            $dolar = $client->getUltimoValorVO(1)->ultimoValor->valor;

            $base = self::getBase(1);

           // dd($base);

            /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
            $m = new MLP($base[$time]['close'],0.90,0.10,0.30,10,0.01,150,1,2,2,0.8,0.8,0.2);

            $k = $m->start(200);

            $value = array();
            $cont = 0;

            $week = array();



            if($time == 'day'){
                $v[0][0] = $base['today']['close'][1];
                $today = $base['today']['close'][1];
            }else if($time == 'hour'){
                $today =  BTC::readHour(0);
                $v[0][0] = $today['close'][1];
            }else if($time == 'minute'){
                $today =  BTC::readMinute(0);
                $v[0][0] = $today['close'][1];
            }


            $data = $today['date'][1];

            $aux = 0;

            for($n = 0; $n <= $request->days; $n++){
                if($n == 0){
                    $aux = $m->prevision($v);

                    $v[0][0] = $aux;


                    if($time == "day"){
                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));

                    }else if($time == "hour"){

                        $data = $data + 60*60;

                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('H:i',$data );

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d H:i',$data ) ;

                    }else if($time == "minute"){

                        $data = $data + 60*1;

                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('H:i',$data);

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d H:i',$data);
                    }


                }else{
                    $aux = $m->prevision($v);

                    $v[0][0] = $aux;
                    $cont++;

                    if($time == "day"){
                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d', strtotime('+'.$n.' days'));

                    }else if($time == "hour"){

                        $data = $data + 60*60;

                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('H:i',$data );

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d H:i',$data );

                    }else if($time == "minute"){

                        $data = $data + 60*1;

                        $week['valor'][$n] = round( $aux * $dolar,2);
                        $week['date'][$n] = date('H:i',$data);

                        $value['valor'][$cont] = $week['valor'][$n];
                        $value['date'][$cont] = date('Y-m-d H:i',$data);
                    }

                }
            }

            $json_data = json_encode($value);

            $coinsToday = $base['today'];

            return view('user/prediction',compact('week', 'day','coins','json_data','dolar','coinsToday','time'));

    }

    public function list($day, $coins, $list){

        $week = json_decode($list);

        return \PDF::loadView('user/pdf/prevision-download',compact('day','coins','week'))->download('Previsão '.$coins.'.pdf');
       // return view('user/pdf/prevision-download',compact('day','coins','week'));
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

    static private function getBase($value){

        $values = array();

        if($value = 1){
            $values['day'] = BTC::readDay();
            $values['hour'] = BTC::readHour();
            $values['minute'] = BTC::readHour();
            $values['today'] = BTC::readDay(0);
        }else if($value = 2){
            $values['day'] = DASH::readDay();
            $values['hour'] = DASH::readHour();
            $values['minute'] = DASH::readMinute();
            $values['today'] = DASH::readDay(0);
        }else if($value = 3){
            $values['day'] = NEO::readDay();
            $values['hour'] = NEO::readHour();
            $values['minute'] = NEO::readMinute();
            $values['today'] = NEO::readDay(0);
        }else if($value = 4){
            $values['day'] = ETH::readDay();
            $values['hour'] = ETH::readHour();
            $values['minute'] = ETH::readMinute();
            $values['today'] = ETH::readDay(0);
        }else if($value = 5){
            $values['day'] = LTC::readDay();
            $values['hour'] = LTC::readHour();
            $values['minute'] = LTC::readMinute();
            $values['today'] = LTC::readDay(0);
        }else if($value = 6){
            $values['day'] = WAVES::readDay();
            $values['hour'] = WAVES::readHour();
            $values['minute'] = WAVES::readMinute();
            $values['today'] = WAVES::readDay(0);
        }else if($value = 7){
            $values['day'] = XMR::readDay();
            $values['hour'] = XMR::readHour();
            $values['minute'] = XMR::readMinute();
            $values['today'] = XMR::readDay(0);
        }else if($value = 8){
            $values['day'] = XRP::readDay();
            $values['hour'] = XRP::readHour();
            $values['minute'] = XRP::readMinute();
            $values['today'] = XRP::readDay(0);
        }else if($value = 9){
            $values['day'] = XVG::readDay();
            $values['hour'] = XVG::readHour();
            $values['minute'] = XVG::readMinute();
            $values['today'] = XVG::readDay(0);
        }else if($value = 10){
            $values['day'] = XRB::readDay();
            $values['hour'] = XRB::readHour();
            $values['minute'] = XRB::readMinute();
            $values['today'] = XRB::readDay(0);
        }


        return $values;
    }

}
