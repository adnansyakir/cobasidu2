<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // =============================================
    // ADMIN
    // =============================================

    public function admin()
    {
        return view('dashboard.admin', [
            'user' => Auth::user(),
        ]);
    }



    public function adminMahasiswa()
    {
        return view('admin.mahasiswa');
    }

    public function adminMasterUsers()
    {
        return view('admin.master-data.users');
    }

    public function adminMasterRole()
    {
        return view('admin.master-data.role');
    }

    public function adminMasterTahunAkademik()
    {
        return view('admin.master-data.tahun-akademik');
    }

    public function adminMasterJurusan()
    {
        return view('admin.master-data.jurusan');
    }

    public function adminMasterProdi()
    {
        return view('admin.master-data.prodi');
    }

    public function adminInvoice()
    {
        return view('admin.invoice');
    }

    public function adminStatistikProdi()
    {
        return view('admin.statistik-prodi');
    }

    public function adminLogAktivitas()
    {
        return view('admin.log-aktivitas');
    }

    // =============================================
    // KEUANGAN
    // =============================================

    public function keuangan()
    {
        return view('dashboard.keuangan', [
            'user' => Auth::user(),
        ]);
    }



    public function keuanganMahasiswa()
    {
        return view('keuangan.mahasiswa');
    }

    public function keuanganMasterRentangUkt()
    {
        return view('keuangan.master-data.rentang-ukt');
    }

    public function keuanganMasterStatusPembayaran()
    {
        return view('keuangan.master-data.status-pembayaran');
    }

    public function keuanganMasterSumberPembiayaan()
    {
        return view('keuangan.master-data.sumber-pembiayaan');
    }

    public function keuanganMasterLevelUkt()
    {
        return view('keuangan.master-data.level-ukt');
    }

    public function keuanganBandingUkt()
    {
        return view('keuangan.banding-ukt');
    }

    public function keuanganSettingBanding()
    {
        return view('keuangan.setting-banding');
    }

    public function keuanganInvoice()
    {
        return view('keuangan.invoice');
    }

    public function keuanganSettingInvoice()
    {
        return view('keuangan.setting-invoice');
    }

    public function keuanganPeriodeBilling()
    {
        return view('keuangan.periode-billing');
    }

    // =============================================
    // AKADEMIK
    // =============================================

    public function akademik()
    {
        return view('dashboard.akademik', [
            'user' => Auth::user(),
        ]);
    }



    public function akademikMahasiswa()
    {
        return view('akademik.mahasiswa');
    }

    public function akademikMasterTahunAkademik()
    {
        return view('akademik.master-data.tahun-akademik');
    }

    public function akademikMasterJurusan()
    {
        return view('akademik.master-data.jurusan');
    }

    public function akademikMasterProdi()
    {
        return view('akademik.master-data.prodi');
    }

    // =============================================
    // DIREKTUR
    // =============================================

    public function direktur()
    {
        return view('dashboard.direktur', [
            'user' => Auth::user(),
        ]);
    }



    public function direkturStatistikProdi()
    {
        return view('direktur.statistik-prodi');
    }

    // =============================================
    // MAHASISWA
    // =============================================

    public function mahasiswa()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        return view('dashboard.mahasiswa', [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
        ]);
    }



    public function mahasiswaInvoice()
    {
        return view('mahasiswa.invoice');
    }

    public function mahasiswaRiwayatTransaksi()
    {
        return view('mahasiswa.riwayat-transaksi');
    }

    public function mahasiswaBandingUkt()
    {
        return view('mahasiswa.banding-ukt');
    }
}
