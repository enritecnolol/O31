<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    /**
     * Get the phone record associated with the user.
     */
    public function typepay()
    {
        return $this->hasOne('App\typepay');
    }
    /**
     * Get the comments for the blog post.
     */
    public function detail()
    {
        return $this->hasMany('App\Detail');
    }
    public function ultimoid(){
        $id = Facture::query('SELECT id FROM `factures` WHERE id =(Select MAX(id) from factures)');
        return $id;
    }

}
