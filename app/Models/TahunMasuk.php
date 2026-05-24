<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TahunMasuk extends Model
{
    protected $table = 'tahun_masuk';

    protected $fillable = [
        'tahun',
        'tahun_akademik_id',
    ];

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}
