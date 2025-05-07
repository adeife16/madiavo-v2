<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'phone' => 'sometimes|string|max:255',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'sometimes|string|max:255',
            'twitter' => 'sometimes|string|max:255',
            'linkedin' => 'sometimes|string|max:255',
            'instagram' => 'sometimes|string|max:255',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar && \Storage::exists('avatars/'.$user->avatar)) {
                \Storage::delete('avatars/'.$user->avatar);
            }

            $avatar = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatar;
        }   

        $user->update($request->only('first_name', 'last_name', 'email', 'phone', 'avatar', 'facebook', 'twitter', 'linkedin', 'instagram', 'role'));

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => 'Password updated successfully.']);
    }
}
