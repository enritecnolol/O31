<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchases extends Model
{
    //
    protected $connection = 'client';
    protected $table = 'purchases';
}
