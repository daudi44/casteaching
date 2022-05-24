<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Users\UsuarisManageControllerTest;

class UsuarisManageController extends Controller
{
    public static function testedBy()
    {
        return UsuarisManageControllerTest::class;
    }
    public function index()
    {
        return view('users.manage.index_usuaris',[
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

    public function edit($id)
    {
        return view('users.manage.edit_usuaris', ['user'=>User::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $user =User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('status', 'Successfully changed');
        return redirect()->route('manage.users');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        session()->flash('status', 'Successfully deleted');

        return redirect()->route('manage.users');
    }
}
