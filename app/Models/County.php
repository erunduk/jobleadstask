<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $timestamps = false;

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }
}
