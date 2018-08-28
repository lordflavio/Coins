<?php

namespace App\Models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReaderJSON
 *
 * @author Irandir
 */
class Petr4{
    //Global Stock Time Series Data
    
    static function read2($url){
        $result = Array();
  
        $jsonurl = $url;

       // dd($jsonurl);
  
        //Retorna o conteudo do arquivo em formato de string
        $json_content = file_get_contents($jsonurl);

        //Decodificando array 
        $json = json_decode($json_content, true);
        
        
        //pegue o ultimo do json array
        $time_series_15 = null;
        foreach ($json as $value){
            $time_series_15 = $value;
        }
        
        //repostas
        $time[] = [];
        $open[] = [];
  //      $high[] = [];
        //$low[] = [];
        $close[] = [];
    //    $volume[] = [];
        
        //alimenta os arrays de resposta
        $indice = 0;
        foreach ($time_series_15 as $lista) {
            current($time_series_15);
            $time[$indice] = key($time_series_15);
            
            $aux = 0;
            foreach ($lista as $value) {
                if ($aux == 0) {
                    $open[$indice] = $value;
                }elseif ($aux == 1) {
      //              $high[$indice] = $value;
                }elseif ($aux == 2) {
          //          $low[$indice] = $value;
                }elseif ($aux == 3) {
                    $close[$indice] = $value;
                }elseif ($aux == 4) {
        //            $volume[$indice] = $value;
                }
                $aux++;
            }
            next($time_series_15);//incrmenta o ponteiro do array para o metodo current
            $indice++;//incremente a posicao dos array resposta
            
        }
        
        //mostra os arrays
        /*for ($i =0; $i< count($time);$i++){
            echo $time[$i]."  "
                    .$open[$i]."  "
                    .$high[$i]."  "
                    .$low[$i]."  "
                    .$close[$i]."  "
                    .$volume[$i]."  "."<br/>";
        }*/
        $result['date'] = $time;
        $result['open'] = $open;
        $result['close'] = $close;
        
        /*$r = $result['data'];
        foreach ($r as $key => $value) {
            echo $value.'<br/>';
        }*/
        return $result;
    }
    
    
    static public function readGlobalStock($function='TIME_SERIES_DAILY',$symbol='PETR4.SA',$interval = '15min',$outputsize = 'compact'){
        $jsonurl = "https://www.alphavantage.co/query?function=".$function."&symbol=".$symbol."&interval=".$interval."&outputsize=".$outputsize."&apikey=9R90VBITPJPGZFG5";
        //echo $jsonurl.'';
        $r =  Petr4::read2($jsonurl);
        return $r;
        
    }
    
    static public function readForeignExchange($function='FX_INTRADAY',$symbol1='EUR',$symbol2='USD',$interval = '5min',$outputsize = 'compact'){
        $jsonurl = "https://www.alphavantage.co/query?function=" . $function . "&from_symbol=" . $symbol1 . "&to_symbol=" . $symbol2 . "&interval=" . $interval . "&outputsize=" . $outputsize . "&apikey=9R90VBITPJPGZFG5";
        //echo $jsonurl.'<br/>';
        $r =  Petr4::read2($jsonurl);
        return $r;
        
    }
    static public function readCurrencies(){
        $jsonurl = " https://www.alphavantage.co/query?function=DIGITAL_CURRENCY_INTRADAY&symbol=BTC&market=EUR&apikey=9R90VBITPJPGZFG5";
        //return Petr4::read2($jsonurl);
    }
    
  
}
