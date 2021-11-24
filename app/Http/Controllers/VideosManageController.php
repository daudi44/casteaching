<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideosManageController extends Controller
{
    //CRUD
    /**
     * R -> Retrieve -> Llista
     */
    public function index()
    {
        //
    }

    /**
     * C -> Create -> Mostra el formulari de creació
     */
    public function create()
    {
        //
    }

    /**
     * C -> Create -> Guardarà a la base de dades el nou vídeo
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * U -> Update -> Processarà el form i guardarà les modificacions
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * D -> Delete
     */
    public function destroy($id)
    {
        //
    }
}
