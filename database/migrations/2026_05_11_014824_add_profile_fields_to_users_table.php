<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable()->after('username');
            $table->string('no_telepon', 20)->nullable()->after('email');
            $table->text('alamat')->nullable()->after('no_telepon');
            $table->string('foto_profil')->nullable()->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'no_telepon', 'alamat', 'foto_profil']);
        });
    }
};
