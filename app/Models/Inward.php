<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inward extends Model
{
    use HasFactory;
    public $table = "inward";
    protected $fillable = [
        'inwardId',
        'iProductId',
        'iSize',
        'iQty',
        'created_at',
        'updated_at',
        'strIP'
    ];
}
