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
        Schema::table('data_personels', function (Blueprint $table) {
            $table->string('kelompok_pangkat')->nullable();
            $table->boolean('is_selected')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_personels', function (Blueprint $table) {
            $table->dropColumn(['kelompok_pangkat', 'is_selected']);
        });
    }
};
