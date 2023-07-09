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
        Schema::create('nilai_bobot_alternatifs', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('kriteria_id')->nullable();
            $table->integer('nilai_banding');
            $table->string('alternatif1')->nullable();
            $table->string('alternatif2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_bobot_alternatifs');
    }
};
