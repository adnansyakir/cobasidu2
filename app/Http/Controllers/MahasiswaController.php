<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    private function role(): string
    {
        return Auth::user()->getRoleName();
    }

    /**
     * Display a listing of mahasiswa.
     */
    public function index()
    {
        $data = Mahasiswa::with(['prodi.jurusan', 'user'])
            ->orderBy('nama_mahasiswa')
            ->get();

        $prodiList = Prodi::with('jurusan')->orderBy('nama_prodi')->get();

        return view($this->role() . '.mahasiswa', compact('data', 'prodiList'));
    }

    /**
     * Store a newly created mahasiswa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa'    => 'required|string|max:150',
            'npm'               => 'required|string|max:20|unique:mahasiswa,npm',
            'jenis_kelamin'     => 'required|in:L,P',
            'tgl_lahir'         => 'nullable|date',
            'jalur_masuk'       => 'nullable|string|max:100',
            'pendaftaran'       => 'nullable|string|max:100',
            'prodi_id'          => 'required|exists:prodi,id',
            'status_akademik'   => 'required|string|max:50',
            'nilai_ukt'         => 'nullable|numeric|min:0',
        ]);

        $email    = $request->npm . '@mahasiswa.ac.id';
        $password = $request->npm;

        DB::beginTransaction();
        try {
            // Create user account for the mahasiswa
            $mahasiswaRole = Role::where('nama_role', 'Mahasiswa')->first();
            $user = User::create([
                'username'  => $request->npm,
                'email'     => $email,
                'password'  => Hash::make($password),
                'role_id'   => $mahasiswaRole ? $mahasiswaRole->id : 5,
            ]);

            // Get or create a tahun_masuk record
            $tahunMasukId = DB::table('tahun_masuk')->value('id');
            if (!$tahunMasukId) {
                // Create a default tahun_masuk if none exists
                $tahunAkademikId = DB::table('tahun_akademik')->value('id');
                if (!$tahunAkademikId) {
                    $tahunAkademikId = DB::table('tahun_akademik')->insertGetId([
                        'tahun_akademik' => date('Y') . '/' . (date('Y') + 1),
                        'semester'       => 'Ganjil',
                        'status'         => 'Aktif',
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
                $tahunMasukId = DB::table('tahun_masuk')->insertGetId([
                    'tahun'             => date('Y'),
                    'tahun_akademik_id' => $tahunAkademikId,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            // Create mahasiswa record
            Mahasiswa::create([
                'nama_mahasiswa'    => $request->nama_mahasiswa,
                'npm'               => $request->npm,
                'jenis_kelamin'     => $request->jenis_kelamin,
                'tgl_lahir'         => $request->tgl_lahir,
                'jalur_masuk'       => $request->jalur_masuk,
                'pendaftaran'       => $request->pendaftaran,
                'prodi_id'          => $request->prodi_id,
                'status_akademik'   => $request->status_akademik,
                'nilai_ukt'         => $request->nilai_ukt ?? 0,
                'user_id'           => $user->id,
                'tahun_masuk_id'    => $tahunMasukId,
            ]);

            DB::commit();
            return back()->with('success', 'Data mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan mahasiswa: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified mahasiswa.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nama_mahasiswa'    => 'required|string|max:150',
            'npm'               => ['required', 'string', 'max:20', Rule::unique('mahasiswa', 'npm')->ignore($mahasiswa->id)],
            'jenis_kelamin'     => 'required|in:L,P',
            'tgl_lahir'         => 'nullable|date',
            'jalur_masuk'       => 'nullable|string|max:100',
            'pendaftaran'       => 'nullable|string|max:100',
            'prodi_id'          => 'required|exists:prodi,id',
            'status_akademik'   => 'required|string|max:50',
            'nilai_ukt'         => 'nullable|numeric|min:0',
        ]);

        $mahasiswa->update([
            'nama_mahasiswa'    => $request->nama_mahasiswa,
            'npm'               => $request->npm,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tgl_lahir'         => $request->tgl_lahir,
            'jalur_masuk'       => $request->jalur_masuk,
            'pendaftaran'       => $request->pendaftaran,
            'prodi_id'          => $request->prodi_id,
            'status_akademik'   => $request->status_akademik,
            'nilai_ukt'         => $request->nilai_ukt ?? 0,
        ]);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified mahasiswa.
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $userId = $mahasiswa->user_id;

        DB::beginTransaction();
        try {
            // Delete mahasiswa FIRST (because of FK constraint on user_id)
            $mahasiswa->delete();

            // Then delete the associated user account
            if ($userId) {
                User::where('id', $userId)->delete();
            }

            DB::commit();
            return back()->with('success', 'Data mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus mahasiswa: ' . $e->getMessage());
        }
    }
}
