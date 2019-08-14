<?php

namespace App\Http\Controllers;

use App\Models\State;

class HomeController extends Controller
{

    /**
     * Show the application dashboard - some public statistics.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states_stats = State::getStatesTaxStatistics();
        $counties_stats = State::getCountiesTaxStatistics();

        return view(
            'home',
            [
                'states_stats' => $states_stats,
                'counties_stats' => $counties_stats,
            ]
        );
    }
}
