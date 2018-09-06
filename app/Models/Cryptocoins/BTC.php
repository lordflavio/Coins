<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Cryptocoins;
use App\Models\Cryptocoins\Coin;

/**
 * Description of BTC
 *
 * @author Irandir
 */

//require_once '../Cryptocoins/Coin.php';

class BTC extends Coin{
    public static function readMinute($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histominute?fsym=BTC&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }
    public static function readHour($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histohour?fsym=BTC&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }
    public static function readDay($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histoday?fsym=BTC&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }     
}
