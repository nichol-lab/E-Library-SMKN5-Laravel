<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->enum('role', [
                'admin',
                'petugas',
                'siswa'
            ])->default('siswa');

            $table->string('nis')->nullable();
            $table->string('kelas')->nullable();
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};