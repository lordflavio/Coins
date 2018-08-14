<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    protected $table = "clients";
    protected $fillable = [
        'value',
        'day',
        'dateF',
        'previsions_id'
    ];
}
