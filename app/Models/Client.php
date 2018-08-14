<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";
    protected $fillable = [
        'name',
        'cpf',
        'street',
        'number',
        'complement',
        'district',
        'postal_code',
        'city',
        'state',
        'country',
        'phone',
        'area_code',
        'birth_date',
        'img'
    ];
}
