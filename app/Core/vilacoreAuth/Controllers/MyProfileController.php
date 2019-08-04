<?php

namespace App\Core\vilacoreAuth\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Request;

class MyProfileController extends BaseController
{
    public function index()
    {
        return view('vilacoreAuth::views.index');
    }
    
    public function kelola()
    {
        return view('vilacoreAuth::views.kelola');
    }

    public function change(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if (Auth()->user()->email != $request->email) $request->validate([ 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'] ]);
        
        $user = \App\User::find(Auth()->user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Berhasil memperbarui profil.']]);
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = \App\User::find(Auth()->user()->id)->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with(['alert' => ['type' => 'success', 'text' => 'Berhasil memperbarui password.']]);
    }
}