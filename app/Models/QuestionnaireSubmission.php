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
        'tsukamoto_nilai',
        'tsukamoto_kategori',
        'mamdani_nilai',
        'mamdani_kategori',
        'selisih',
    ];

    protected $casts = [
        'answers' => 'array',
        'tps' => 'float',
        'mw' => 'float',
        'tsukamoto_nilai' => 'float',
        'mamdani_nilai' => 'float',
        'selisih' => 'float',
        'umur' => 'integer',
        'tahun' => 'integer',
    ];

    // Accessor for a human-friendly status label (capitalize first letter)
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes['status'] ?? '';
        return $status === '' ? '' : ucfirst($status);
    }
}
