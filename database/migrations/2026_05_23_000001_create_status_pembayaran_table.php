<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('status_pembayaran')) {
            Schema::create('status_pembayaran', function (Blueprint $table) {
                $table->id();
                $table->string('nama_status', 100);
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('status_pembayaran');
    }
};
