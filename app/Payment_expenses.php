<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_expenses extends Model
{
    protected $connection = 'client';
    protected $table = 'payment_expenses';
}
