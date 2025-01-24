<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'base_id',
        'targeted_id',
        'exchange_rate',
        'reverse_exchange_rate',
    ];

    public function baseCurrency(){
        return $this->belongsTo(Currency::class,'base_id','id');
    }

    public function targetedCurrency(){
        return $this->belongsTo(Currency::class,'targeted_id','id');
    }
}
