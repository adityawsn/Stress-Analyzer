<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionnaireSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'gender',
        'umur',
        'jenjang',
        'kampus',
        'jurusan',
        'prodi',
        'status',
        'tahun',
        'answers',
        'tps',
        'mw',
    ];

    protected $casts = [
        'answers' => 'array',
        'tps' => 'float',
        'mw' => 'float',
        'umur' => 'integer',
        'tahun' => 'integer',
    ];
}
