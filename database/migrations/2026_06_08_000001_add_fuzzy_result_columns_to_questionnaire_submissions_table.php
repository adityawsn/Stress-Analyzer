<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->decimal('tsukamoto_nilai', 5, 2)->nullable();
            $table->string('tsukamoto_kategori', 20)->nullable();
            $table->decimal('mamdani_nilai', 5, 2)->nullable();
            $table->string('mamdani_kategori', 20)->nullable();
            $table->decimal('selisih', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'tsukamoto_nilai',
                'tsukamoto_kategori',
                'mamdani_nilai',
                'mamdani_kategori',
                'selisih',
            ]);
        });
    }
};
