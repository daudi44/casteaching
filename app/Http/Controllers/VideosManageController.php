<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class
VideosManageController extends Controller
{
    public static function testedBy()
    {
        return VideosManageController::class;
    }

    //CRUD
    /**
     * R -> Retrieve -> Llista
     */
    public function index()
    {
        return view('videos.manage.index',[
            'videos' => Video::all()
        ]);
    }

    /**
     * C -> Create -> Guardarà a la base de dades el nou vídeo
     */
    public function store(Request $request)
    {
        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url
        ]);

        session()->flash('success', 'Successfully added');

        return redirect()->route('manage.videos');

//        return response()->view('videos.manage.index', ['videos'=>[]], 201);
    }

    /**
     * R -> No llista -> Individual ->
     */
    public function show($id)
    {
        //
    }

    /**
     * U -> Update -> Form
     */
    public function edit($id)
    {
        return view('videos.manage.edit', ['video'=>Video::findOrFail($id)]);
    }

    /**
     * U -> Update -> Processarà el form i guardarà les modificacions
     */
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->url = $request->url;

        $video->save();

        session()->flash('status', 'Successfully changed');
        return redirect()->route('manage.videos');
    }

    /**
     * D -> Delete
     */
    public function destroy($id)
    {
        Video::find($id)->delete();

        session()->flash('status', 'Successfully deleted');

        return redirect()->route('manage.videos');
    }
}
