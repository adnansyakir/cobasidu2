<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tahun_masuk')) {
            Schema::create('tahun_masuk', function (Blueprint $table) {
                $table->id();
                $table->string('tahun', 10);
                $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tahun_masuk');
    }
};
