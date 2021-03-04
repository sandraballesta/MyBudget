<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    use HasFactory;
    protected $table = 'goals';
    protected $primaryKey= 'id';
    protected $userID;
    protected $total;
    protected $wanted;


    protected $fillable = [
        'userID',
        'total',
        'wanted'
    ];
}

