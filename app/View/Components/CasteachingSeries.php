<?php

namespace App\View\Components;

use App\Models\Serie;
use Illuminate\View\Component;
use Tests\Feature\CastechingSeriesTest;

class CasteachingSeries extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $series = Serie::all();
        return view('components.casteaching-series', [
            'series' =>$series
        ]);
    }

    public static function testedBY()
    {
        return CastechingSeriesTest::class;
    }
}
