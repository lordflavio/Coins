<?php

namespace App\Models;



class MLP_AG{

    protected $base;
    protected $baseNormalized;

    protected $baseTrain;
    protected $baseValidate;
    protected $baseTest;

    protected $input; /* base de treino  */
    protected $output; /* saida da base de traino  */

    protected $inputValidate; /* base de validação */
    protected $outputValidate; /* saida da base validação */

    protected $inputTest; /* base de validação */
    protected $outputTest; /* saida da base validação */

    protected $hiddenNeurons; /* Quantidade de neuronios escondidos */
    protected $learning; /* taxa de aprendisado  */

    protected $erroValidate; /* Erro  de Validação */
    protected $erroTotal;

    protected $population; /* População */
    protected $populationFitness;/* Erro quadratico medio*/

    protected $individualBest;  /* melhor individuo*/
    protected $individualBestFitness; /*fitness do melhor individuo */
    
    protected $windowCros; 
    protected $probCros;
    protected $probMut;
    
    protected $min;
    protected $max;


    public function __construct(
                                $base,
                                $baseTrain,
                                $baseValidate,
                                $baseTest,

                                $hiddenNeurons,
                                $learning,
                                $populationSize,

                                $window,
                                $windowCros,
                                $probCros,
                                $probMut
                                ){



        $this->base = $base;
        $this->baseTrain = $baseTrain;
        $this->baseValidate = $baseValidate;
        $this->baseTest = $baseTest;

        $this->hiddenNeurons = $hiddenNeurons;
        $this->learning = $learning;
        
        $this->windowCros = $windowCros;
        $this->probCros = $probCros;
        $this->probMut = $probMut;
        
        $this->normalize();
        $this->createWindow($window);
        
        
        
        $weights = count($this->input[0]) * $this->hiddenNeurons + 2 * $this->hiddenNeurons + 1;

        $this->generatePopulation($populationSize,$weights);
    }

    public function start ($epooc){
        
        for ($i = 0; $i < $epooc; $i++){
            $this->calc_fitness();
            $this->selection();
            $this->crossoverAritmetico();
            
            $this->mutacaoUniforme();
            $this->calc_fitness();
            $this->calc_individualFitnessBest($i);
            $this->eletismo();
        }
        $this->train($epooc);
        return $this->test();
    }

    public function generatePopulation($size,$weights){
        for( $i = 0; $i < $size; $i++){
            for ($j = 0; $j < $weights; $j++){
                $this->population[$i][$j] = $this->randomFloat();
            }
        }
    }
    
    // Mutação Uniforme: x’ = x + M
    public function mutacaoUniforme() {
        $prob = 0;
        for ($i = 0; $i < count($this->population); $i++) {
            for ($j = 0; $j < count($this->population[0]); $j++) {
                $prob = $this->randomFloat();
                if ($prob <= $this->probMut) {
                    $this->population[$i][$j] = $this->population[$i][$j] + $this->randomFloat(-1,1);//gera valores negativos tb
                }
            }
        }
       
    }    
    
    public function calc_fitness(){
        
        $net = array();
        $netOut = 0;

        $error = 0;
        $erroTotal = 0;
        $this->populationFitness = null;
        for ($k = 0; $k < count($this->population); $k++) {
            $p = -1;
            for ($i = 0; $i < count($this->input); $i++) {
                for ($h = 0; $h < $this->hiddenNeurons; $h++) {
                    for ($j = 0; $j < count($this->input[0]); $j++) {
                        $p++;
                        $net[$h] = $this->population[$k][$p] * $this->input[$i][$j];
                    }
                }
                for ($g = 0; $g < count($net); $g++) {
                    $p++;
                    $net[$g] += $this->population[$k][$p];//bias
                    $net[$g] = $this->sigmoid($net[$g]);
                }
                for ($y = 0; $y < count($net); $y++) {
                    $p++;
                    $netOut = $this->population[$k][$p] * $net[$y];
                }
                $netOut += $this->population[$k][$p + 1];
                
                //desnaliza as saidas
                $netOutDes = $this->denormalize($netOut);
                $outputDes = $this->denormalize($this->output[$i]);
                
                $error = ($outputDes - $netOutDes);

                $erroTotal = $erroTotal + pow($error,2);

                $error = 0;
                $netOut = 0;
                $p = -1;

                for ($j = 0; $j < count($net); $j++){
                    $net[$j] = 0;
                }
            }

            $erroTotal = $erroTotal / count($this->input);
            
            $this->populationFitness[$k] = 1000/(1+$erroTotal);
            
            $erroTotal = 0;
        }
       //print_r($this->populationFitness);
       //echo '<br/>____________________<br/>';
    }

    // eletismo
    public function eletismo() {
        $indice = 0;
        $value = 9999;
        for ($i = 0; $i < count($this->populationFitness); $i++) {
            if ($value > $this->populationFitness[$i]) {
                $value = $this->populationFitness[$i];
                $indice = $i;
            }
        }
        $populationPosEletismo = null;
        for ($i = 0; $i < count($this->population); $i++) {
            for ($j = 0; $j < count($this->population[0]); $j++) {
                $populationPosEletismo[$i][$j] = $this->population[$i][$j];
            }
        }
        for ($j = 0; $j < count($this->population[0]); $j++) {
            $populationPosEletismo[$indice][$j] = $this->individualBest[$j];
        }
        $this->population = $populationPosEletismo;
    }

