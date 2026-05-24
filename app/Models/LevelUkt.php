<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelUkt extends Model
{
    protected $table = 'level_ukt';

    protected $fillable = ['nama_level', 'keterangan'];
}
