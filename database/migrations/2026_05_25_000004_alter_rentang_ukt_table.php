<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentang_ukt', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropForeign(['level_ukt_id']);
            $table->dropColumn(['besaran_min', 'besaran_max']);

            $table->unsignedInteger('tahun_masuk_id')->after('prodi_id');
            $table->bigInteger('nilai')->default(0)->after('level_ukt_id');
            $table->string('akun_rekening', 100)->nullable()->after('nilai');

            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade');
            $table->foreign('tahun_masuk_id')->references('id')->on('tahun_masuk')->onDelete('cascade');
            $table->foreign('level_ukt_id')->references('id')->on('level_ukt')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('rentang_ukt', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropForeign(['tahun_masuk_id']);
            $table->dropForeign(['level_ukt_id']);
            $table->dropColumn(['tahun_masuk_id', 'nilai', 'akun_rekening']);

            $table->bigInteger('besaran_min')->after('level_ukt_id');
            $table->bigInteger('besaran_max')->after('besaran_min');

            $table->foreign('prodi_id')->references('id')->on('prodi')->onDelete('cascade');
            $table->foreign('level_ukt_id')->references('id')->on('level_ukt')->onDelete('cascade');
        });
    }
};