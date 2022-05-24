<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\Series\SeriesManageControllerTest;

class SeriesManageController extends Controller
{
    public static function testedBy()
    {
        return SeriesManageControllerTest::class;
    }
    public function index()
    {
        return view('series.manage.index_series',[
            'series' => Serie::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        Serie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'teacher_name' => $request->teacher_name,
        ]);

        session()->flash('success', 'Successfully added');

        return redirect()->route('manage.series');
    }

    public function edit($id)
    {
        return view('series.manage.edit_series', ['serie'=>Serie::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $serie =Serie::findOrFail($id);
        $serie->title = $request->title;
        $serie->description = $request->description;
        $serie->save();

        session()->flash('status', 'Successfully changed');
        return redirect()->route('manage.series');
    }

    public function destroy($id)
    {
        Serie::find($id)->delete();

        session()->flash('status', 'Successfully deleted');

        return redirect()->route('manage.series');
    }
}
