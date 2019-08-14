<?php

namespace App\Http\Controllers;

use App\Models\State;

class RatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the rates table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rates_data = State::getTaxesRatesOverview();

        return view(
            'mgmt.rates.list',
            [
                'rates_data' => $rates_data,
            ]
        );
    }
}
