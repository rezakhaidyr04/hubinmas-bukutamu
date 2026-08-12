<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class GuestbookController extends Controller
{
    /**
     * Tampilkan Halaman Welcome / Landing
     */
    public function welcome()
    {
        return view('guestbook.welcome');
    }

    /**
     * Tampilkan Form Kunjungan dengan data konfigurasi setting
     */
    public function showForm()
    {
        $requirePhone = Setting::where('key', 'require_phone')->value('value') ?? '0';
        $requireEmail = Setting::where('key', 'require_email')->value('value') ?? '0';
        $categories = Setting::getCategories();
        $tujuanOptions = Setting::getTujuanOptions();
        $customQuestions = Setting::getCustomQuestions();

        return view('guestbook.form', compact('requirePhone', 'requireEmail', 'categories', 'tujuanOptions', 'customQuestions'));
    }

    /**
     * Simpan Kunjungan Baru
     */
    public function submitForm(Request $request)
    {
        // Load settings untuk validasi dinamis
        $requirePhoneSetting = Setting::where('key', 'require_phone')->value('value') ?? '0';
        $requireEmailSetting = Setting::where('key', 'require_email')->value('value') ?? '0';
        $allowedCategories = Setting::getCategoryNames();
        $customQuestions = Setting::getCustomQuestions();

        // Tentukan aturan validasi
        $rules = [
            'kategori' => ['required', 'string', Rule::in($allowedCategories)],
            'nama_lengkap' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'tujuan_bertemu' => ['required', 'string', 'max:255', Rule::notIn(['Lainnya'])],
            'keperluan' => 'required|string',
            'no_telepon' => $requirePhoneSetting === '1' ? 'required|string|min:8' : 'nullable|string',
            'email' => $requireEmailSetting === '1' ? 'required|email' : 'nullable|email',
        ];

        // Custom validation messages jika input kosong
        $messages = [
            'kategori.required' => 'Kategori tamu wajib dipilih.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'asal_instansi.required' => 'Asal instansi/alamat wajib diisi.',
            'tujuan_bertemu.required' => 'Tujuan/bertemu siapa wajib diisi.',
            'keperluan.required' => 'Keperluan kunjungan wajib diisi.',
            'no_telepon.required' => 'No. Telepon / WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ];

        // Validasi pertanyaan kustom
        $customAnswersInput = $request->input('custom_answers', []);
        foreach ($customQuestions as $cq) {
            $cqLabel = $cq['label'] ?? '';
            $isReq = !empty($cq['required']);
            if ($cqLabel && $isReq) {
                $val = trim($customAnswersInput[$cqLabel] ?? '');
                if ($val === '') {
                    return response()->json([
                        'message' => "Pertanyaan '{$cqLabel}' wajib diisi."
                    ], 422);
                }
            }
        }

        $validated = $request->validate($rules, $messages);

        // Filter custom answers agar hanya menyimpan label yang terdaftar
        $cleanCustomAnswers = [];
        foreach ($customQuestions as $cq) {
            $cqLabel = $cq['label'] ?? '';
            if ($cqLabel && isset($customAnswersInput[$cqLabel])) {
                $cleanCustomAnswers[$cqLabel] = trim($customAnswersInput[$cqLabel]);
            }
        }
        $validated['custom_answers'] = $cleanCustomAnswers;

        // Generate ID Kunjungan: TM-YYYYMMDD-XXXX (4 digit random)
        $dateStr = Carbon::now()->format('Ymd');
        $randomNum = rand(1000, 9999);
        $idKunjungan = "TM-{$dateStr}-{$randomNum}";

        // Pastikan unik
        while (Visit::where('id_kunjungan', $idKunjungan)->exists()) {
            $randomNum = rand(1000, 9999);
            $idKunjungan = "TM-{$dateStr}-{$randomNum}";
        }

        $validated['id_kunjungan'] = $idKunjungan;

        // Simpan ke database
        $visit = Visit::create($validated);

        return response()->json([
            'status' => 'success',
            'id_kunjungan' => $visit->id_kunjungan,
            'redirect_url' => route('guestbook.success', ['id' => $visit->id_kunjungan])
        ]);
    }

    /**
     * Tampilkan Halaman Sukses
     */
    public function showSuccess(Request $request)
    {
        $idKunjungan = $request->query('id', 'TM-' . date('Ymd') . '-' . rand(1000, 9999));
        return view('guestbook.success', compact('idKunjungan'));
    }
}
