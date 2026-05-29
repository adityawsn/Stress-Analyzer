<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questionnaire_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->enum('gender', ['L', 'P']);
            $table->unsignedTinyInteger('umur');
            $table->string('jenjang');
            $table->string('kampus');
            $table->string('jurusan');
            $table->string('prodi');
            $table->enum('status', ['proses', 'selesai']);
            $table->unsignedSmallInteger('tahun');
            $table->json('answers');
            $table->decimal('tps', 5, 2);
            $table->decimal('mw', 5, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questionnaire_submissions');
    }
};
