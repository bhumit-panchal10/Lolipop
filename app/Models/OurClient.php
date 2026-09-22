<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurClient extends Model
{
    use HasFactory;

    protected $table = 'our_client';

    protected $fillable = [
        'name',
        'image',
    ];
}
