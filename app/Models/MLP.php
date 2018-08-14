<?php

namespace App\Models;



class MLP{

    protected $base;
    protected $baseNormalized;

    protected $baseTrain;
    protected $baseValidate;
    protected $baseTest;

    protected $input; /* base de treino  */
    protected $output; /* saida da bade de traino  */

    protected $inputValidate; /* base de validação */
    protected $outputValidate; /* saida da base validação */

    protected $inputTest; /* base de validação */
    protected $outputTest; /* saida da base validação */

    protected $hiddenNeurons; /* Quantidade de neuronios escondidos */
    protected $learning; /* taxa de aprendisado  */

    protected $erroValidate; /* Erro  de Validação */
    protected $erroTotal;

    protected $particle;		 /* População */
    protected $velocity;   		/* Velocidade de ajuste */
    protected $particleFitness;      /* Erro quadratico medio*/
    protected $pBest;      		/* Memoria anterior */
    protected $pBestFitness;
    protected $gBest;        		/* melhor particula*/
    protected $gBestFitness;

    protected $c1;
    protected $c2;

    protected $min;
    protected $max;

    protected $wInertia;
    protected $maxInertia;
    protected $minInertia;


    public function __construct(
                                $base,
                                $baseTrain,
                                $baseValidate,
                                $baseTest,

                                $hiddenNeurons,
                                $learning,
                                $populationSize,

                                $window,

                                $c1,$c2,
                                $wInertia,
                                $maxInertia,
                                $minInertia){



        $this->base = $base;
        $this->baseTrain = $baseTrain;
        $this->baseValidate = $baseValidate;
        $this->baseTest = $baseTest;

        $this->hiddenNeurons = $hiddenNeurons;
        $this->learning = $learning;

        $this->c1 = $c1;
        $this->c2 = $c2;

        $this->wInertia = $wInertia;
        $this->maxInertia = $maxInertia;
        $this->minInertia = $minInertia;

        $this->normalize();
        $this->createWindow($window);

        $weights = count($this->input[0]) * $this->hiddenNeurons + 2 * $this->hiddenNeurons + 1;

        $this->generateParticulas($populationSize,$weights);
    }

    public function start ($epooc){
        for ($i = 0; $i < $epooc; $i++){
            $this->calc_fitness();
            $this->calc_gBest($i);
            $this->populationAjust();
            $this->inertiaAjust($i, $epooc);
        }

        $this->train($epooc);

       return $this->test();
    }

    public function generateParticulas($size,$weights){
        for( $i = 0; $i < $size; $i++){
            for ($j = 0; $j < $weights; $j++){
                $this->particle[$i][$j] = $this->randomFloat();
                $this->pBest[$i][$j] =  $this->particle[$i][$j];
                $this->velocity[$i][$j] =  $this->particle[$i][$j];
            }
        }
    }

