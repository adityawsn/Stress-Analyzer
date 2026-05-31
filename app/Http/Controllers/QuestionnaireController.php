<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireSubmission;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:L,P',
            'umur' => 'required|integer|min:10|max:120',
            'jenjang' => 'required|string|max:20',
            'kampus' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'status' => 'required|in:Proses,Selesai',
            'tahun' => 'required|integer|min:2000|max:2030',
            'answers' => 'required|array|size:10',
            'answers.*' => 'required|integer|between:1,5',
            'tps' => 'required|numeric|min:0|max:100',
            'mw' => 'required|numeric|min:0|max:100',
        ]);

        $submission = QuestionnaireSubmission::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'umur' => $validated['umur'],
            'jenjang' => $validated['jenjang'],
            'kampus' => $validated['kampus'],
            'jurusan' => $validated['jurusan'],
            'prodi' => $validated['prodi'],
            // store normalized lowercase status to match DB enum values
            'status' => strtolower($validated['status']),
            'tahun' => $validated['tahun'],
            'answers' => $validated['answers'],
            'tps' => $validated['tps'],
            'mw' => $validated['mw'],
        ]);

        return response()->json([
            'message' => 'Kuesioner berhasil disimpan.',
            'submission' => $submission,
        ], 201);
    }
}
