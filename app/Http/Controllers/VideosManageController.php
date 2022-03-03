<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\Feature\Videos\VideosManageControllerTest;

class
VideosManageController extends Controller
{
    public static function testedBy()
    {
        return VideosManageControllerTest::class;
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


        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'required'
        ]);

        $video = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'serie_id' => $request->serie_id
        ]);

        session()->flash('success', 'Successfully added');

        VideoCreated::dispatch($video);

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
