<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transacoes";
    protected $fillable = ['user_id', 'reference', 'code', 'status', 'payment_method', 'date'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'client_services');
    }

    public function newTransacao($object, $reference, $code, $status = 1, $paymentMethod = 2, $type)
    {
        $order = $this->create([
            'user_id' => auth()->user()->id,
            'reference' => $reference,
            'code' => $code,
            'status' => $status,
            'payment_method' => $paymentMethod,
            'date' => date('Y-m-d'),
        ]);

        Client_services::created(array(
            'clients_id' => auth()->user()->id,
            'services_id' => $object->id,
            'transactions_id' => $order->id,
            'value'
        ));
    }

    public function getStatus($status)
    {
        $statusA = [
            1 => 'Aguardando pagamento',
            2 => 'Em análise',
            3 => 'Paga',
            4 => 'Disponível',
            5 => 'Em disputa',
            6 => 'Devolvida',
            7 => 'Cancelada',
            8 => 'Debitado',
            9 => 'Retenção temporária',
        ];

        return $statusA[$status];
    }

    public function getLabel($status)
    {
        $statusA = [
            1 => 'label-primary',
            2 => 'label-warning',
            3 => 'label-success',
            4 => 'label-success',
            5 => 'label-default',
            6 => 'label-info',
            7 => 'label-danger',
            8 => 'label-default',
            9 => 'label-default',
        ];

        return $statusA[$status];
    }

    public function getMethodPayment($method)
    {
        $paymentsMethods = [
            1 => 'Cartão de crédito',
            2 => 'Boleto',
            3 => 'Débito online (TEF)',
            4 => 'Saldo PagSeguro',
            5 => 'Oi Paggo',
            7 => 'Pagamento Precencial',
        ];

        return $paymentsMethods[$method];
    }


//    public function getDateAttribute($value)
//    {
//        return Carbon::parse($value)->format('d/m/Y');
//    }
//
//
//    public function getDateRefreshStatusAttribute($value)
//    {
//        return Carbon::parse($value)->format('d/m/Y');
//    }


    public function changeStatus($newStatus)
    {
        $this->status = $newStatus;
        $this->save();
    }

}
