<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('rentang_ukt')) {
            Schema::create('rentang_ukt', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('prodi_id');
                $table->unsignedBigInteger('level_ukt_id');
                $table->bigInteger('besaran_min');
                $table->bigInteger('besaran_max');
                $table->timestamps();

                $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade');
                $table->foreign('level_ukt_id')->references('id')->on('level_ukt')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rentang_ukt');
    }
};