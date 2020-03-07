<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchaseOrder extends Model
{
    //
    protected $connection = 'client';
    protected $table = 'purchase_orders';
}
