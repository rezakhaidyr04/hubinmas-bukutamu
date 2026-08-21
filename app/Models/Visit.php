<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kunjungan',
        'kategori',
        'nama_lengkap',
        'asal_instansi',
        'tujuan_bertemu',
        'keperluan',
        'no_telepon',
        'email',
        'custom_answers',
        'signature',
    ];

    protected $casts = [
        'custom_answers' => 'array',
    ];
}
