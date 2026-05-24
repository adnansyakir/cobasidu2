<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =============================================
        // Update existing demo users with proper hashed passwords
        // =============================================
        $roles = DB::table('role')->pluck('id', 'nama_role');

        // Update or create admin users with bcrypt passwords
        $staffUsers = [
            ['username' => 'admin',    'email' => 'admin@sidu.ac.id',    'role' => 'Admin'],
            ['username' => 'keuangan', 'email' => 'keuangan@sidu.ac.id', 'role' => 'Keuangan'],
            ['username' => 'akademik', 'email' => 'akademik@sidu.ac.id', 'role' => 'Akademik'],
            ['username' => 'direktur', 'email' => 'direktur@sidu.ac.id', 'role' => 'Direktur'],
        ];

        foreach ($staffUsers as $userData) {
            DB::table('users')->updateOrInsert(
                ['username' => $userData['username']],
                [
                    'email'      => $userData['email'],
                    'password'   => Hash::make('password'),
                    'role_id'    => $roles[$userData['role']],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // =============================================
        // Seed reference data for mahasiswa demo
        // =============================================

        // Tahun Akademik
        $tahunAkademikId = DB::table('tahun_akademik')->insertGetId([
            'tahun_akademik' => '2025/2026',
            'semester'       => 'Ganjil',
            'status'         => 'Aktif',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Jurusan
        $jurusanId = DB::table('jurusan')->insertGetId([
            'nama_jurusan' => 'Teknik Informatika',
            'kode_jurusan' => 'TI',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // Prodi
        $prodiId = DB::table('prodi')->insertGetId([
            'nama_prodi'    => 'Teknik Informatika',
            'kode_prodi'    => 'TI-S1',
            'jenjang_prodi' => 'S1',
            'jurusan_id'    => $jurusanId,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Tahun Masuk
        $tahunMasukId = DB::table('tahun_masuk')->insertGetId([
            'tahun'             => 2024,
            'tahun_akademik_id' => $tahunAkademikId,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // Status Pembayaran
        $statusBelumId = DB::table('status_pembayaran')->insertGetId([
            'nama_status' => 'Belum Bayar',
            'keterangan'  => 'Mahasiswa belum melakukan pembayaran',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('status_pembayaran')->insert([
            ['nama_status' => 'Lunas', 'keterangan' => 'Pembayaran sudah lunas', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Cicilan', 'keterangan' => 'Pembayaran secara cicilan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Sumber Pembiayaan
        $sumberMandiriId = DB::table('sumber_pembiayaan')->insertGetId([
            'nama_sumber' => 'Mandiri',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('sumber_pembiayaan')->insert([
            ['nama_sumber' => 'KIP-Kuliah', 'created_at' => now(), 'updated_at' => now()],
            ['nama_sumber' => 'Beasiswa', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =============================================
        // Create mahasiswa demo user
        // =============================================
        $mahasiswaUserId = DB::table('users')->insertGetId([
            'username'   => 'mhs2024001',
            'email'      => 'mhs2024001@student.sidu.ac.id',
            'password'   => Hash::make('password'),
            'role_id'    => $roles['Mahasiswa'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mahasiswa')->insert([
            'nama_mahasiswa'       => 'Ahmad Fauzi',
            'npm'                  => '2024001',
            'jenis_kelamin'        => 'L',
            'tgl_lahir'            => '2005-03-15',
            'jalur_masuk'          => 'SNBP',
            'pendaftaran'          => 'Reguler',
            'prodi_id'             => $prodiId,
            'status_akademik'      => 'Aktif',
            'sumber_pembiayaan_id' => $sumberMandiriId,
            'status_pembayaran_id' => $statusBelumId,
            'nilai_ukt'            => 3500000,
            'user_id'              => $mahasiswaUserId,
            'tahun_masuk_id'       => $tahunMasukId,
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        $this->command->info('✅ Seeder selesai! Demo users:');
        $this->command->info('   Admin:     admin / password');
        $this->command->info('   Keuangan:  keuangan / password');
        $this->command->info('   Akademik:  akademik / password');
        $this->command->info('   Direktur:  direktur / password');
        $this->command->info('   Mahasiswa: NPM 2024001 / password');
    }
}
