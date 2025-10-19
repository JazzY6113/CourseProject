<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->patronymic = $request->patronymic;
        $user->email      = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Данные успешно обновлены!');
    }
}
