<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $table = "orderdetail";
    protected $primaryKey = 'orderDetailId';

    protected $fillable = [
        'orderDetailId',
        'orderID',
        'customerid',
        'productId',
        'quantity',
        'weight',
        'rate',
        'amount',
        'size',
        'isPayment',
        'isRefund',
        'iStatus',
        'isDelete',
    ];
}
