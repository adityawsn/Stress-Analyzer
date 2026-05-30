<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        $script = base_path('python/fuzzy_calculator.py');

        foreach ($subs as $index => $s) {
            $labels[] = 'Mahasiswa ' . ($index + 1);

            $cacheKey = 'fuzzy_result:' . $s->id;
            $json = Cache::remember($cacheKey, 60 * 24, function () use ($script, $s) {
                $tps = floatval($s->tps);
                $mw = floatval($s->mw);
                $cmd = 'python ' . escapeshellarg($script) . ' calculate ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
                $output = null;
                $retval = null;
                exec($cmd, $output, $retval);
                if ($retval === 0 && !empty($output)) {
                    $decoded = json_decode(implode('', $output), true);
                    return is_array($decoded) ? $decoded : null;
                }
                return null;
            });

            $tsVal = null;
            $mmVal = null;
            if (is_array($json)) {
                $tsVal = $json['tsukamoto']['nilai'] ?? null;
                $mmVal = $json['mamdani']['nilai'] ?? null;
                $tsKat = null;
                if ($tsVal !== null) {
                    $tsKat = $this->getCategory($tsVal);
                }
                $mmKat = null;
                if ($mmVal !== null) {
                    $mmKat = $this->getCategory($mmVal);
                }
                if ($tsKat && isset($donut_ts[$tsKat])) {
                    $donut_ts[$tsKat]++;
                }
                if ($mmKat && isset($donut_mm[$mmKat])) {
                    $donut_mm[$mmKat]++;
                }
            }

            $tsukamoto[] = $tsVal ?? 0;
            $mamdani[] = $mmVal ?? 0;
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

        $tpsValues = $subs->pluck('tps')->map(fn ($value) => floatval($value))->toArray();
        $mwValues = $subs->pluck('mw')->map(fn ($value) => floatval($value))->toArray();

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
