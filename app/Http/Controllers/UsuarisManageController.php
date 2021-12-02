<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        session()->flash('success', 'Successfully added');

        return redirect()->route('manage.users');
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
        User::find($id)->delete();

        session()->flash('status', 'Successfully deleted');

        return redirect()->route('manage.users');
    }
}
