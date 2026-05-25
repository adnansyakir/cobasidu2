<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentangUkt extends Model
{
    protected $table = 'rentang_ukt';

    protected $fillable = [
        'prodi_id',
        'tahun_masuk_id',
        'level_ukt_id',
        'nilai',
        'akun_rekening',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function tahunMasuk(): BelongsTo
    {
        return $this->belongsTo(TahunMasuk::class, 'tahun_masuk_id');
    }

    public function levelUkt(): BelongsTo
    {
        return $this->belongsTo(LevelUkt::class, 'level_ukt_id');
    }
}