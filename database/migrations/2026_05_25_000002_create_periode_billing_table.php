<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('periode_billing')) {
            Schema::create('periode_billing', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('tahun_akademik_id');
                $table->date('periode_mulai');
                $table->date('periode_selesai');
                $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
                $table->timestamps();

                $table->foreign('tahun_akademik_id')->references('id')->on('tahun_akademik')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_billing');
    }
};