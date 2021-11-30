<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarisManageController extends Controller
{
    public static function testedBy()
    {
        return UsuarisManageController::class;
    }
    public function index()
    {
        return view('videos.manage.index_usuaris',[
            'users' => User::all()
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
