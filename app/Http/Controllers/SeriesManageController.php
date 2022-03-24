<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\Videos\SeriesManageControllerTest;

class SeriesManageController extends Controller
{
    public static function testedBy()
    {
        return SeriesManageControllerTest::class;
    }
    public function index()
    {
        return view('videos.manage.index_series',[
            'series' => Serie::all()
        ]);
    }

    public function store(Request $request)
    {
        Serie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
        ]);

        session()->flash('success', 'Successfully added');

        return redirect()->route('manage.series');
    }

    public function edit($id)
    {
        return view('videos.manage.edit_series', ['serie'=>Serie::findOrFail($id)]);
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
