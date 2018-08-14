<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prevision extends Model
{
    protected $table = "clients";
    protected $fillable = [
        'configuration',
        'dateI',
        'dateF',
        'clients_id'
    ];
}
