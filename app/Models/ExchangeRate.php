<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'base_id', 'targeted_id', 'created_at', 'rate',
    ];
}
