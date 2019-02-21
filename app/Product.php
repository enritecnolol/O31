<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'client';
    /**
     * Get the post that owns the comment.
     */
    public function detail()
    {
        return $this->belongsTo('App\Detail');
    }
    /**
     * Get the phone record associated with the user.
     */
    public function unity()
    {
        return $this->hasOne('App\Unity');
    }
}