    // crossover aritmético
    public function crossoverAritmetico() {
        $populationPosCrossover = null;
        $prob = 0;
        $a = 0;
        for ($i = 0; $i < count($this->population) / 2; $i++) {
            $prob = $this->randomFloat();
            if ($prob <= $this->probCros) {
                $a = $this->randomFloat();
                for ($j = 0; $j < count($this->population[0]); $j++) {
                    $populationPosCrossover[$i * 2][$j] = $a * $this->population[$i * 2][$j] + (1 - $a) * $this->population[$i * 2 + 1][$j];
                    $populationPosCrossover[$i * 2 + 1][$j] = (1 - $a) * $this->population[$i * 2][$j] + $a * $this->population[$i * 2 + 1][$j];
                }
            } else {
                for ($j = 0; $j < count($this->population[0]); $j++) {
                    $populationPosCrossover[$i * 2][$j] = $this->population[$i * 2][$j];
                    $populationPosCrossover[$i * 2 + 1][$j] = $this->population[$i * 2 + 1][$j];
                }
            }
        }
        $this->population = $populationPosCrossover;
    }

    //selecao torneio
    public function selection() {
        $populationSelection = null;
        $indice = 0;
        $ind = 0;
        $aux = 0;
        for ($i = 0; $i < count($this->populationFitness); $i++) {
            $indice = mt_rand(0,count($this->populationFitness)-1);
            $aux = $this->populationFitness[$indice];
            $ind = $indice;
            for ($j = 0; $j < $this->windowCros; $j++) {
                $indice = $this->randomFloat();
                if ($aux < $this->populationFitness[$indice]) {
                    $aux = $this->populationFitness[$indice];
                    $ind = $indice;
                }
            }
            for ($j = 0; $j < count($this->population[0]); $j++) {
                $populationSelection[$i][$j] = $this->population[$ind][$j];
            }
        }
        $this->population = $populationSelection;
    }

    public function calc_individualFitnessBest($geracao) {
        $value = $this->populationFitness[0];
        $indice = 0;
        for ($i = 0; $i < count($this->populationFitness); $i++) {
            if ($value < $this->populationFitness[$i]) {
                $value = $this->populationFitness[$i];
                $indice = $i;
            }
        }
        
        if($value>$this->individualBestFitness[$geracao-1] || $geracao == 0){
            $this->individualBestFitness[$geracao] = $value;
            $this->individualBest = $this->population[$indice];
        }else{
            $this->individualBestFitness[$geracao] = $this->individualBestFitness[$geracao-1];
        }
    }

    public function sigmoid($value){
        return 1/(1 + exp(-$value));
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
        for ($i = 0; $i < $validate - $window; $i++){
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
                        $net[$h] = $this->individualBest[$p] * $this->input[$i][$j];
                    }
                }
                for ($g = 0; $g < count($net); $g++) {
                    $p++;
                    $net[$g] += $this->individualBest[$p];
                    $net[$g] = $this->sigmoid($net[$g]);
                }
                $z = $p;
                for ($y = 0; $y < count($net); $y++) {
                    $p++;
                    $netOut = $this->individualBest[$p] * $net[$y];
                }
                $netOut += $this->individualBest[$p + 1];

                $error = ($this->output[$i] - $netOut);

                $errorTotal += pow($error,2);


                $gradientsOut = 1 * $error;

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $z++;
                    $gradients[$j] = $this->individualBest[$z] * $gradientsOut;
                    $gradients[$j] = $gradients[$j] * $net[$j] *(1 - $net[$j]);
                }

                $this->individualBest[$p+1] += $this->learning * $gradientsOut;

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $this->individualBest[$p] += $this->learning * $net[$j] * $gradientsOut;
                    $p--;
                }

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    $this->individualBest[$p] += $this->learning * 1 * $gradients[$j];
                    $p--;
                }

                for ($j = 0; $j < count($this->hiddenNeurons); $j++){
                    for ($l = 0; $l < count($this->input[0]); $l++){
                        $this->individualBest[$p] = $this->individualBest[$p] + $this->learning * $this->input[$i][$l] * $gradients[$j];
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
                    $net[$h] = $this->individualBest[$p] * $this->inputValidate[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->individualBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->individualBest[$p] * $net[$y];
            }
            $netOut += $this->individualBest[$p + 1];

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
                    $net[$h] = $this->individualBest[$p] * $this->inputTest[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->individualBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->individualBest[$p] * $net[$y];
            }
            $netOut += $this->individualBest[$p + 1];

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
                    $net[$h] = $this->individualBest[$p] * $input[$i][$j];
                }
            }
            for ($g = 0; $g < count($net); $g++) {
                $p++;
                $net[$g] += $this->individualBest[$p];
                $net[$g] = $this->sigmoid($net[$g]);
            }
            for ($y = 0; $y < count($net); $y++) {
                $p++;
                $netOut = $this->individualBest[$p] * $net[$y];
            }
            $netOut += $this->individualBest[$p + 1];

            $result = round($this->denormalize($netOut),4);

            $netOut = 0;
            $p = -1;

            for ($j = 0; $j < count($net); $j++){
                $net[$j] = 0;
            }
        }

       // echo $s;

        return $result;
    }

    public function getIndividualbestFitennes(){
        return $this->individualBestFitness;
    }
   
    static function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    
    function getOutput(){
        $r = null;
        for ($index = 0; $index < count($this->outputTest); $index++) {
            $r[$index] = $this->denormalize($this->outputTest[$index]);
        }
        return $r;
    }
}
