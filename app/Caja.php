<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = ['fecha_cierre', 'total_venta', 'total_cierre'];
}
