<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Tests\Feature\Http\Controllers\SeriesImageManageControllerTest;

class SeriesImageManageController extends Controller
{
    public static function testedBy(){
        return SeriesImageManageControllerTest::class;
    }

    public static function update(Request $request){
        $serie = Serie::findOrFail($request->id);

        $serie->image = $path = $request->file('image')->store('series');

        $serie->save();

        return back()->withInput();
    }
}
