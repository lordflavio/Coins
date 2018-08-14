<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Model\PagSeguro;


class PagSeguroController extends Controller
{
    public function pagseguro(PagSeguro $pagseguro)
    {
        $code = $pagseguro->generate();
        
        $urlRedirect = config('pagseguro.url_redirect_after_request').$code;
        
        return redirect()->away($urlRedirect);
    }
    
    public function lightbox()
    {
        return view('pagseguro-lightbox');
    }
    
    public function lightboxCode(PagSeguro $pagseguro)
    {
        return $pagseguro->generate();
    }
    
    public function transparente()
    {
        return view('pagseguro-transparente');
    }
    
    public function getCode(PagSeguro $pagseguro)
    {
        return $pagseguro->getSessionId();
    }
    
    public function billet(Request $request, PagSeguro $pagseguro, Transacoes $trans)
    {
            $object = Service::where('type','=',$request->busca)->first();
            
            $response = $pagseguro->paymentBillet($request->sendHash, $object);

            $trans->newTransacao($object, $response['reference'], $response['code'],1, $paymentMethod = 2, $request->type);

//        $cart = new Cart;
//        $order->newOrderProducts($cart, $response['reference'], $response['code']);
//        $cart->emptyCart();
        
        return response()->json($response, 200);
    }
    
    public function cardTransaction(Request $request, PagSeguro $pagseguro)
    {
        return $pagseguro->paymentCredCard($request);
    }


    public function paymentCard(Request $request, PagSeguro $pagseguro, Transaction $trans)
    {
        
       // $response = $pagseguro->paymentCredCard($request)

            $object = Service::where('type','=',$request->busca)->first();
            
            $response = $pagseguro->paymentCredCard($request, $object);
             if ( $response['success'] ) {
            // Registra a compra do usuário
            $trans->newTransacao($object, $response['reference'], $response['code'],$response['status'], $paymentMethod = 1, $request->type);
        }
        
        // Retorno da transação
        return response()->json($response, 200);
    }
}