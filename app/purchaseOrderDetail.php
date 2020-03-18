<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchaseOrderDetail extends Model
{
    //
    protected $connection = 'client';
    protected $table = 'purchase_order_details';
}
