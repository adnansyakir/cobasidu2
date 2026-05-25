<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodeBilling extends Model
{
    protected $table = 'periode_billing';

    protected $fillable = [
        'tahun_akademik_id',
        'periode_mulai',
        'periode_selesai',
        'status',
    ];

    public function tahunAkademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }
}