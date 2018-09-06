<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XMR
 *
 * @author Irandir
 */

namespace App\Models\Cryptocoins;
use App\Models\Cryptocoins\Coin;

//require_once './Coin.php';

class XVG extends Coin{
    public static function readMinute($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histominute?fsym=XVG&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }
    public static function readHour($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histohour?fsym=XVG&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }
    public static function readDay($limit = 100){
        $url = "https://min-api.cryptocompare.com/data/histoday?fsym=XVG&tsym=USD&limit=".$limit;
        $result = Coin::read($url);
        return $result;
    }
}
