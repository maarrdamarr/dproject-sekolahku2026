<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // ⬅️ WAJIB

class StudentProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('student.profile', [
            'user' => $user,
            'profile' => $user->profile,
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

        // ✅ INTELEPHENSE AMAN
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
