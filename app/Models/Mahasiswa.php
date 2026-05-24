<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama_mahasiswa',
        'npm',
        'jenis_kelamin',
        'tgl_lahir',
        'jalur_masuk',
        'pendaftaran',
        'prodi_id',
        'status_akademik',
        'sumber_pembiayaan_id',
        'status_pembayaran_id',
        'nilai_ukt',
        'user_id',
        'tahun_masuk_id',
    ];

    protected function casts(): array
    {
        return [
            'tgl_lahir' => 'date',
            'nilai_ukt' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function tahunMasuk(): BelongsTo
    {
        return $this->belongsTo(TahunMasuk::class, 'tahun_masuk_id');
    }
}
