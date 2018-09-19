<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function product()
    {
        return $this->hasMany('App\Product');

    }
}