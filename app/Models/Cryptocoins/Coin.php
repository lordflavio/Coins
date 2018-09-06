<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Moeda
 *
 * @author Irandir
 */

namespace App\Models\Cryptocoins;


abstract class  Coin {
    protected static function read($url){
        $result = Array();
        $jsonurl = $url;
  
        //Retorna o conteudo do arquivo em formato de string
        $json_content = file_get_contents($jsonurl);

        //Decodificando array 
        $json = json_decode($json_content, true);
        
        $time = Array();
        $open = Array();
        $close = Array();
        $volumefrom = Array(); 
        $volumeto = Array();
        foreach ($json['Data'] as $key => $value) {
            $time[$key] = $value['time']; 
            $open[$key] = $value['open'];
            $close[$key] = $value['close'];
            $volumefrom[$key] = $value['volumefrom'];
            $volumeto[$key] = $value['volumeto'];
        }

       // $data = Coin::segToData($time);
        $data = $time;

        $result['date'] = $data;
        $result['open'] = $open;
        $result['close'] = $close;
        $result['volumefrom'] = $volumefrom;
        $result['volumeto'] = $volumeto;
          
        return $result;
    }
    public static function now($coin1='BTC',$coin2='USD'){
        $jsonurl = "https://min-api.cryptocompare.com/data/price?fsym=".$coin1."&tsyms=".$coin2;
        
        //Retorna o conteudo do arquivo em formato de string
        $json_content = file_get_contents($jsonurl);

        //Decodificando array 
        $json = json_decode($json_content, true);
        
        return $json[$coin2];
    }
    
    public static function segToData($time){
        $data = Array();
        for ($index = 0; $index < count($time); $index++) {
            $data[$index] = gmdate("Y-m-d H:i:s", $time[$index]);
        }
        return $data;
    }

    public static function segToHora($time){
        $data = Array();
        for ($index = 0; $index < count($time); $index++) {
            $data[$index] = gmdate("H:i:s", $time[$index]);
        }
        return $data;
    }
}
