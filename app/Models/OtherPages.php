<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPages extends Model
{
    use HasFactory;
    public $table = 'other_pages';
    protected $fillable = [
        'id',
        'pagename',
        'description'
    ];
}
