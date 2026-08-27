<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    public $table = 'ledger';
    protected $fillable = [
        'ledgerId',
        'iProductId',
        'iOrderId',
        'iOrderDetailId',
        'iInwardId',
        'iSize',
        'openingBalance',
        'cr',
        'dr',
        'closingBalance',
        'created_at',
        'updated_at',
        'strIP'
    ];
}
