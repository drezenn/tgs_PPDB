<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('major_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignId('major_id')->constrained('majors')->cascadeOnDelete();
            $table->unsignedTinyInteger('pilihan_ke'); // 1 atau 2
            $table->timestamps();

            $table->unique(['registration_id', 'pilihan_ke']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('major_selections');
    }
};
