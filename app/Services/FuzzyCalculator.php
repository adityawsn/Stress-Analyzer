<?php

namespace App\Services;

class FuzzyCalculator
{
    public function calculate(float $tps, float $mw): array
    {
        $tsukamoto = $this->hitungTsukamoto($tps, $mw);
        $mamdani = $this->hitungMamdani($tps, $mw);

        return [
            'tps' => $tps,
            'mw' => $mw,
            'tsukamoto' => $tsukamoto,
            'mamdani' => $mamdani,
            'selisih' => round(abs($tsukamoto['nilai'] - $mamdani['nilai']), 2),
        ];
    }

    public function hitungTsukamoto(float $tps, float $mw): array
    {
        [$tpsRendah, $tpsSedang, $tpsTinggi] = $this->fuzzifyTps($tps);
        [$mwBuruk, $mwCukup, $mwBaik] = $this->fuzzifyMw($mw);

        $rules = [
            min($tpsRendah, $mwBuruk),
            min($tpsRendah, $mwCukup),
            min($tpsRendah, $mwBaik),
            min($tpsSedang, $mwBuruk),
            min($tpsSedang, $mwCukup),
            min($tpsSedang, $mwBaik),
            min($tpsTinggi, $mwBuruk),
            min($tpsTinggi, $mwCukup),
            min($tpsTinggi, $mwBaik),
        ];

        $zValues = [
            30 + 20 * $rules[0],
            50 - 20 * $rules[1],
            50 - 20 * $rules[2],
            50 + 20 * $rules[3],
            30 + 20 * $rules[4],
            50 - 20 * $rules[5],
            50 + 20 * $rules[6],
            50 + 20 * $rules[7],
            30 + 20 * $rules[8],
        ];

        $alphaSum = array_sum($rules);
        $value = 0.0;
        if ($alphaSum > 0) {
            $sum = 0.0;
            foreach ($rules as $index => $rule) {
                $sum += $rule * $zValues[$index];
            }
            $value = $sum / $alphaSum;
        }

        $value = round($value, 2);

        return [
            'nilai' => $value,
            'kategori' => $this->getCategory($value),
        ];
    }

    public function hitungMamdani(float $tps, float $mw): array
    {
        [$tpsRendah, $tpsSedang, $tpsTinggi] = $this->fuzzifyTps($tps);
        [$mwBuruk, $mwCukup, $mwBaik] = $this->fuzzifyMw($mw);

        $rules = [
            min($tpsRendah, $mwBuruk),
            min($tpsRendah, $mwCukup),
            min($tpsRendah, $mwBaik),
            min($tpsSedang, $mwBuruk),
            min($tpsSedang, $mwCukup),
            min($tpsSedang, $mwBaik),
            min($tpsTinggi, $mwBuruk),
            min($tpsTinggi, $mwCukup),
            min($tpsTinggi, $mwBaik),
        ];

        $outputRendah = max($rules[1], $rules[2], $rules[5]);
        $outputSedang = max($rules[0], $rules[4], $rules[8]);
        $outputTinggi = max($rules[3], $rules[6], $rules[7]);

        $numerator = 0.0;
        $denominator = 0.0;

        for ($i = 0; $i <= 500; $i++) {
            $x = $i * 0.2;
            $rendah = $this->trapmf($x, 0, 0, 30, 50);
            $sedang = $this->trimf($x, 30, 50, 70);
            $tinggi = $this->trapmf($x, 50, 70, 100, 100);

            $aggregated = max(
                min($outputRendah, $rendah),
                min($outputSedang, $sedang),
                min($outputTinggi, $tinggi)
            );

            $numerator += $x * $aggregated;
            $denominator += $aggregated;
        }

        $value = $denominator === 0.0 ? 0.0 : $numerator / $denominator;
        $value = round($value, 2);

        return [
            'nilai' => $value,
            'kategori' => $this->getCategory($value),
        ];
    }

    public function getCategory(float $value): string
    {
        if ($value <= 30) {
            return 'Rendah';
        }

        if ($value < 70) {
            return 'Sedang';
        }

        return 'Tinggi';
    }

    private function fuzzifyTps(float $x): array
    {
        return [
            $this->trapmf($x, 0, 0, 30, 50),
            $this->trimf($x, 30, 50, 70),
            $this->trapmf($x, 50, 70, 100, 100),
        ];
    }

    private function fuzzifyMw(float $x): array
    {
        return [
            $this->trapmf($x, 0, 0, 30, 50),
            $this->trimf($x, 30, 50, 70),
            $this->trapmf($x, 50, 70, 100, 100),
        ];
    }

    private function trapmf(float $x, float $a, float $b, float $c, float $d): float
    {
        $y = 0.0;

        if ($a === $b) {
            if ($x <= $b) {
                return 1.0;
            }
        } elseif ($x >= $a && $x < $b) {
            $y = ($x - $a) / ($b - $a);
        }

        if ($x >= $b && $x <= $c) {
            $y = 1.0;
        }

        if ($c === $d) {
            if ($x >= $c) {
                return 1.0;
            }
        } elseif ($x > $c && $x <= $d) {
            $y = ($d - $x) / ($d - $c);
        }

        return max(0.0, min(1.0, $y));
    }

    private function trimf(float $x, float $a, float $b, float $c): float
    {
        if ($x <= $a || $x >= $c) {
            return 0.0;
        }

        if ($x == $b) {
            return 1.0;
        }

        if ($x > $a && $x < $b) {
            return ($x - $a) / ($b - $a);
        }

        if ($x > $b && $x < $c) {
            return ($c - $x) / ($c - $b);
        }

        return 0.0;
    }
}
