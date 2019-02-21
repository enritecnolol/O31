<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $connection = 'client';
    /**
     * Get the post that owns the comment.
     */
    public function facture()
    {
        return $this->belongsTo('App\Facture');
    }
    /**
     * Get the comments for the blog post.
     */
    public function product()
    {
        return $this->hasMany('App\Product');
    }

}
