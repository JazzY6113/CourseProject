<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        try {
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->patronymic = $request->patronymic;
            $user->email      = $request->email;

            if ($request->hasFile('avatar')) {
                $this->handleAvatarUpload($request->file('avatar'), $user);
            }

            $user->save();

            return back()->with('success', 'Данные успешно обновлены!');

        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при обновлении данных.');
        }
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        try {
            $user->deleteAvatar();
            return back()->with('success', 'Аватар успешно удален!');
        } catch (\Exception $e) {
            Log::error('Avatar deletion error: ' . $e->getMessage());
            return back()->with('error', 'Произошла ошибка при удалении аватара.');
        }
    }

    /**
     * Handle avatar upload
     */
    private function handleAvatarUpload($file, $user)
    {
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'avatar_' . $user->id . '_' . time() . '.' . $extension;

        // Store the file
        $path = $file->storeAs('avatars', $filename, 'public');

        $user->avatar = $path;
    }
}
