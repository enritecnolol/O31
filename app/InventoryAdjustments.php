<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryAdjustments extends Model
{
    //

    protected $connection = 'client';
    protected $table = 'inventory_adjustments';
}
