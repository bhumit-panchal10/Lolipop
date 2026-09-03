<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Setting;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customer';
    protected $fillable = [
        'customername',
        'password',
        'customermobile',
        'customeremail',
        'strIP',
        'token',
    ];
}
