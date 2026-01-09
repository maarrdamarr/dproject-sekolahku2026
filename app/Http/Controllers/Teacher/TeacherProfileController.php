<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('teacher.profile', [
            'user' => $user,
            'profile' => $user->profile,
            'teacher' => $user->teacher,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string',
            'photo'     => 'nullable|image|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');
        }

        if ($user->profile) {
            $payload = [
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'address'   => $request->address,
            ];

            if ($photoPath) {
                if ($user->profile->photo) {
                    Storage::disk('public')->delete($user->profile->photo);
                }
                $payload['photo'] = $photoPath;
            }

            $user->profile->update($payload);
        } else {
            $user->profile()->create([
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'photo'     => $photoPath,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
