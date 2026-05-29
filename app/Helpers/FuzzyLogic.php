<?php

// namespace App\Helpers;

// class FuzzyLogic
// {
//     /**
//      * Trapezoid membership function
//      */
//     public static function trapmf($x, $a, $b, $c, $d)
//     {
//         $denominator_ba = ($b - $a) + 1e-6;
//         $denominator_dc = ($d - $c) + 1e-6;

//         $left = ($x - $a) / $denominator_ba;
//         $right = ($d - $x) / $denominator_dc;

//         return max(min(min($left, 1), $right), 0);
//     }

//     /**
//      * Triangle membership function
//      */
//     public static function trimf($x, $a, $b, $c)
//     {
//         $denominator_ba = ($b - $a) + 1e-6;
//         $denominator_cb = ($c - $b) + 1e-6;

//         $left = ($x - $a) / $denominator_ba;
//         $right = ($c - $x) / $denominator_cb;

//         return max(min($left, $right), 0);
//     }

//     /**
//      * Fuzzify input into three categories: rendah, sedang, tinggi
//      */
//     public static function fuzzifyInput($x)
//     {
//         $rendah = self::trapmf($x, 0, 0, 30, 50);
//         $sedang = self::trimf($x, 30, 50, 70);
//         $tinggi = self::trapmf($x, 50, 70, 100, 100);

//         return [
//             'rendah' => $rendah,
//             'sedang' => $sedang,
//             'tinggi' => $tinggi
//         ];
//     }

//     /**
//      * Z functions for Tsukamoto method
//      */
//     public static function zRendah($alpha)
//     {
//         return 50 - 20 * $alpha;
//     }

//     public static function zSedang($alpha)
//     {
//         return 30 + 20 * $alpha;
//     }

//     public static function zTinggi($alpha)
//     {
//         return 50 + 20 * $alpha;
//     }

//     /**
//      * Calculate stress level using Tsukamoto fuzzy logic
//      * @param float $tps Tingkat Perceived Stress (0-100)
//      * @param float $mw Manajemen Waktu (0-100)
//      * @return array ['nilai' => float, 'kategori' => string]
//      */
//     public static function hitungStres($tps, $mw)
//     {
//         // Fuzzify inputs
//         $tps_fuzz = self::fuzzifyInput($tps);
//         $mw_fuzz = self::fuzzifyInput($mw);

//         // Rule base - combining TPS and MW to determine stress level
//         $rules = [
//             min($tps_fuzz['rendah'], $mw_fuzz['rendah']),  // R1 -> Sedang
//             min($tps_fuzz['rendah'], $mw_fuzz['sedang']),  // R2 -> Rendah
//             min($tps_fuzz['rendah'], $mw_fuzz['tinggi']),  // R3 -> Rendah
//             min($tps_fuzz['sedang'], $mw_fuzz['rendah']),  // R4 -> Tinggi
//             min($tps_fuzz['sedang'], $mw_fuzz['sedang']),  // R5 -> Sedang
//             min($tps_fuzz['sedang'], $mw_fuzz['tinggi']),  // R6 -> Rendah
//             min($tps_fuzz['tinggi'], $mw_fuzz['rendah']),  // R7 -> Tinggi
//             min($tps_fuzz['tinggi'], $mw_fuzz['sedang']),  // R8 -> Tinggi
//             min($tps_fuzz['tinggi'], $mw_fuzz['tinggi']),  // R9 -> Sedang
//         ];

//         // Calculate Z for each rule
//         $z_values = [
//             self::zSedang($rules[0]),  // R1
//             self::zRendah($rules[1]),  // R2
//             self::zRendah($rules[2]),  // R3
//             self::zTinggi($rules[3]),  // R4
//             self::zSedang($rules[4]),  // R5
//             self::zRendah($rules[5]),  // R6
//             self::zTinggi($rules[6]),  // R7
//             self::zTinggi($rules[7]),  // R8
//             self::zSedang($rules[8]),  // R9
//         ];

//         // Defuzzification using Tsukamoto method
//         $sum_alpha = array_sum($rules);

//         if ($sum_alpha == 0) {
//             $z_final = 0;
//         } else {
//             $numerator = 0;
//             foreach ($rules as $i => $alpha) {
//                 $numerator += $alpha * $z_values[$i];
//             }
//             $z_final = $numerator / $sum_alpha;
//         }

//         // Determine category
//         if ($z_final < 40) {
//             $kategori = "Rendah";
//         } elseif ($z_final < 70) {
//             $kategori = "Sedang";
//         } else {
//             $kategori = "Tinggi";
//         }

//         return [
//             'nilai' => round($z_final, 2),
//             'kategori' => $kategori,
//             'tps' => $tps,
//             'mw' => $mw,
//             'rules' => $rules,
//             'z_values' => $z_values
//         ];
//     }
// }
