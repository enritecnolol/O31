<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    protected $connection = 'client';
    protected $table = 'purchase_returns_details';
}
