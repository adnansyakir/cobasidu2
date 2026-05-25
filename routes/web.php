<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\MahasiswaLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\MahasiswaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home — Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =============================================
// Guest Routes (Login Pages)
// =============================================

// Admin/Staff Login
Route::get('/masuk/admin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/masuk/admin', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Mahasiswa Login
Route::get('/login', [MahasiswaLoginController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('/login', [MahasiswaLoginController::class, 'login'])->name('mahasiswa.login.submit');

// =============================================
// Authenticated Routes (Dashboards)
// =============================================

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // =============================================
    // DASHBOARD ROUTES (tetap di /dashboard/{role})
    // =============================================
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::get('/dashboard/keuangan', [DashboardController::class, 'keuangan'])
        ->middleware('role:keuangan')
        ->name('dashboard.keuangan');

    Route::get('/dashboard/akademik', [DashboardController::class, 'akademik'])
        ->middleware('role:akademik')
        ->name('dashboard.akademik');

    Route::get('/dashboard/direktur', [DashboardController::class, 'direktur'])
        ->middleware('role:direktur')
        ->name('dashboard.direktur');

    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])
        ->middleware('role:mahasiswa')
        ->name('dashboard.mahasiswa');

    // =============================================
    // ADMIN PAGES
    // =============================================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Profile CRUD
        Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('admin.profile.delete-photo');

        // Mahasiswa CRUD
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa');
        Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
        Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
        Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
        Route::prefix('master-data')->group(function () {
            // Users CRUD
            Route::get('/users', [MasterDataController::class, 'usersIndex'])->name('admin.master-data.users');
            Route::post('/users', [MasterDataController::class, 'usersStore'])->name('admin.master-data.users.store');
            Route::put('/users/{id}', [MasterDataController::class, 'usersUpdate'])->name('admin.master-data.users.update');
            Route::delete('/users/{id}', [MasterDataController::class, 'usersDestroy'])->name('admin.master-data.users.destroy');

            // Role CRUD
            Route::get('/role', [MasterDataController::class, 'roleIndex'])->name('admin.master-data.role');
            Route::post('/role', [MasterDataController::class, 'roleStore'])->name('admin.master-data.role.store');
            Route::put('/role/{id}', [MasterDataController::class, 'roleUpdate'])->name('admin.master-data.role.update');
            Route::delete('/role/{id}', [MasterDataController::class, 'roleDestroy'])->name('admin.master-data.role.destroy');

            // Tahun Akademik CRUD
            Route::get('/tahun-akademik', [MasterDataController::class, 'tahunAkademikIndex'])->name('admin.master-data.tahun-akademik');
            Route::post('/tahun-akademik', [MasterDataController::class, 'tahunAkademikStore'])->name('admin.master-data.tahun-akademik.store');
            Route::put('/tahun-akademik/{id}', [MasterDataController::class, 'tahunAkademikUpdate'])->name('admin.master-data.tahun-akademik.update');
            Route::delete('/tahun-akademik/{id}', [MasterDataController::class, 'tahunAkademikDestroy'])->name('admin.master-data.tahun-akademik.destroy');

            // Jurusan CRUD
            Route::get('/jurusan', [MasterDataController::class, 'jurusanIndex'])->name('admin.master-data.jurusan');
            Route::post('/jurusan', [MasterDataController::class, 'jurusanStore'])->name('admin.master-data.jurusan.store');
            Route::put('/jurusan/{id}', [MasterDataController::class, 'jurusanUpdate'])->name('admin.master-data.jurusan.update');
            Route::delete('/jurusan/{id}', [MasterDataController::class, 'jurusanDestroy'])->name('admin.master-data.jurusan.destroy');

            // Prodi CRUD
            Route::get('/prodi', [MasterDataController::class, 'prodiIndex'])->name('admin.master-data.prodi');
            Route::post('/prodi', [MasterDataController::class, 'prodiStore'])->name('admin.master-data.prodi.store');
            Route::put('/prodi/{id}', [MasterDataController::class, 'prodiUpdate'])->name('admin.master-data.prodi.update');
            Route::delete('/prodi/{id}', [MasterDataController::class, 'prodiDestroy'])->name('admin.master-data.prodi.destroy');

            // Status Pembayaran CRUD
            Route::get('/status-pembayaran', [MasterDataController::class, 'statusPembayaranIndex'])->name('admin.master-data.status-pembayaran');
            Route::post('/status-pembayaran', [MasterDataController::class, 'statusPembayaranStore'])->name('admin.master-data.status-pembayaran.store');
            Route::put('/status-pembayaran/{id}', [MasterDataController::class, 'statusPembayaranUpdate'])->name('admin.master-data.status-pembayaran.update');
            Route::delete('/status-pembayaran/{id}', [MasterDataController::class, 'statusPembayaranDestroy'])->name('admin.master-data.status-pembayaran.destroy');

            // Sumber Pembiayaan CRUD
            Route::get('/sumber-pembiayaan', [MasterDataController::class, 'sumberPembiayaanIndex'])->name('admin.master-data.sumber-pembiayaan');
            Route::post('/sumber-pembiayaan', [MasterDataController::class, 'sumberPembiayaanStore'])->name('admin.master-data.sumber-pembiayaan.store');
            Route::put('/sumber-pembiayaan/{id}', [MasterDataController::class, 'sumberPembiayaanUpdate'])->name('admin.master-data.sumber-pembiayaan.update');
            Route::delete('/sumber-pembiayaan/{id}', [MasterDataController::class, 'sumberPembiayaanDestroy'])->name('admin.master-data.sumber-pembiayaan.destroy');

            // Level UKT CRUD
            Route::get('/level-ukt', [MasterDataController::class, 'levelUktIndex'])->name('admin.master-data.level-ukt');
            Route::post('/level-ukt', [MasterDataController::class, 'levelUktStore'])->name('admin.master-data.level-ukt.store');
            Route::put('/level-ukt/{id}', [MasterDataController::class, 'levelUktUpdate'])->name('admin.master-data.level-ukt.update');
            Route::delete('/level-ukt/{id}', [MasterDataController::class, 'levelUktDestroy'])->name('admin.master-data.level-ukt.destroy');

            // Tahun Masuk CRUD
            Route::get('/tahun-masuk', [MasterDataController::class, 'tahunMasukIndex'])->name('admin.master-data.tahun-masuk');
            Route::post('/tahun-masuk', [MasterDataController::class, 'tahunMasukStore'])->name('admin.master-data.tahun-masuk.store');
            Route::put('/tahun-masuk/{id}', [MasterDataController::class, 'tahunMasukUpdate'])->name('admin.master-data.tahun-masuk.update');
            Route::delete('/tahun-masuk/{id}', [MasterDataController::class, 'tahunMasukDestroy'])->name('admin.master-data.tahun-masuk.destroy');
        });
        Route::get('/invoice', [DashboardController::class, 'adminInvoice'])->name('admin.invoice');
        Route::get('/statistik-prodi', [DashboardController::class, 'adminStatistikProdi'])->name('admin.statistik-prodi');
        Route::get('/log-aktivitas', [DashboardController::class, 'adminLogAktivitas'])->name('admin.log-aktivitas');
    });

    // =============================================
    // KEUANGAN PAGES
    // =============================================
    Route::middleware('role:keuangan')->prefix('keuangan')->group(function () {
        // Profile CRUD
        Route::get('/profile', [ProfileController::class, 'show'])->name('keuangan.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('keuangan.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('keuangan.profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('keuangan.profile.delete-photo');

        Route::get('/mahasiswa', [DashboardController::class, 'keuanganMahasiswa'])->name('keuangan.mahasiswa');
        Route::prefix('master-data')->group(function () {
            // Rentang UKT CRUD
            Route::get('/rentang-ukt/create', [MasterDataController::class, 'rentangUktCreate'])->name('keuangan.master-data.rentang-ukt.create');
            Route::get('/rentang-ukt', [MasterDataController::class, 'rentangUktIndex'])->name('keuangan.master-data.rentang-ukt');
            Route::post('/rentang-ukt', [MasterDataController::class, 'rentangUktStore'])->name('keuangan.master-data.rentang-ukt.store');
            Route::put('/rentang-ukt/{id}', [MasterDataController::class, 'rentangUktUpdate'])->name('keuangan.master-data.rentang-ukt.update');
            Route::delete('/rentang-ukt/{id}', [MasterDataController::class, 'rentangUktDestroy'])->name('keuangan.master-data.rentang-ukt.destroy');
            Route::delete('/rentang-ukt/{prodi_id}/{tahun_masuk_id}', [MasterDataController::class, 'rentangUktDestroyGroup'])->name('keuangan.master-data.rentang-ukt.destroy-group');

            // Status Pembayaran CRUD
            Route::get('/status-pembayaran', [MasterDataController::class, 'statusPembayaranIndex'])->name('keuangan.master-data.status-pembayaran');
            Route::post('/status-pembayaran', [MasterDataController::class, 'statusPembayaranStore'])->name('keuangan.master-data.status-pembayaran.store');
            Route::put('/status-pembayaran/{id}', [MasterDataController::class, 'statusPembayaranUpdate'])->name('keuangan.master-data.status-pembayaran.update');
            Route::delete('/status-pembayaran/{id}', [MasterDataController::class, 'statusPembayaranDestroy'])->name('keuangan.master-data.status-pembayaran.destroy');

            // Sumber Pembiayaan CRUD
            Route::get('/sumber-pembiayaan', [MasterDataController::class, 'sumberPembiayaanIndex'])->name('keuangan.master-data.sumber-pembiayaan');
            Route::post('/sumber-pembiayaan', [MasterDataController::class, 'sumberPembiayaanStore'])->name('keuangan.master-data.sumber-pembiayaan.store');
            Route::put('/sumber-pembiayaan/{id}', [MasterDataController::class, 'sumberPembiayaanUpdate'])->name('keuangan.master-data.sumber-pembiayaan.update');
            Route::delete('/sumber-pembiayaan/{id}', [MasterDataController::class, 'sumberPembiayaanDestroy'])->name('keuangan.master-data.sumber-pembiayaan.destroy');

            // Level UKT CRUD
            Route::get('/level-ukt', [MasterDataController::class, 'levelUktIndex'])->name('keuangan.master-data.level-ukt');
            Route::post('/level-ukt', [MasterDataController::class, 'levelUktStore'])->name('keuangan.master-data.level-ukt.store');
            Route::put('/level-ukt/{id}', [MasterDataController::class, 'levelUktUpdate'])->name('keuangan.master-data.level-ukt.update');
            Route::delete('/level-ukt/{id}', [MasterDataController::class, 'levelUktDestroy'])->name('keuangan.master-data.level-ukt.destroy');
        });
        Route::get('/banding-ukt', [DashboardController::class, 'keuanganBandingUkt'])->name('keuangan.banding-ukt');
        Route::get('/setting-banding', [DashboardController::class, 'keuanganSettingBanding'])->name('keuangan.setting-banding');
        Route::get('/invoice', [DashboardController::class, 'keuanganInvoice'])->name('keuangan.invoice');
        Route::get('/setting-invoice', [DashboardController::class, 'keuanganSettingInvoice'])->name('keuangan.setting-invoice');
        // Periode Billing CRUD
        Route::get('/periode-billing', [MasterDataController::class, 'periodeBillingIndex'])->name('keuangan.periode-billing');
        Route::post('/periode-billing', [MasterDataController::class, 'periodeBillingStore'])->name('keuangan.periode-billing.store');
        Route::put('/periode-billing/{id}', [MasterDataController::class, 'periodeBillingUpdate'])->name('keuangan.periode-billing.update');
        Route::patch('/periode-billing/{id}/toggle', [MasterDataController::class, 'periodeBillingToggle'])->name('keuangan.periode-billing.toggle');
        Route::delete('/periode-billing/{id}', [MasterDataController::class, 'periodeBillingDestroy'])->name('keuangan.periode-billing.destroy');
    });

    // =============================================
    // AKADEMIK PAGES
    // =============================================
    Route::middleware('role:akademik')->prefix('akademik')->group(function () {
        // Profile CRUD
        Route::get('/profile', [ProfileController::class, 'show'])->name('akademik.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('akademik.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('akademik.profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('akademik.profile.delete-photo');

        // Mahasiswa CRUD
        Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('akademik.mahasiswa');
        Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('akademik.mahasiswa.store');
        Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('akademik.mahasiswa.update');
        Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('akademik.mahasiswa.destroy');
        Route::prefix('master-data')->group(function () {
            // Tahun Akademik CRUD
            Route::get('/tahun-akademik', [MasterDataController::class, 'tahunAkademikIndex'])->name('akademik.master-data.tahun-akademik');
            Route::post('/tahun-akademik', [MasterDataController::class, 'tahunAkademikStore'])->name('akademik.master-data.tahun-akademik.store');
            Route::put('/tahun-akademik/{id}', [MasterDataController::class, 'tahunAkademikUpdate'])->name('akademik.master-data.tahun-akademik.update');
            Route::delete('/tahun-akademik/{id}', [MasterDataController::class, 'tahunAkademikDestroy'])->name('akademik.master-data.tahun-akademik.destroy');

            // Jurusan CRUD
            Route::get('/jurusan', [MasterDataController::class, 'jurusanIndex'])->name('akademik.master-data.jurusan');
            Route::post('/jurusan', [MasterDataController::class, 'jurusanStore'])->name('akademik.master-data.jurusan.store');
            Route::put('/jurusan/{id}', [MasterDataController::class, 'jurusanUpdate'])->name('akademik.master-data.jurusan.update');
            Route::delete('/jurusan/{id}', [MasterDataController::class, 'jurusanDestroy'])->name('akademik.master-data.jurusan.destroy');

            // Prodi CRUD
            Route::get('/prodi', [MasterDataController::class, 'prodiIndex'])->name('akademik.master-data.prodi');
            Route::post('/prodi', [MasterDataController::class, 'prodiStore'])->name('akademik.master-data.prodi.store');
            Route::put('/prodi/{id}', [MasterDataController::class, 'prodiUpdate'])->name('akademik.master-data.prodi.update');
            Route::delete('/prodi/{id}', [MasterDataController::class, 'prodiDestroy'])->name('akademik.master-data.prodi.destroy');
        });
    });

    // =============================================
    // DIREKTUR PAGES
    // =============================================
    Route::middleware('role:direktur')->prefix('direktur')->group(function () {
        // Profile CRUD
        Route::get('/profile', [ProfileController::class, 'show'])->name('direktur.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('direktur.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('direktur.profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('direktur.profile.delete-photo');

        Route::get('/statistik-prodi', [DashboardController::class, 'direkturStatistikProdi'])->name('direktur.statistik-prodi');
    });

    // =============================================
    // MAHASISWA PAGES
    // =============================================
    Route::middleware('role:mahasiswa')->prefix('mahasiswa')->group(function () {
        // Profile CRUD
        Route::get('/profile', [ProfileController::class, 'show'])->name('mahasiswa.profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('mahasiswa.profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('mahasiswa.profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('mahasiswa.profile.delete-photo');

        Route::get('/invoice', [DashboardController::class, 'mahasiswaInvoice'])->name('mahasiswa.invoice');
        Route::get('/riwayat-transaksi', [DashboardController::class, 'mahasiswaRiwayatTransaksi'])->name('mahasiswa.riwayat-transaksi');
        Route::get('/banding-ukt', [DashboardController::class, 'mahasiswaBandingUkt'])->name('mahasiswa.banding-ukt');
    });
});
