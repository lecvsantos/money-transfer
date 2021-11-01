<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'payer_id',
        'payee_id',
        'status',
        'amount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function payer()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function payee()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function wallet()
    {
        return $this->hasMany('App\Models\Wallet');
    }
}
