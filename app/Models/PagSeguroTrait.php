<?php

namespace App\Model;
use GuzzleHttp\Client as Guzzle;

trait PagSeguroTrait
{
    public function getConfigs()
    {
        return [
            'email' => config('pagseguro.email'),
            'token' => config('pagseguro.token'),
        ];
    }
    
    public function setCurrency($currency, $object)
    {
        $this->currency = $currency;
    }
    
    public function getItems($object)
    {
        $items = [];

        $posistion = 1;

            $description = "Contrato de plano ".$object->type."www.coins.com";
            $custo = $object->value;

        //dd($description);

        $items["itemId{$posistion}"]            = $object->id;
        $items["itemDescription{$posistion}"]   = $description;
        $items["itemAmount{$posistion}"]        = str_replace(",", ".", $custo);
        $items["itemQuantity{$posistion}"]      = '1';

       

        return $items;
        /*
        return [
            'itemId1' => '0001',
            'itemDescription1' => 'Produto PagSeguroI',
            'itemAmount1' => '99999.99',
            'itemQuantity1' => '1',
            'itemWeight1' => '1000',
            'itemId2' => '0002',
            'itemDescription2' => 'Produto PagSeguroII',
            'itemAmount2' => '99999.98',
            'itemQuantity2' => '2',
            'itemWeight2' => '750',
        ];
         */
    }
    
    
    public function getSender()
    {
        $cpf =   $this->limpa($this->client->cpf);
        $phone = $this->limpa(substr($this->client->phone, 4,9));
        $nome = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $this->client->name ) );

        return [
            'senderName'        => $nome,
            'senderAreaCode'    => $this->client->area_cod,
            'senderPhone'       => $phone,
            'senderEmail'       => $this->user->email,
            'senderCPF'         => $cpf,
        ];
    }
    
    public function getShipping()
    {
        return [
            'shippingType'                  => '1',
            'shippingAddressStreet'         => $this->client->street,
            'shippingAddressNumber'         => $this->client->number,
            'shippingAddressComplement'     => $this->client->complement,
            'shippingAddressDistrict'       => $this->client->district,
            'shippingAddressPostalCode'     => $this->limpa($this->client->postal_code),
            'shippingAddressCity'           => $this->client->city,
            'shippingAddressState'          => $this->client->state,
            'shippingAddressCountry'        => $this->client->country,
        ];
    }
    
    
    public function getCreditCard($request)
    {
        $cod = substr($request->telefonecard, 1,2);
        $fone = $this->limpa(substr($request->telefonecard, 4,9));
        return [
            'creditCardHolderName'      => $request->card_holder_name,
            'creditCardHolderCPF'       => $this->limpa($request->cpf),
            'creditCardHolderBirthDate' => $request->data,
            'creditCardHolderAreaCode'  => $cod,
            'creditCardHolderPhone'     => $fone,
        ];
    }


    public function billingAddress()
    {
        return [
            'billingAddressStreet'      => $this->client->street,
            'billingAddressNumber'      => $this->client->number,
            'billingAddressComplement'  => $this->client->complement,
            'billingAddressDistrict'    => $this->client->district,
            'billingAddressPostalCode'  => $this->limpa($this->client->postal_code),
            'billingAddressCity'        => $this->client->city,
            'billingAddressState'       => $this->client->state,
            'billingAddressCountry'     => 'BRL',
        ];
    }
    
    public function limpa($valor) {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace("-", "", $valor);
        return $valor;
    }
}