<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
//    protected $table = 'cajas';
    protected $connection = 'client';
    protected $fillable = ['fecha_cierre', 'total_venta', 'total_cierre'];
}
