<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Convert to string first so migration can safely update existing rows.
        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->string('gender', 20)->change();
            $table->string('status', 20)->change();
        });

        DB::table('questionnaire_submissions')
            ->where('gender', 'L')
            ->update(['gender' => 'Laki-laki']);

        DB::table('questionnaire_submissions')
            ->where('gender', 'P')
            ->update(['gender' => 'Perempuan']);

        DB::table('questionnaire_submissions')
            ->where('status', 'proses')
            ->update(['status' => 'Proses']);

        DB::table('questionnaire_submissions')
            ->where('status', 'selesai')
            ->update(['status' => 'Selesai']);

        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->change();
            $table->enum('status', ['Proses', 'Selesai'])->change();
        });
    }

    public function down()
    {
        // Convert to string first so reverse conversion can run safely.
        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->string('gender', 20)->change();
            $table->string('status', 20)->change();
        });

        DB::table('questionnaire_submissions')
            ->where('gender', 'Laki-laki')
            ->update(['gender' => 'L']);

        DB::table('questionnaire_submissions')
            ->where('gender', 'Perempuan')
            ->update(['gender' => 'P']);

        DB::table('questionnaire_submissions')
            ->where('status', 'Proses')
            ->update(['status' => 'proses']);

        DB::table('questionnaire_submissions')
            ->where('status', 'Selesai')
            ->update(['status' => 'selesai']);

        Schema::table('questionnaire_submissions', function (Blueprint $table) {
            $table->enum('gender', ['L', 'P'])->change();
            $table->enum('status', ['proses', 'selesai'])->change();
        });
    }
};
