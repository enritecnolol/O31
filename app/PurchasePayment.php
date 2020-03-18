<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    //
    protected $connection = 'client';
    protected $table = 'purchase_payments';
}
