<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typepay extends Model
{
    /**
     * Get the phone record associated with the user.
     */
    public function facture()
    {
        return $this->hasOne('App\Facture');
    }
}
