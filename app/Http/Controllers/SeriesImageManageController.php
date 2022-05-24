<?php

namespace App\Http\Controllers;

use App\Events\SeriesImageUpdated;
use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\Series\SeriesImageManageControllerTest;

class SeriesImageManageController extends Controller
{
    public static function testedBy(){
        return SeriesImageManageControllerTest::class;
    }

    public static function update(Request $request){

        $request->validate([
            'image'=>['image', 'dimensions:min_height=400,ratio=16/9,max_size:2000'],
        ]);

        $serie = Serie::findOrFail($request->id);

        $serie->image = $request->file('image')->store('series','public');

        $serie->save();

        session()->flash('status', __('Successfully updated'));

        SeriesImageUpdated::dispatch($serie);

        return back()->withInput();
    }
}
