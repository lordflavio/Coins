<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client_services extends Model
{
    protected $table = "client_services";
    protected $fillable = [
        'clients_id',
        'services_id',
        'transactions_id',
    ];
}
