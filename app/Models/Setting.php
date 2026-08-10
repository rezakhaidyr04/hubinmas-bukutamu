<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getJson(string $key, array $default = []): array
    {
        $value = static::where('key', $key)->value('value');

        if ($value === null) {
            return $default;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $default;
    }

    public static function setJson(string $key, array $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($value, JSON_UNESCAPED_UNICODE)]
        );
    }

    public static function defaultCategories(): array
    {
        return [
            ['name' => 'Orang Tua / Wali', 'description' => 'Kunjungan orang tua atau wali siswa'],
            ['name' => 'Dinas / Instansi', 'description' => 'Kunjungan dari dinas atau instansi luar'],
            ['name' => 'Umum', 'description' => 'Kunjungan masyarakat umum'],
            ['name' => 'Mahasiswa', 'description' => 'Kunjungan mahasiswa atau pelajar'],
        ];
    }

    public static function defaultTujuanOptions(): array
    {
        return [
            'Kepala Sekolah',
            'Wakil Kepala Sekolah',
            'Tata Usaha (TU)',
            'Guru / Wali Kelas',
            'Bimbingan Konseling (BK)',
            'Lainnya',
        ];
    }

    public static function getCategories(): array
    {
        return static::getJson('guest_categories', static::defaultCategories());
    }

    public static function getTujuanOptions(): array
    {
        return static::getJson('tujuan_options', static::defaultTujuanOptions());
    }

    public static function getCategoryNames(): array
    {
        return array_column(static::getCategories(), 'name');
    }

    public static function getCustomQuestions(): array
    {
        return static::getJson('custom_questions', []);
    }
}
