<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soap extends Model
{
   public function getSoap(){
       $client = new \Zend\Soap\Client("https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl",
           array("soap_version"=>SOAP_1_1,'location'=>'https://www3.bcb.gov.br/wssgs/services/FachadaWSSGS')
       );

       return $client;
   }
}
