<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;

    public function county()
    {
        return $this->belongsTo('App\Models\County');
    }

    public function tax()
    {
        return $this->belongsTo('App\Models\Tax');
    }
}
