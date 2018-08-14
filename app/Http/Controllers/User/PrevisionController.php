<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MLP;
use App\Models\Soap;
use App\Models\MLP_AG;
use Illuminate\Support\Facades\Session;

class PrevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Soap $soap)
    {

        $date =  date('d/m/Y');
        $date2 = "01/01/".date('Y');

        $day = $request->days;
        $coins = $request->coins;

        $client = $soap->getSoap();
        $cotacoes = round($client->getUltimoValorVO(10813)->ultimoValor->valor,3);

        if($request->coins == "Dolar"){

            $array[0] = 1;
            $v = $client->getValoresSeriesVO($array, $date2,$date);

            $base = array();

            for ($i = 0; $i < count($v[0]->valores); $i++){
                $base['$'][$i] = round($v[0]->valores[$i]->valor, 3);
                $base['date'][$i] = $v[0]->valores[$i]->ano . "-". $v[0]->valores[$i]->mes. "-". $v[0]->valores[$i]->dia;
            }

            //$m = new MLP($base['$'],0.90,0.10,0.30,10,0.01,100,2,2,2,0.8,0.8,0.2);

            $m = new  MLP_AG($base['$'],0.90,0.10,0.30,15,0.01,100,1,3,0.7,0.2);

            $k = $m->start(100);

            $value = array();
            $week = array();

            $b = count($base['$']);

            $week['$'][0] = round( $cotacoes,3);
            $week['date'][0] = date('d/m/Y');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);

                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            return view('user/prediction',compact('week', 'day','coins'));
        }

        else if($request->coins == "Euro"){

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

            $week['$'][0] = round( $base['$'][$b-1],3);
            $week['date'][0] = date('d/m/Y');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);

                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            return view('user/prediction',compact('week', 'day','coins'));
        }

        else if($request->coins == "Libra"){

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

            $week['$'][0] = round( $base['$'][$b-1],3);
            $week['date'][0] = date('d/m/Y');

            $prev[0][0] = $base['$'][$b-1];
          //  $prev[0][1] = $base['$'][$b-2];


            $aux = 0;
            for($n = 1; $n <= $request->days; $n++){
                if($aux == 0){
                    $aux = $m->prevision($prev);

                    $prev[0][0] = $aux;
                   // $prev[0][1] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }else{
                    $aux = $m->prevision($prev);

                   // $prev[0][0] = $prev[0][1];
                    $prev[0][0] =  $aux;

                    $week['$'][$n] = round( $aux,3);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));
                }
            }

            $h = $request->days;

            return view('user/prediction',compact('week', 'day','coins'));
        }

        else if($request->coins == "Bitcoins"){
            $dateB =  date('Y-m-d', strtotime('-1 day'));

            $date2B = date('Y').'-01-01';


            $json = json_decode($this->getRange($date2B,$dateB));

            $base = array();

            $i = 0;

            foreach ($json->bpi as $j => $a){
                $base['$'][$i] = $a;
                $base['date'][$i] = $j;
                $i++;
            }

            /*(base, baseTrain, baseValidade, test, hiddenNeurons, learning, populationSize, c1, c2, window, wInertia, maxInertia, minInertia)*/
            $m = new MLP($base['$'],0.80,0.10,0.30,10,0.01,100,1,2,2,0.8,0.8,0.2);

            $k = $m->start(100);


            $bit = json_decode($this->getYesterday());
            $bitValue = array();
            foreach ($bit->bpi as $j => $a){
                $bitValue[0][0] = $a;
            }

            //  dd($json);


            //$bitcoinValue =  round( $bitValue *  $cotacoes[1],2);

            $week = array();

            $aux = 0;
            for($n = 0; $n < $request->days; $n++){
                if($n == 0){
                    $aux = $m->prevision($bitValue);

                    $bitValue[0][0] = $aux;

                    $week['$'][$n] = round( $aux *  $cotacoes,2);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                }else{
                    $aux = $m->prevision($bitValue);

                    $bitValue[0][0] = $aux;

                    $week['$'][$n] = round( $aux *  $cotacoes,2);
                    $week['date'][$n] = date('d/m/Y', strtotime('+'.$n.' days'));

                }
            }
            return view('user/prediction',compact('week', 'day','coins'));
        }

        else{
            Session::flash('info','Selecione uma moeda');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
