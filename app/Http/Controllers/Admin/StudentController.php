<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireSubmission;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // only select the fields needed for the index/list view to keep payload small
        $query = QuestionnaireSubmission::select([
            'id', 'nama', 'email', 'gender', 'umur', 'jenjang', 'kampus', 'jurusan', 'prodi', 'status', 'tahun',
        ]);

        // search filter (q) — search by name, campus, prodi or jurusan
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                    ->orWhere('kampus', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%")
                    ->orWhere('prodi', 'like', "%{$q}%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // attach a friendly status label for display
        $students->getCollection()->transform(function (QuestionnaireSubmission $student) {
            $student->status_label = $student->status === 'selesai'
                ? 'Selesai'
                : 'Proses';

            return $student;
        });

        return view('admin.mahasiswa.index', compact('students'));
    }
}
