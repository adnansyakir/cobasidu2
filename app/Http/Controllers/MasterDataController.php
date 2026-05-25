<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use App\Models\TahunMasuk;
use App\Models\PeriodeBilling;
use App\Models\RentangUkt;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\Role;
use App\Models\StatusPembayaran;
use App\Models\SumberPembiayaan;
use App\Models\LevelUkt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MasterDataController extends Controller
{
    private function role(): string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user->getRoleName();
    }

    // === TAHUN AKADEMIK ===

    public function tahunAkademikIndex()
    {
        $data = TahunAkademik::orderByDesc('tahun_akademik')->orderByDesc('semester')->get();
        return view($this->role() . '.master-data.tahun-akademik', compact('data'));
    }

    public function tahunAkademikStore(Request $request)
    {
        $request->validate(['tahun_akademik'=>'required|string|max:20','semester'=>'required|in:Ganjil,Genap','status'=>'required|in:Aktif,Tidak Aktif']);
        TahunAkademik::create($request->only('tahun_akademik','semester','status'));
        return back()->with('success','Tahun akademik berhasil ditambahkan!');
    }

    public function tahunAkademikUpdate(Request $request, $id)
    {
        $request->validate(['tahun_akademik'=>'required|string|max:20','semester'=>'required|in:Ganjil,Genap','status'=>'required|in:Aktif,Tidak Aktif']);
        TahunAkademik::findOrFail($id)->update($request->only('tahun_akademik','semester','status'));
        return back()->with('success','Tahun akademik berhasil diperbarui!');
    }

    public function tahunAkademikDestroy($id)
    {
        TahunAkademik::findOrFail($id)->delete();
        return back()->with('success','Tahun akademik berhasil dihapus!');
    }

    // === JURUSAN ===

    public function jurusanIndex()
    {
        $data = Jurusan::withCount('prodi')->orderBy('nama_jurusan')->get();
        return view($this->role() . '.master-data.jurusan', compact('data'));
    }

    public function jurusanStore(Request $request)
    {
        $request->validate(['kode_jurusan'=>'required|string|max:20|unique:jurusan,kode_jurusan','nama_jurusan'=>'required|string|max:255']);
        Jurusan::create($request->only('kode_jurusan','nama_jurusan'));
        return back()->with('success','Jurusan berhasil ditambahkan!');
    }

    public function jurusanUpdate(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $request->validate(['kode_jurusan'=>'required|string|max:20|unique:jurusan,kode_jurusan,'.$jurusan->id,'nama_jurusan'=>'required|string|max:255']);
        $jurusan->update($request->only('kode_jurusan','nama_jurusan'));
        return back()->with('success','Jurusan berhasil diperbarui!');
    }

    public function jurusanDestroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        if ($jurusan->prodi()->count() > 0) return back()->with('error','Jurusan tidak bisa dihapus karena masih memiliki program studi.');
        $jurusan->delete();
        return back()->with('success','Jurusan berhasil dihapus!');
    }

    // === PRODI ===

    public function prodiIndex()
    {
        $data = Prodi::with('jurusan')->withCount('mahasiswa')->orderBy('nama_prodi')->get();
        $jurusanList = Jurusan::orderBy('nama_jurusan')->get();
        return view($this->role() . '.master-data.prodi', compact('data','jurusanList'));
    }

    public function prodiStore(Request $request)
    {
        $request->validate(['kode_prodi'=>'required|string|max:20|unique:prodi,kode_prodi','nama_prodi'=>'required|string|max:255','jenjang_prodi'=>'required|in:D3,D4,S1,S2,S3','jurusan_id'=>'required|exists:jurusan,id']);
        Prodi::create($request->only('kode_prodi','nama_prodi','jenjang_prodi','jurusan_id'));
        return back()->with('success','Program studi berhasil ditambahkan!');
    }

    public function prodiUpdate(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);
        $request->validate(['kode_prodi'=>'required|string|max:20|unique:prodi,kode_prodi,'.$prodi->id,'nama_prodi'=>'required|string|max:255','jenjang_prodi'=>'required|in:D3,D4,S1,S2,S3','jurusan_id'=>'required|exists:jurusan,id']);
        $prodi->update($request->only('kode_prodi','nama_prodi','jenjang_prodi','jurusan_id'));
        return back()->with('success','Program studi berhasil diperbarui!');
    }

    public function prodiDestroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        if ($prodi->mahasiswa()->count() > 0) return back()->with('error','Prodi tidak bisa dihapus karena masih memiliki mahasiswa.');
        $prodi->delete();
        return back()->with('success','Program studi berhasil dihapus!');
    }

    // === USERS (Admin only) ===

    public function usersIndex()
    {
        $data = User::with('role')->orderBy('username')->get();
        $roles = Role::orderBy('nama_role')->get();
        return view('admin.master-data.users', compact('data','roles'));
    }

    public function usersStore(Request $request)
    {
        $request->validate(['username'=>'required|string|max:255|unique:users,username','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:8','role_id'=>'required|exists:role,id']);
        User::create(['username'=>$request->username,'email'=>$request->email,'password'=>$request->password,'role_id'=>$request->role_id]);
        return back()->with('success','User berhasil ditambahkan!');
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['username'=>['required','string','max:255',Rule::unique('users')->ignore($user->id)],'email'=>['required','email','max:255',Rule::unique('users')->ignore($user->id)],'role_id'=>'required|exists:role,id']);
        $updateData = $request->only('username','email','role_id');
        if ($request->filled('password')) {
            $request->validate(['password'=>'string|min:8']);
            $updateData['password'] = $request->password;
        }
        $user->update($updateData);
        return back()->with('success','User berhasil diperbarui!');
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) return back()->with('error','Tidak bisa menghapus akun sendiri.');
        $user->delete();
        return back()->with('success','User berhasil dihapus!');
    }

    // === ROLE (Admin only) ===

    public function roleIndex()
    {
        $data = Role::withCount('users')->orderBy('nama_role')->get();
        return view('admin.master-data.role', compact('data'));
    }

    public function roleStore(Request $request)
    {
        $request->validate(['nama_role'=>'required|string|max:255|unique:role,nama_role']);
        Role::create($request->only('nama_role'));
        return back()->with('success','Role berhasil ditambahkan!');
    }

    public function roleUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate(['nama_role'=>'required|string|max:255|unique:role,nama_role,'.$role->id]);
        $role->update($request->only('nama_role'));
        return back()->with('success','Role berhasil diperbarui!');
    }

    public function roleDestroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->users()->count() > 0) return back()->with('error','Role tidak bisa dihapus karena masih memiliki user.');
        $role->delete();
        return back()->with('success','Role berhasil dihapus!');
    }

    // === STATUS PEMBAYARAN ===

    public function statusPembayaranIndex()
    {
        $data = StatusPembayaran::orderBy('id')->get();
        return view($this->role() . '.master-data.status-pembayaran', compact('data'));
    }

    public function statusPembayaranStore(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:100|unique:status_pembayaran,nama_status',
            'keterangan'  => 'nullable|string',
        ]);
        StatusPembayaran::create($request->only('nama_status', 'keterangan'));
        return back()->with('success', 'Status pembayaran berhasil ditambahkan!');
    }

    public function statusPembayaranUpdate(Request $request, $id)
    {
        $item = StatusPembayaran::findOrFail($id);
        $request->validate([
            'nama_status' => 'required|string|max:100|unique:status_pembayaran,nama_status,' . $id,
            'keterangan'  => 'nullable|string',
        ]);
        $item->update($request->only('nama_status', 'keterangan'));
        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function statusPembayaranDestroy($id)
    {
        StatusPembayaran::findOrFail($id)->delete();
        return back()->with('success', 'Status pembayaran berhasil dihapus!');
    }

    // === SUMBER PEMBIAYAAN ===

    public function sumberPembiayaanIndex()
    {
        $data = SumberPembiayaan::orderBy('id')->get();
        return view($this->role() . '.master-data.sumber-pembiayaan', compact('data'));
    }

    public function sumberPembiayaanStore(Request $request)
    {
        $request->validate([
            'nama_sumber' => 'required|string|max:100|unique:sumber_pembiayaan,nama_sumber',
        ]);
        SumberPembiayaan::create($request->only('nama_sumber'));
        return back()->with('success', 'Sumber pembiayaan berhasil ditambahkan!');
    }

    public function sumberPembiayaanUpdate(Request $request, $id)
    {
        $item = SumberPembiayaan::findOrFail($id);
        $request->validate([
            'nama_sumber' => 'required|string|max:100|unique:sumber_pembiayaan,nama_sumber,' . $id,
        ]);
        $item->update($request->only('nama_sumber'));
        return back()->with('success', 'Sumber pembiayaan berhasil diperbarui!');
    }

    public function sumberPembiayaanDestroy($id)
    {
        SumberPembiayaan::findOrFail($id)->delete();
        return back()->with('success', 'Sumber pembiayaan berhasil dihapus!');
    }

    // === TAHUN MASUK (Admin only) ===

    public function tahunMasukIndex()
    {
        $data = TahunMasuk::with('tahunAkademik')->orderByDesc('tahun')->get();
        $tahunAkademikList = TahunAkademik::orderByDesc('tahun_akademik')->get();
        return view('admin.master-data.tahun-masuk', compact('data', 'tahunAkademikList'));
    }

    public function tahunMasukStore(Request $request)
    {
        $request->validate([
            'tahun'             => 'required|string|max:10|unique:tahun_masuk,tahun',
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
        ]);
        TahunMasuk::create($request->only('tahun', 'tahun_akademik_id'));
        return back()->with('success', 'Tahun masuk berhasil ditambahkan!');
    }

    public function tahunMasukUpdate(Request $request, $id)
    {
        $item = TahunMasuk::findOrFail($id);
        $request->validate([
            'tahun'             => 'required|string|max:10|unique:tahun_masuk,tahun,' . $id,
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
        ]);
        $item->update($request->only('tahun', 'tahun_akademik_id'));
        return back()->with('success', 'Tahun masuk berhasil diperbarui!');
    }

    public function tahunMasukDestroy($id)
    {
        TahunMasuk::findOrFail($id)->delete();
        return back()->with('success', 'Tahun masuk berhasil dihapus!');
    }

    // === LEVEL UKT ===

    public function levelUktIndex()
    {
        $data = LevelUkt::orderBy('id')->get();
        return view($this->role() . '.master-data.level-ukt', compact('data'));
    }

    public function levelUktStore(Request $request)
    {
        $request->validate([
            'nama_level' => 'required|string|max:100|unique:level_ukt,nama_level',
            'keterangan' => 'nullable|string',
        ]);
        LevelUkt::create($request->only('nama_level', 'keterangan'));
        return back()->with('success', 'Level UKT berhasil ditambahkan!');
    }

    public function levelUktUpdate(Request $request, $id)
    {
        $item = LevelUkt::findOrFail($id);
        $request->validate([
            'nama_level' => 'required|string|max:100|unique:level_ukt,nama_level,' . $id,
            'keterangan' => 'nullable|string',
        ]);
        $item->update($request->only('nama_level', 'keterangan'));
        return back()->with('success', 'Level UKT berhasil diperbarui!');
    }

    public function levelUktDestroy($id)
    {
        LevelUkt::findOrFail($id)->delete();
        return back()->with('success', 'Level UKT berhasil dihapus!');
    }

    // === PERIODE BILLING (Keuangan only) ===

    public function periodeBillingIndex()
    {
        $data = PeriodeBilling::with('tahunAkademik')->orderByDesc('id')->get();
        $tahunAkademikList = TahunAkademik::orderByDesc('tahun_akademik')->get();
        $tahunList = $tahunAkademikList->pluck('tahun_akademik')->unique()->values();
        return view('keuangan.periode-billing', compact('data', 'tahunAkademikList', 'tahunList'));
    }

    public function periodeBillingStore(Request $request)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'periode_mulai'     => 'required|date',
            'periode_selesai'   => 'required|date|after_or_equal:periode_mulai',
            'status'            => 'required|in:Aktif,Tidak Aktif',
        ]);
        PeriodeBilling::create($request->only('tahun_akademik_id', 'periode_mulai', 'periode_selesai', 'status'));
        return back()->with('success', 'Periode billing berhasil ditambahkan!');
    }

    public function periodeBillingUpdate(Request $request, $id)
    {
        $item = PeriodeBilling::findOrFail($id);
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'periode_mulai'     => 'required|date',
            'periode_selesai'   => 'required|date|after_or_equal:periode_mulai',
        ]);
        $item->update($request->only('tahun_akademik_id', 'periode_mulai', 'periode_selesai'));
        return back()->with('success', 'Periode billing berhasil diperbarui!');
    }

    public function periodeBillingToggle($id)
    {
        $item = PeriodeBilling::findOrFail($id);
        $item->update(['status' => $item->status === 'Aktif' ? 'Tidak Aktif' : 'Aktif']);
        return back()->with('success', 'Status periode billing berhasil diubah!');
    }

    public function periodeBillingDestroy($id)
    {
        PeriodeBilling::findOrFail($id)->delete();
        return back()->with('success', 'Periode billing berhasil dihapus!');
    }

    // === RENTANG UKT (Keuangan only) ===

    public function rentangUktIndex()
    {
        $data = RentangUkt::with('prodi.jurusan', 'tahunMasuk.tahunAkademik', 'levelUkt')
            ->orderBy('prodi_id')->orderBy('tahun_masuk_id')->orderBy('level_ukt_id')
            ->get()
            ->groupBy(fn($r) => $r->prodi_id . '_' . $r->tahun_masuk_id);

        $prodiList     = Prodi::orderBy('nama_prodi')->get();
        $tahunMasukList = TahunMasuk::with('tahunAkademik')->orderByDesc('tahun')->get();
        $levelUktList  = LevelUkt::orderBy('id')->get();

        return view('keuangan.master-data.rentang-ukt', compact('data', 'prodiList', 'tahunMasukList', 'levelUktList'));
    }

    public function rentangUktCreate()
    {
        $prodiList      = Prodi::orderBy('nama_prodi')->get();
        $tahunMasukList = TahunMasuk::with('tahunAkademik')->orderByDesc('tahun')->get();
        $levelUktList   = LevelUkt::orderBy('id')->get();

        return view('keuangan.master-data.rentang-ukt-create', compact('prodiList', 'tahunMasukList', 'levelUktList'));
    }

    public function rentangUktStore(Request $request)
    {
        $request->validate([
            'prodi_id'       => 'required|exists:prodi,id',
            'tahun_masuk_id' => 'required|exists:tahun_masuk,id',
            'nilai'          => 'required|array',
            'nilai.*'        => 'nullable|integer|min:0',
            'akun_rekening'  => 'nullable|array',
            'akun_rekening.*'=> 'nullable|string|max:100',
        ]);

        foreach ($request->nilai as $levelUktId => $nilai) {
            RentangUkt::updateOrCreate(
                [
                    'prodi_id'       => $request->prodi_id,
                    'tahun_masuk_id' => $request->tahun_masuk_id,
                    'level_ukt_id'   => $levelUktId,
                ],
                [
                    'nilai'         => $nilai ?? 0,
                    'akun_rekening' => $request->akun_rekening[$levelUktId] ?? null,
                ]
            );
        }

        return back()->with('success', 'Konfigurasi UKT berhasil disimpan!');
    }

    public function rentangUktUpdate(Request $request, $id)
    {
        $item = RentangUkt::findOrFail($id);
        $request->validate([
            'nilai'         => 'required|integer|min:0',
            'akun_rekening' => 'nullable|string|max:100',
        ]);
        $item->update($request->only('nilai', 'akun_rekening'));
        return back()->with('success', 'Rentang UKT berhasil diperbarui!');
    }

    public function rentangUktDestroy($id)
    {
        RentangUkt::findOrFail($id)->delete();
        return back()->with('success', 'Rentang UKT berhasil dihapus!');
    }

    public function rentangUktDestroyGroup($prodi_id, $tahun_masuk_id)
    {
        RentangUkt::where('prodi_id', $prodi_id)->where('tahun_masuk_id', $tahun_masuk_id)->delete();
        return back()->with('success', 'Konfigurasi UKT berhasil dihapus!');
    }
}
