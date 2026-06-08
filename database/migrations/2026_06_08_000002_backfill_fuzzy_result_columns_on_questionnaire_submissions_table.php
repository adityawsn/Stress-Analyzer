<?php

use App\Services\FuzzyCalculator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $calculator = app(FuzzyCalculator::class);

        DB::table('questionnaire_submissions')
            ->whereNull('tsukamoto_nilai')
            ->select(['id', 'tps', 'mw'])
            ->orderBy('id')
            ->chunkById(100, function ($submissions) use ($calculator) {
                foreach ($submissions as $submission) {
                    $fuzzy = $calculator->calculate((float) $submission->tps, (float) $submission->mw);

                    DB::table('questionnaire_submissions')
                        ->where('id', $submission->id)
                        ->update([
                            'tsukamoto_nilai' => $fuzzy['tsukamoto']['nilai'],
                            'tsukamoto_kategori' => $fuzzy['tsukamoto']['kategori'],
                            'mamdani_nilai' => $fuzzy['mamdani']['nilai'],
                            'mamdani_kategori' => $fuzzy['mamdani']['kategori'],
                            'selisih' => $fuzzy['selisih'],
                        ]);
                }
            });
    }

    public function down(): void
    {
        // Backfill data is intentionally left in place.
    }
};
