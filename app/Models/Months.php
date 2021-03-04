<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Months extends Model
{
    use HasFactory;

    protected $table = 'months';
    protected $primaryKey= 'id';
    protected $userID;
    protected $income;
    protected $fixed;
    protected $available;
    protected $total_expenses;
    protected $dailyBudget;


    protected $fillable = [
        'userID',
        'income',
        'fixed',
        'dailyBudget',
        'available',
        'total_expenses',
    ];
}
