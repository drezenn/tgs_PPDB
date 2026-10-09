<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained('registrations')->cascadeOnDelete();
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah', 100);
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu', 100);
            $table->string('no_hp_orangtua', 20);
            $table->string('penghasilan_orangtua', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_details');
    }
};