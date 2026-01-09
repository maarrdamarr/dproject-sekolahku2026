<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);

        /** @var User $user */
        $user = Auth::user();

        // ✅ INTELEPHENSE AMAN
        if ($user->profile) {
            $user->profile->update([
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'address'   => $request->address,
            ]);
        } else {
            $user->profile()->create([
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'address'   => $request->address,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
