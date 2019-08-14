<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tax extends Model
{
    public $timestamps = false;

    public static function getRate($county_id, $tax_id)
    {
        return DB::table('taxes_rates')
            ->where('tax_id', $tax_id)
            ->where('county_id', $county_id)
            ->value('rate');
    }
}
