<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionnaireSubmission;

class QuestionnaireSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'nama' => 'Aditya Wisnu Setya Pamungkas',
                'email' => 'aditya@example.com',
                'gender' => 'Laki-laki',
                'umur' => 21,
                'jenjang' => 'D4 / S1',
                'kampus' => 'Politeknik Negeri Indramayu',
                'jurusan' => 'Teknik Informatika',
                'prodi' => 'Rekayasa Perangkat Lunak',
                'status' => 'Proses',
                'tahun' => 2026,
                'answers' => [
                    'q1' => 5,
                    'q2' => 3,
                    'q3' => 4,
                    'q4' => 2,
                    'q5' => 2,
                    'q6' => 5,
                    'q7' => 5,
                    'q8' => 4,
                    'q9' => 2,
                    'q10' => 5,
                ],
                'tps' => 64,
                'mw' => 84,
            ],
            [
                'nama' => 'Anisa Nur Pratiwi',
                'email' => 'anisa@example.com',
                'gender' => 'Perempuan',
                'umur' => 20,
                'jenjang' => 'D4 / S1',
                'kampus' => 'UIN Raden Fatah Palembang',
                'jurusan' => 'Ekonomi dan Bisnis',
                'prodi' => 'Perbankan Syariah',
                'status' => 'Selesai',
                'tahun' => 2025,
                'answers' => [
                    'q1' => 4,
                    'q2' => 2,
                    'q3' => 5,
                    'q4' => 4,
                    'q5' => 3,
                    'q6' => 5,
                    'q7' => 4,
                    'q8' => 5,
                    'q9' => 4,
                    'q10' => 5,
                ],
                'tps' => 72,
                'mw' => 92,
            ],
            [
                'nama' => 'Nicho Ray',
                'email' => 'nicho@example.com',
                'gender' => 'Laki-laki',
                'umur' => 22,
                'jenjang' => 'D4 / S1',
                'kampus' => 'Politeknik Negeri Indramayu',
                'jurusan' => 'Teknik Infomatika',
                'prodi' => 'Rekayasa Perangkat Lunak',
                'status' => 'Proses',
                'tahun' => 2026,
                'answers' => [
                    'q1' => 5,
                    'q2' => 1,
                    'q3' => 3,
                    'q4' => 5,
                    'q5' => 5,
                    'q6' => 5,
                    'q7' => 1,
                    'q8' => 1,
                    'q9' => 3,
                    'q10' => 3,
                ],
                'tps' => 76,
                'mw' => 52,
            ],
        ];

        foreach ($samples as $sample) {
            QuestionnaireSubmission::firstOrCreate(
                ['email' => $sample['email']],
                $sample
            );
        }
    }
}