    public function calc_fitness(){

        $net = array();
        $netOut = 0;

        $error = 0;
        $erroTotal = 0;

        for ($k = 0; $k < count($this->particle); $k++) {
            $p = -1;
            for ($i = 0; $i < count($this->input); $i++) {
                for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                    for ($j = 0; $j < count($this->input[0]); $j++) {
                        $p++;
                        $net[$h] = $this->particle[$k][$p] * $this->input[$i][$j];
                    }
                }
                for ($g = 0; $g < count($net); $g++) {
                    $p++;
                    $net[$g] += $this->particle[$k][$p];
                    $net[$g] = $this->sigmoid($net[$g]);
                }
                for ($y = 0; $y < count($net); $y++) {
                    $p++;
                    $netOut = $this->particle[$k][$p] * $net[$y];
                }
                $netOut += $this->particle[$k][$p + 1];

                $error = ($this->output[$i] - $netOut);

                $erroTotal = $erroTotal + pow($error,2);

                $error = 0;
                $netOut = 0;
                $p = -1;

                for ($j = 0; $j < count($net); $j++){
                    $net[$j] = 0;
                }
            }

            $erroTotal = $erroTotal / count($this->input);

            if(isset($this->particleFitness[$k])){
                if($erroTotal < $this->particleFitness[$k]){
                    for ($i = 0; $i < count($this->particle[0]); $i++){
                        $this->pBest[$k][$i] = $this->particle[$k][$i];
                    }
                    $this->particleFitness[$k] = $erroTotal;
                    $this->pBestFitness[$k] = $erroTotal;
                }else{
                    $this->particleFitness[$k] = $erroTotal;
                }
            }else{
                $this->particleFitness[$k] = $erroTotal;
                $this->pBestFitness[$k] = $erroTotal;
            }
            $erroTotal = 0;
        }
    }

    public function calc_gBest($index){
        $i = $this->minFitness($this->pBestFitness);
        if($index > 0){
            if($this->gBestFitness[$index - 1] > $this->pBestFitness[$i]){
                $this->gBestFitness[$index] = $this->pBestFitness[$i];
                for ($j = 0; $j < count($this->pBest[0]); $j++){
                    $this->gBest[$j] = $this->pBest[$i][$j];
                }
            }else{
                $this->gBestFitness[$index] = $this->gBestFitness[$index - 1];
            }
        }else{
            $this->gBestFitness[$index] = $this->pBestFitness[$i];
            for ($j = 0; $j < count($this->pBest[0]); $j++){
                $this->gBest[$j] = $this->pBest[$i][$j];
            }
        }
    }

    public function populationAjust(){

        $this->velocityAjust();

        for ($i = 0; $i < count($this->particle); $i++){
            for ($j = 0; $j < count($this->particle[0]); $j++){
                $this->particle[$i][$j] =  $this->particle[$i][$j] + $this->velocity[$i][$j];
            }
        }
    }

    public function velocityAjust(){
        for ($i = 0; $i < count($this->velocity); $i++){
            for ($j = 0; $j < count($this->velocity[0]); $j++){
                $this->velocity[$i][$j] = ($this->wInertia * $this->velocity[$i][$j]) + $this->c1 *
                    (float)rand()/(float)getrandmax() * ($this->pBest[$i][$j] - $this->particle[$i][$j]) + $this->c2 *
                    (float)rand()/(float)getrandmax() * ($this->gBest[$j] - $this->particle[$i][$j]);
            }
        }
    }

    public function sigmoid($value){
        return 1/(1 + exp(-$value));
    }

    public function minFitness($value){
        $min = 9999999999;
        $index = 0;

        for ($i = 0; $i < count($value); $i++){
            if($min > $value[$i]){
                $min = $value[$i];
                $index = $i;
            }
        }

        return $index;
    }

    public function normalize(){

        $this->max = 0;
        $this->min = $this->base[0];

        for ($i = 0; $i < count($this->base); $i++){
            if($this->max < $this->base[$i]){
                $this->max = $this->base[$i];
            }

            if($this->min > $this->base[$i]){
                $this->min = $this->base[$i];
            }
        }
        for ($i = 0; $i < count($this->base); $i++){
            $this->baseNormalized[$i] = ($this->base[$i] - $this->min) / ($this->max - $this->min);
        }
    }

    public function denormalize ($value){
        return $value * ($this->max - $this->min) + $this->min;
    }

    public function createWindow ($window){
        $train = round((count($this->base) - $window) * $this->baseTrain);
        $validate = round((count($this->base) - $window) * $this->baseValidate);
        $test= count($this->base) - $window;

        $aux = 0;

        for ($i = 0; $i < $train; $i++){
            $aux++;
            for ($j = 0; $j < $window; $j++){
                $this->input[$i][$j] = $this->baseNormalized[$aux+$j];
            }
            $this->output[$i] = $this->baseNormalized[$aux+$window];
        }
        for ($i = 0; $i < $validate - 1; $i++){
            $aux++;
            for ($j = 0; $j < $window; $j++){
                $this->inputValidate[$i][$j] = $this->baseNormalized[$aux+$j];
            }
            $this->outputValidate[$i] = $this->baseNormalized[$aux+$window];
        }
        for ($i = 0; $i < $test - 1; $i++){
            $aux++;
            for ($j = 0; $j < $window; $j++){
                $this->inputTest[$i][$j] = $this->baseNormalized[$i+$j];
            }
            $this->outputTest[$i] = $this->baseNormalized[$i+$window];
        }
    }

    public function inertiaAjust ($index, $epooc){
        $this->wInertia = ($this->wInertia - $index / $epooc) * ($this->maxInertia - $this->minInertia);
    }

    public function train ($epooc){

        $net = array();
        $netOut = 0;

        $error = 0;
        $errorTotal = 0;

        $erroTotal = array();

        $gradients = array();
        $gradientsOut = 0;

        for ($k = 0; $k < $epooc; $k++){
            $p = -1;
            for ($i = 0; $i < count($this->input); $i++) {
                for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                    for ($j = 0; $j < count($this->input[0]); $j++) {
                        $p++;
                        $net[$h] = $this->gBest[$p] * $this->input[$i][$j];
                    }
                }
                for ($g = 0; $g < count($net); $g++) {
                    $p++;
                    $net[$g] += $this->gBest[$p];
                    $net[$g] = $this->sigmoid($net[$g]);
                }
                $z = $p;
                for ($y = 0; $y < count($net); $y++) {
                    $p++;
                    $netOut = $this->gBest[$p] * $net[$y];
                }
                $netOut += $this->gBest[$p + 1];

                $error = ($this->output[$i] - $netOut);

                $errorTotal += pow($error,2);


                $gradientsOut = 1 * $error;

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $z++;
                    $gradients[$j] = $this->gBest[$z] * $gradientsOut;
                    $gradients[$j] = $gradients[$j] * $net[$j] *(1 - $net[$j]);
                }

                $this->gBest[$p+1] += $this->learning * $gradientsOut;

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $this->gBest[$p] += $this->learning * $net[$j] * $gradientsOut;
                    $p--;
                }

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $this->gBest[$p] += $this->learning * 1 * $gradients[$j];
                    $p--;
                }

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    for ($l = 0; $l < count($this->input[0]); $l++){
                        $this->gBest[$p] = $this->gBest[$p] + $this->learning * $this->input[$i][$l] * $gradients[$j];
                        $p--;
                    }
                }

                $error = 0;
                $netOut = 0;
                $p = -1;

                for ($j = 0; $j < count($net); $j++){
                    $net[$j] = 0;
                }
            }

            $this->erroValidate = $this->validate();

            $erroTotal[$k] = $errorTotal / count($this->input);

            $errorTotal = 0;
        }
    }

    public function validate (){
        $net = array();
        $netOut = 0;

        $error = 0;
        $errorTotal = 0;

        $p = -1;
        for ($i = 0; $i < count($this->inputValidate); $i++) {
            for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                for ($j = 0; $j < count($this->inputValidate[0]); $j++) {
                    $p++;
                    $net[$h] = $this->gBest[$p] * $this->inputValidate[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->gBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->gBest[$p] * $net[$y];
            }
            $netOut += $this->gBest[$p + 1];

            $error = ($this->output[$i] - $netOut);

            $errorTotal += pow($error, 2);

            $error = 0;
            $netOut = 0;
            $p = -1;

            for ($j = 0; $j < count($net); $j++){
                $net[$j] = 0;
            }

        }

        return ($errorTotal / count($this->inputValidate));
    }

    public function test (){
        $result = array();
        $net = array();
        $netOut = 0;

        $error = 0;
        $erroTotal = 0;

        $s ="";

        $p = -1;
        for ($i = 0; $i < count($this->inputTest); $i++) {
            for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                for ($j = 0; $j < count($this->inputTest[0]); $j++) {
                    $p++;
                    $net[$h] = $this->gBest[$p] * $this->inputTest[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->gBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->gBest[$p] * $net[$y];
            }
            $netOut += $this->gBest[$p + 1];

            $error = ($this->outputTest[$i] - $netOut);

            $erroTotal += pow($error,2);

            $result[$i] = round($this->denormalize($netOut),4);

         //   $s =  $s . round($this->denormalize($netOut),4) ." | ".$this->denormalize($this->outputTest[$i]).'<br>';


            $error = 0;
            $netOut = 0;
            $p = -1;

            for ($j = 0; $j < count($net); $j++){
                $net[$j] = 0;
            }
        }

       // echo $s;

        return $result;
    }

    public function prevision ($value){

       // $input[0][0] = ($value - $this->min) / ($this->max - $this->min);

        for ($i = 0; $i < count($value); $i++){
            for ($j = 0; $j < count($value[0]); $j++){
                $input[$i][$j] = ($value[$i][$j] - $this->min) / ($this->max - $this->min);
            }
        }

        $result = 0;
        $net = array();
        $netOut = 0;

        $p = -1;
        for ($i = 0; $i < count($input); $i++) {
            for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                for ($j = 0; $j < count($input[0]); $j++) {
                    $p++;
                    $net[$h] = $this->gBest[$p] * $input[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->gBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->gBest[$p] * $net[$y];
            }
            $netOut += $this->gBest[$p + 1];

            $result = round($this->denormalize($netOut),3);

            $netOut = 0;
            $p = -1;

            for ($j = 0; $j < count($net); $j++){
                $net[$j] = 0;
            }
        }

       // echo $s;

        return $result;
    }


    public function getGbestFitennes(){
        return $this->gBestFitness;
    }
    public function getPbestFitennes(){
        return $this->gBestFitness;
    }
    static function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

}
