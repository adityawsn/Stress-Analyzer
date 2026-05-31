<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireSubmission;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $subs = QuestionnaireSubmission::all();

        $total = $subs->count();
        $mean_tps = $subs->avg('tps') ?: 0;
        $mean_mw = $subs->avg('mw') ?: 0;

        $mean_diff = 0;
        if ($total > 0) {
            $sum = 0;
            foreach ($subs as $s) {
                $sum += abs(floatval($s->tps) - floatval($s->mw));
            }
            $mean_diff = $sum / $total;
        }

        $kategori_mean_tps = $total > 0 ? $this->getCategory($mean_tps) : 'N/A';
        $kategori_mean_mw = $total > 0 ? $this->getCategory($mean_mw) : 'N/A';

        $labels = [];
        $tsukamoto = [];
        $mamdani = [];
        $donut_ts = ['Rendah' => 0, 'Sedang' => 0, 'Tinggi' => 0];
        $donut_mm = ['Rendah' => 0, 'Sedang' => 0, 'Tinggi' => 0];

        foreach ($subs as $index => $s) {
            $labels[] = 'Mahasiswa ' . ($index + 1);

            $result = $this->getFuzzyResult($s);
            $tsVal = floatval($result['tsukamoto']['nilai'] ?? 0);
            $mmVal = floatval($result['mamdani']['nilai'] ?? 0);

            $tsukamoto[] = $tsVal;
            $mamdani[] = $mmVal;

            $tsKat = $this->getCategory($tsVal);
            $mmKat = $this->getCategory($mmVal);

            if (isset($donut_ts[$tsKat])) {
                $donut_ts[$tsKat]++;
            }
            if (isset($donut_mm[$mmKat])) {
                $donut_mm[$mmKat]++;
            }
        }

        return view('admin.index', [
            'total' => $total,
            'mean_tps' => round($mean_tps, 2),
            'mean_mw' => round($mean_mw, 2),
            'mean_diff' => round($mean_diff, 2),
            'labels' => $labels,
            'tsukamoto_vals' => $tsukamoto,
            'mamdani_vals' => $mamdani,
            'kategori_ts' => $kategori_mean_tps,
            'kategori_mm' => $kategori_mean_mw,
            'donut_ts' => array_values($donut_ts),
            'donut_mm' => array_values($donut_mm),
        ]);
    }

    public function statistics()
    {
        $subs = QuestionnaireSubmission::all();
        $total = $subs->count();

        $mean_tps = $total > 0 ? round($subs->avg('tps'), 2) : 0;
        $mean_mw = $total > 0 ? round($subs->avg('mw'), 2) : 0;

        $tpsValues = $subs->pluck('tps')->map(fn($value) => floatval($value))->toArray();
        $mwValues = $subs->pluck('mw')->map(fn($value) => floatval($value))->toArray();

        $labels = [];
        $tsukamotoValues = [];
        $mamdaniValues = [];
        $samples = [];

        foreach ($subs as $index => $submission) {
            $labels[] = 'Mhs ' . ($index + 1);
            $result = $this->getFuzzyResult($submission);

            $tsValue = floatval($result['tsukamoto']['nilai'] ?? 0);
            $mmValue = floatval($result['mamdani']['nilai'] ?? 0);

            $tsukamotoValues[] = $tsValue;
            $mamdaniValues[] = $mmValue;

            $samples[] = [
                'name' => $submission->nama ?: 'Mahasiswa ' . ($index + 1),
                'tps' => $submission->tps,
                'mw' => $submission->mw,
                'tsukamoto' => $tsValue,
                'mamdani' => $mmValue,
                'category' => $result['tsukamoto']['kategori'] ?? 'N/A',
            ];
        }

        // Demographics: jenis kelamin, usia (bucket), dan jenjang
        $genderCounts = $subs->groupBy('gender')->map->count()->toArray();

        $orderedGender = [
            'Laki-laki' => $genderCounts['L'] ?? 0,
            'Perempuan' => $genderCounts['P'] ?? 0,
        ];

        $gender_labels = array_keys($orderedGender);
        $gender_values = array_values($orderedGender);

        // Distribusi usia
        $ageCounts = $subs
            ->filter(fn($s) => !empty($s->umur))
            ->groupBy('umur')
            ->map->count()
            ->sortKeys()
            ->toArray();

        $age_labels = array_keys($ageCounts);
        $age_values = array_values($ageCounts);

        // Jenjang counts
        $jenjangCounts = $subs->groupBy('jenjang')->map->count()->toArray();
        $orderedJenjang = [
            'D3' => $jenjangCounts['D3'] ?? 0,
            'D4/S1' => $jenjangCounts['D4 / S1'] ?? 0,
        ];
        $jenjang_labels = array_keys($orderedJenjang);
        $jenjang_values = array_values($orderedJenjang);

        // Status counts (proses / selesai)
$statusCounts = $subs->groupBy('status')->map->count()->toArray();

$orderedStatus = [
    'Dalam Proses' => $statusCounts['proses'] ?? 0,
    'Selesai' => $statusCounts['selesai'] ?? 0,
];

$status_labels = array_keys($orderedStatus);
$status_values = array_values($orderedStatus);

        // Year counts
        $yearCounts = $subs->groupBy('tahun')->map->count()->sortKeys()->toArray();
        $year_labels = array_keys($yearCounts);
        $year_values = array_values($yearCounts);

        // Status by year (stacked) - prepare arrays aligned with year_labels
        $status_by_year_proses = [];
        $status_by_year_selesai = [];
        foreach ($year_labels as $y) {
            $status_by_year_proses[] = isset($yearCounts[$y]) ? $subs->where('tahun', $y)->where('status', 'proses')->count() : 0;
            $status_by_year_selesai[] = isset($yearCounts[$y]) ? $subs->where('tahun', $y)->where('status', 'selesai')->count() : 0;
        }

        // Top stressor counts from answers (q1..q10)
        $questions = [
            'q1' => 'Kesulitan menentukan judul (X1)',
            'q2' => 'Kesulitan bimbingan dengan dosen (X1)',
            'q3' => 'Beban revisi (X1)',
            'q4' => 'Tuntutan lulus tepat waktu (X1)',
            'q5' => 'Kecemasan terhadap hasil akhir (X1)',
            'q6' => 'Perencanaan Jadwal (X2)',
            'q7' => 'Kedisiplinan mengerjakan skripsi (X2)',
            'q8' => 'Kemampuan menentukan prioritas (X2)',
            'q9' => 'Konsistensi pengerjaan (X2)',
            'q10' => 'Mengendalikan kebiasaan menunda (X2)',
        ];
        $stressorSums = array_fill_keys(array_keys($questions), 0.0);
        $stressorCounts = array_fill_keys(array_keys($questions), 0);
        foreach ($subs as $s) {
            $ans = (array) $s->answers;
            foreach ($questions as $qk => $label) {
                if (isset($ans[$qk]) && is_numeric($ans[$qk])) {
                    $val = floatval($ans[$qk]);
                    // q1-q5: higher = more stress; q6-q10: lower = more stress -> invert
                    if (in_array($qk, ['q6', 'q7', 'q8', 'q9', 'q10'], true)) {
                        $val = 6 - $val; // assuming scale 1..5
                    }
                    $stressorSums[$qk] += $val;
                    $stressorCounts[$qk]++;
                }
            }
        }

        $topStressors = [];
        foreach ($questions as $qk => $label) {
            $avg = $stressorCounts[$qk] ? $stressorSums[$qk] / $stressorCounts[$qk] : 0;
            $pct = (int) round($avg / 5 * 100);
            $topStressors[] = ['key' => $qk, 'label' => $label, 'average' => round($avg, 2), 'percentage' => $pct];
        }
        usort($topStressors, fn($a, $b) => $b['percentage'] <=> $a['percentage']);
        $topStressors = array_slice($topStressors, 0, 5);

        $mean_tsukamoto = $this->safeMean($tsukamotoValues);
        $mean_mamdani = $this->safeMean($mamdaniValues);
        $std_tps = $this->safeStandardDeviation($tpsValues, $mean_tps);
        $std_mw = $this->safeStandardDeviation($mwValues, $mean_mw);
        $std_tsukamoto = $this->safeStandardDeviation($tsukamotoValues, $mean_tsukamoto);
        $std_mamdani = $this->safeStandardDeviation($mamdaniValues, $mean_mamdani);

        return view('admin.statistik', [
            'total' => $total,
            'mean_tps' => $mean_tps,
            'mean_mw' => $mean_mw,
            'mean_tsukamoto' => round($mean_tsukamoto, 2),
            'mean_mamdani' => round($mean_mamdani, 2),
            'std_tps' => round($std_tps, 2),
            'std_mw' => round($std_mw, 2),
            'std_tsukamoto' => round($std_tsukamoto, 2),
            'std_mamdani' => round($std_mamdani, 2),
            'chart_labels' => $labels,
            'chart_tsukamoto' => $tsukamotoValues,
            'chart_mamdani' => $mamdaniValues,
            'samples' => $samples,
            // demographics for charts
            'gender_labels' => $gender_labels,
            'gender_values' => $gender_values,
            'age_labels' => $age_labels,
            'age_values' => $age_values,
            'jenjang_labels' => $jenjang_labels,
            'jenjang_values' => $jenjang_values,
            // status & year
            'status_labels' => $status_labels,
            'status_values' => $status_values,
            'year_labels' => $year_labels,
            'year_values' => $year_values,
            'status_by_year_proses' => $status_by_year_proses,
            'status_by_year_selesai' => $status_by_year_selesai,
            'top_stressors' => $topStressors,
        ]);
    }

    private function getFuzzyResult(QuestionnaireSubmission $submission): array
    {
        $script = base_path('python/fuzzy_calculator.py');
        $cacheKey = 'fuzzy_result:' . $submission->id;

        $result = Cache::remember($cacheKey, 60 * 24, function () use ($script, $submission) {
            $tps = floatval($submission->tps);
            $mw = floatval($submission->mw);
            $cmd = 'python ' . escapeshellarg($script) . ' calculate ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
            $output = null;
            $retval = null;
            exec($cmd, $output, $retval);
            if ($retval === 0 && !empty($output)) {
                $decoded = json_decode(implode('', $output), true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
            return [
                'tsukamoto' => ['nilai' => 0, 'kategori' => 'N/A'],
                'mamdani' => ['nilai' => 0, 'kategori' => 'N/A'],
            ];
        });

        return $result;
    }

    private function safeMean(array $values): float
    {
        if (empty($values)) {
            return 0;
        }
        return array_sum($values) / count($values);
    }

    private function safeStandardDeviation(array $values, float $mean): float
    {
        $count = count($values);
        if ($count <= 1) {
            return 0;
        }
        $sum = 0;
        foreach ($values as $value) {
            $sum += ($value - $mean) ** 2;
        }
        return sqrt($sum / ($count - 1));
    }

    private function getCategory(float $value): string
    {
        if ($value < 30) {
            return 'Rendah';
        }

        if ($value <= 70) {
            return 'Sedang';
        }

        return 'Tinggi';
    }
}
