<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireSubmission;
use App\Services\FuzzyCalculator;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(private FuzzyCalculator $fuzzyCalculator)
    {
    }

    public function index(Request $request)
    {
        $results = QuestionnaireSubmission::query();

        if ($request->filled('q')) {
            $q = $request->q;

            $results->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                    ->orWhere('kampus', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%")
                    ->orWhere('prodi', 'like', "%{$q}%");
            });
        }

        $results = $results
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $results->getCollection()->transform(function (QuestionnaireSubmission $submission) {
            return $this->attachFuzzyResult($submission);
        });

        return view('admin.hasil.index', compact('results'));
    }

    public function detail($id)
    {
        $submission = QuestionnaireSubmission::findOrFail($id);
        $submission = $this->attachFuzzyResult($submission);

        return response()->json([
            'nama' => $submission->nama,
            'kampus' => $submission->kampus,
            'prodi' => $submission->prodi,
            'x1_tps' => $submission->tps,
            'x2_mw' => $submission->mw,
            'tsukamoto' => $submission->tsukamoto,
            'mamdani' => $submission->mamdani,
            'selisih' => $submission->selisih,
            'deskripsi' => $this->generateDeskripsi($submission->tsukamoto['nilai'], $submission->mamdani['nilai'], $submission->selisih)
        ]);
    }

    public function export(Request $request)
    {
        $query = QuestionnaireSubmission::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('kampus', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%")
                    ->orWhere('prodi', 'like', "%{$q}%");
            });
        }

        $subs = $query->orderBy('created_at', 'asc')->orderBy('id', 'asc')->get();

        $rows = [];
        $rowNumber = 0;
        foreach ($subs as $s) {
            $rowNumber++;
            $fuzzy = $this->resolveFuzzyResult($s);
            $ts = $fuzzy['tsukamoto'];
            $mm = $fuzzy['mamdani'];
            $answers = is_array($s->answers) ? $s->answers : [];

            $row = [
                'id' => $rowNumber,
                // 'submission_id' => $s->id,
                'email' => $s->email ?? '',
                'nama' => $s->nama,
                'gender' => $s->gender ?? '',
                'umur' => $s->umur ?? '',
                'jenjang' => $s->jenjang ?? '',
                'kampus' => $s->kampus ?? '',
                'jurusan' => $s->jurusan ?? '',
                'prodi' => $s->prodi ?? '',
                'status' => $s->status_label ?? '',
                'tahun' => $s->tahun ?? '',
                'tps' => $s->tps ?? '',
                'mw' => $s->mw ?? '',
            ];

            for ($i = 1; $i <= 10; $i++) {
                $k = 'q' . $i;
                $row[$k] = $answers[$k] ?? '';
            }

            $row['tsukamoto_nilai'] = $ts['nilai'];
            $row['tsukamoto_kategori'] = $ts['kategori'];
            $row['mamdani_nilai'] = $mm['nilai'];
            $row['mamdani_kategori'] = $mm['kategori'];
            $selisih = $fuzzy['selisih'];
            // ensure explicit zero is written (not left empty) when difference is exactly 0
            if ($selisih === 0.0) {
                // use explicit string '0' to avoid empty cells in exported files
                $row['selisih'] = '0';
            } else {
                $row['selisih'] = $selisih;
            }
            $row['created_at'] = $s->created_at ? $s->created_at->format('d-m-Y H:i:s') : '';
            // $row['updated_at'] = $s->updated_at ? $s->updated_at->format('d-m-Y H:i:s') : '';

            $rows[] = $row;
        }

        // build columns list matching DB + q1..q10 + computed fields
        $columns = [
            'id', 'email','nama','gender','umur','jenjang','kampus','jurusan','prodi','status','tahun',
        ];
        for ($i = 1; $i <= 10; $i++) {
            $columns[] = 'q' . $i;
        }
        $columns = array_merge($columns, ['tps','mw','tsukamoto_nilai','tsukamoto_kategori','mamdani_nilai','mamdani_kategori','selisih','created_at']);

        // If maatwebsite/excel is installed, use it to export .xlsx
        if (class_exists(\Maatwebsite\Excel\Excel::class)) {
            $filename = 'hasil_kuesioner_' . now()->format('Ymd') . '.xlsx';
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ResultsExport($rows, $columns), $filename);
        }

        // Fallback to CSV streaming
        $filename = 'hasil_kuesioner_' . now()->format('Ymd') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows, $columns) {
            $out = fopen('php://output', 'w');
            // BOM for Excel to recognize UTF-8
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($out, $columns);

            foreach ($rows as $row) {
                $line = [];
                foreach ($columns as $col) {
                    $line[] = $row[$col] ?? '';
                }
                fputcsv($out, $line);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function attachFuzzyResult(QuestionnaireSubmission $submission): QuestionnaireSubmission
    {
        $fuzzy = $this->resolveFuzzyResult($submission);

        $submission->tsukamoto = $fuzzy['tsukamoto'];
        $submission->mamdani = $fuzzy['mamdani'];
        $submission->selisih = $fuzzy['selisih'];

        return $submission;
    }

    private function resolveFuzzyResult(QuestionnaireSubmission $submission): array
    {
        if ($submission->tsukamoto_nilai !== null && $submission->mamdani_nilai !== null) {
            $tsukamotoNilai = (float) $submission->tsukamoto_nilai;
            $mamdaniNilai = (float) $submission->mamdani_nilai;

            return [
                'tps' => (float) $submission->tps,
                'mw' => (float) $submission->mw,
                'tsukamoto' => [
                    'nilai' => $tsukamotoNilai,
                    'kategori' => $submission->tsukamoto_kategori ?: $this->getCategory($tsukamotoNilai),
                ],
                'mamdani' => [
                    'nilai' => $mamdaniNilai,
                    'kategori' => $submission->mamdani_kategori ?: $this->getCategory($mamdaniNilai),
                ],
                'selisih' => $submission->selisih !== null
                    ? (float) $submission->selisih
                    : round(abs($tsukamotoNilai - $mamdaniNilai), 2),
            ];
        }

        return $this->fuzzyCalculator->calculate((float) $submission->tps, (float) $submission->mw);
    }

    private function getCategory(float $value): string
    {
        return $this->fuzzyCalculator->getCategory($value);
    }

    private function generateDeskripsi(float $tsukamoto, float $mamdani, float $selisih): string
    {
        $terkategori = $this->getCategory($tsukamoto);
        $deskripsi = "Hasil defuzzifikasi menunjukkan tingkat stres <strong>$terkategori</strong>. ";

        if ($selisih < 2) {
            $deskripsi .= "Tsukamoto dan Mamdani sangat konsisten dengan selisih hanya <strong>$selisih</strong>.";
        } elseif ($selisih < 5) {
            $deskripsi .= "Kedua metode cukup sejalan dengan selisih <strong>$selisih</strong>, menunjukkan stabilitas hasil.";
        } else {
            $deskripsi .= "Terdapat perbedaan signifikan <strong>$selisih</strong> antara metode, perlu verifikasi lebih lanjut.";
        }

        return $deskripsi;
    }

    public function import()
    {
        return view('admin.hasil.import');
    }

    public function storeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            $rows = [];
            $imported = 0;
            $errors = [];

            // Determine file type and parse accordingly
            if (in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
                // Parse Excel
                if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();
                } else {
                    return back()->with('error', 'Library Excel tidak ditemukan. Gunakan file CSV saja.');
                }
            } else {
                // Parse CSV
                $file_handle = fopen($path, 'r');
                while (($row = fgetcsv($file_handle)) !== false) {
                    $rows[] = $row;
                }
                fclose($file_handle);
            }

            if (empty($rows) || count($rows) < 2) {
                return back()->with('error', 'File kosong atau format tidak sesuai.');
            }

            // Parse header
            $header = array_map('trim', $rows[0]);
            $headerMap = array_flip($header);

            // Required columns
            $required = ['nama', 'email', 'gender', 'umur', 'jenjang', 'kampus', 'jurusan', 'prodi', 'status', 'tahun',
                         'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10'];

            $missing = array_diff($required, $header);
            if (!empty($missing)) {
                return back()->with('error', 'Kolom yang diperlukan tidak ditemukan: ' . implode(', ', $missing));
            }

            // Process each row
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    $data = [];
                    foreach ($required as $col) {
                        if (isset($headerMap[$col]) && isset($row[$headerMap[$col]])) {
                            $data[$col] = trim($row[$headerMap[$col]]);
                        }
                    }

                    // Validate required fields
                    if (empty($data['nama']) || empty($data['email']) || empty($data['gender'])) {
                        $errors[] = "Baris " . ($i + 1) . ": Data diri tidak lengkap";
                        continue;
                    }

                    // Validate answers (q1-q10)
                    $answers = [];
                    $validAnswers = true;
                    for ($q = 1; $q <= 10; $q++) {
                        $val = (int)($data["q{$q}"] ?? 0);
                        if ($val < 1 || $val > 5) {
                            $validAnswers = false;
                            break;
                        }
                        $answers["q{$q}"] = $val;
                    }

                    if (!$validAnswers) {
                        $errors[] = "Baris " . ($i + 1) . ": Jawaban harus 1-5";
                        continue;
                    }

                    // Calculate TPS (q1-q5 average * 20)
                    $tpsSum = $answers['q1'] + $answers['q2'] + $answers['q3'] + $answers['q4'] + $answers['q5'];
                    $tps = ($tpsSum / 5) * 20;

                    // Calculate MW (q6-q10 average * 20)
                    $mwSum = $answers['q6'] + $answers['q7'] + $answers['q8'] + $answers['q9'] + $answers['q10'];
                    $mw = ($mwSum / 5) * 20;
                    $tps = round($tps, 2);
                    $mw = round($mw, 2);
                    $fuzzy = $this->fuzzyCalculator->calculate($tps, $mw);

                    // Check if email already exists
                    if (QuestionnaireSubmission::where('email', $data['email'])->exists()) {
                        $errors[] = "Baris " . ($i + 1) . ": Email {$data['email']} sudah ada";
                        continue;
                    }

                    // Create submission
                    QuestionnaireSubmission::create([
                        'nama' => $data['nama'],
                        'email' => $data['email'],
                        'gender' => $data['gender'],
                        'umur' => (int)$data['umur'],
                        'jenjang' => $data['jenjang'],
                        'kampus' => $data['kampus'],
                        'jurusan' => $data['jurusan'],
                        'prodi' => $data['prodi'],
                        'status' => $data['status'],
                        'tahun' => (int)$data['tahun'],
                        'answers' => $answers,
                        'tps' => $tps,
                        'mw' => $mw,
                        'tsukamoto_nilai' => $fuzzy['tsukamoto']['nilai'],
                        'tsukamoto_kategori' => $fuzzy['tsukamoto']['kategori'],
                        'mamdani_nilai' => $fuzzy['mamdani']['nilai'],
                        'mamdani_kategori' => $fuzzy['mamdani']['kategori'],
                        'selisih' => $fuzzy['selisih'],
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                }
            }

            $msg = "$imported data berhasil diimpor";
            if (!empty($errors)) {
                $msg .= ". " . count($errors) . " baris gagal: " . implode("; ", array_slice($errors, 0, 5));
                if (count($errors) > 5) {
                    $msg .= "... dan " . (count($errors) - 5) . " error lainnya";
                }
                return back()->with('warning', $msg);
            }

            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }
}
