<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Tests\Feature\SeriesApiTest;

class SeriesApiController extends Controller
{
    public static function testedBy()
    {
        return SeriesApiTest::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Serie::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Serie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
            'teacher_name' => $request->teracher_name,
            'teacher_photo_url' => $request->teacher_photo_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Serie::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $serie = Serie::findOrFail($id);
        $serie ->title = $request->title;
        $serie ->description = $request->description;
        $serie ->image = $request->image;
        $serie ->teacher_name = $request->teacher_name;
        $serie ->teacher_photo_url = $request->teacher_photo_url;
        $serie->save();
        return $serie;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();
        return $serie;
    }
}
