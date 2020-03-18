<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $connection = 'client';
    protected $table = 'purchase_returns';
}
