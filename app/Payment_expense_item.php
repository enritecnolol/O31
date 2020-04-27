<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_expense_item extends Model
{
    protected $connection = 'client';
    protected $table = 'payment_expense_item';

}
