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
        Schema::create('data_personels', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('korp')->nullable();
            $table->string('nrp')->nullable();
            $table->string('satker')->nullable();
            $table->string('jk')->nullable();
            $table->string('baju_pdh')->nullable();
            $table->string('celana_pdh')->nullable();
            $table->string('pdh')->nullable();
            $table->string('baju_pdu')->nullable();
            $table->string('celana_pdu')->nullable();
            $table->string('pdu')->nullable();
            $table->string('pdl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_personels');
    }
};
