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
        Schema::create('matrix_alternatif_jsons', function (Blueprint $table) {
            $table->id();
            // $table->string('kode');
            $table->string('kriteria_kode')->references('kode')->on('kriterias')->onDelete('cascade');
            $table->string('kode',100);
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matrix_alternatif_jsons');
    }
};
