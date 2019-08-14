<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class State extends Model
{
    public $timestamps = false;

    public function counties()
    {
        return $this->hasMany('App\Models\County');
    }

    public static function getCountiesTaxStatistics()
    {
        $sql = "SELECT
            s.name AS `state`,
            c.name AS `county`,
            AVG(tr.rate) AS `rate_avg`,
            SUM(p.amount) AS `payment_total`
        FROM
            counties c
        INNER JOIN
            states s
                ON
                    c.state_id = s.id
        INNER JOIN
            taxes_rates tr
                ON
                    tr.county_id = c.id
        LEFT JOIN
            payments p
                ON
                    p.county_id = c.id
        GROUP BY
            c.id
        ORDER BY
            s.name ASC,
            c.name ASC";

        return DB::select($sql);
    }

    public static function getStatesTaxStatistics()
    {
        $sql = "SELECT
            s.id,
            s.name,
            AVG(tr.rate) AS rate_avg,
            SUM(p.amount) AS payment_total,
            AVG(p.amount) AS payment_avg
        FROM
            states s
        INNER JOIN
            counties c
                ON
                    c.state_id = s.id
        INNER JOIN
            taxes_rates tr
                ON
                    tr.county_id = c.id
        LEFT JOIN
            payments p
                ON
                    p.county_id = c.id
        GROUP BY
            s.id
        ORDER BY
            s.name ASC";

        return DB::select($sql);
    }

    public static function getTaxesRatesOverview()
    {
        $rows = DB::select(
            "SELECT
                s.id AS `state_id`,
                s.name AS `state_name`,
                c.id AS `county_id`,
                c.name AS `county_name`,
                tr.rate AS `tax_rate`,
                t.name AS `tax_name`,
                t.id AS `tax_id`
            FROM
                states s
            INNER JOIN
                counties c
                    ON
                        c.state_id = s.id
            INNER JOIN
                taxes_rates tr
                    ON
                        tr.county_id = c.id
            INNER JOIN
                taxes t
                    ON
                        t.id = tr.tax_id"
        );
        $result = [
            'taxes' => [],
            'states' => [],
            'counties' => [],
            'rates' => [],
        ];
        foreach ($rows as $row) {
            if (!isset($result['taxes'][$row->tax_id])) {
                $result['taxes'][$row->tax_id] = $row->tax_name;
            }
            if (!isset($result['states'][$row->state_id])) {
                $result['states'][$row->state_id] = $row->state_name;
            }
            if (!isset($result['counties'][$row->county_id])) {
                $result['counties'][$row->county_id] = $row->county_name;
            }
            $result['rates'][$row->state_id][$row->county_id][$row->tax_id] = $row->tax_rate;
        }
        return $result;
    }
}
