<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show profile page for the authenticated user.
     */
    public function show()
    {
        $user = Auth::user();
        $role = $user->getRoleName();

        return view("{$role}.profile", [
            'user' => $user,
        ]);
    }

    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $role = $user->getRoleName();

        $rules = [
            'nama_lengkap' => 'nullable|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 1000 karakter.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
        ];

        $validated = $request->validate($rules, $messages);

        // Handle foto upload
        if ($request->hasFile('foto_profil')) {
            // Delete old photo if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $foto = $request->file('foto_profil');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('profil', $filename, 'public');
            $validated['foto_profil'] = $path;
        }

        $user->update($validated);

        return redirect()->route("{$role}.profile")->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $role = $user->getRoleName();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.'])->withInput();
        }

        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->route("{$role}.profile")->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        $role = $user->getRoleName();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->update(['foto_profil' => null]);

        return redirect()->route("{$role}.profile")->with('success', 'Foto profil berhasil dihapus!');
    }
}
