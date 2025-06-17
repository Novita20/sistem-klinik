<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'remove_photo' => ['nullable'],
        ]);

        // Update data biasa
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Hapus foto profil jika diminta
        if ($request->input('remove_photo') === '1') {
            if ($user->profile_picture && file_exists(public_path('assets/dist/img/' . $user->profile_picture))) {
                unlink(public_path('assets/dist/img/' . $user->profile_picture));
            }
            $user->profile_picture = null;
        }

        // Upload foto baru jika ada
        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/dist/img'), $filename);
            $user->profile_picture = $filename;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
