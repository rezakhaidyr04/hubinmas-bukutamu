<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Tampilkan Halaman Login
     */
    public function showLogin(Request $request)
    {
        if (Auth::check() || $request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        $securityQuestion = Setting::where('key', 'security_question')->value('value');
        return view('admin.login', compact('securityQuestion'));
    }

    /**
     * Proses Login Email & Kata Sandi
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin' => 'required|string|min:6|max:255'
        ]);

        $admin = User::whereRaw('LOWER(email) = ?', [strtolower(trim($request->email))])->first();
        if ($admin && Hash::check($request->pin, $admin->password)) {
            Auth::login($admin);
            $request->session()->put('admin_logged_in', true);
            return response()->json(['status' => 'success']);
        }

        return response()->json([
            'message' => 'Email atau kata sandi yang Anda masukkan salah.'
        ], 422);
    }

    /**
     * Lupa PIN (Keamanan dengan Pertanyaan)
     */
    public function forgotPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'answer' => 'required|string',
            'new_password' => 'required|string|min:6|max:255|confirmed'
        ]);

        $admin = User::whereRaw('LOWER(email) = ?', [strtolower(trim($request->email))])->first();
        $dbQuestion = Setting::where('key', 'security_question')->value('value');
        $dbAnswer = Setting::where('key', 'security_answer')->value('value');

        if (!$dbQuestion || !$dbAnswer) {
            return response()->json([
                'message' => 'Pertanyaan keamanan belum diatur oleh admin sebelumnya. Silakan hubungi tim IT.'
            ], 422);
        }

        // Case-insensitive check
        if ($admin
            && strtolower(trim($request->answer)) === strtolower(trim($dbAnswer))) {
            $admin->update(['password' => $request->new_password]);
            Auth::login($admin);
            $request->session()->put('admin_logged_in', true);
            return response()->json(['status' => 'success', 'message' => 'Password berhasil diubah. Mengalihkan ke dashboard...']);
        }

        return response()->json([
            'message' => 'Jawaban keamanan yang Anda masukkan salah.'
        ], 422);
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    /**
     * Tampilkan Dashboard Admin dengan filter & statistik
     */
    public function dashboard(Request $request)
    {
        $query = Visit::query();

        // 1. Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('asal_instansi', 'like', "%{$search}%")
                  ->orWhere('id_kunjungan', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 3. Filter Tujuan
        if ($request->filled('tujuan')) {
            $query->where('tujuan_bertemu', $request->tujuan);
        }

        // 4. Filter Rentang Tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Simpan query untuk ekspor
        $visits = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // --- STATISTIK ---
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();

        $stats = [
            'today' => Visit::whereDate('created_at', $today)->count(),
            'week' => Visit::where('created_at', '>=', $startOfWeek)->count(),
            'total' => Visit::count(),
            'top_category' => Visit::select('kategori')
                                   ->groupBy('kategori')
                                   ->orderByRaw('COUNT(*) DESC')
                                   ->first()?->kategori ?? '-'
        ];

        $tujuanOptions = Setting::getTujuanOptions();
        $categoryOptions = Setting::getCategoryNames();

        return view('admin.dashboard', compact('visits', 'stats', 'tujuanOptions', 'categoryOptions'));
    }

    /**
     * Tampilkan Halaman Pengaturan
     */
    public function settings()
    {
        $requirePhone = Setting::where('key', 'require_phone')->value('value') ?? '0';
        $requireEmail = Setting::where('key', 'require_email')->value('value') ?? '0';
        $categories = Setting::getCategories();
        $tujuanOptions = Setting::getTujuanOptions();
        $customQuestions = Setting::getCustomQuestions();
        $securityQuestion = Setting::where('key', 'security_question')->value('value') ?? '';
        $adminEmail = Setting::where('key', 'admin_email')->value('value') ?? '';
        
        return view('admin.settings', compact('requirePhone', 'requireEmail', 'categories', 'tujuanOptions', 'customQuestions', 'securityQuestion', 'adminEmail'));
    }

    /**
     * Update Pengaturan Form & PIN
     */
    public function updateSettings(Request $request)
    {
        if ($request->filled('admin_email')) {
            $request->validate([
                'admin_email' => 'required|email|max:255',
            ]);

            Setting::updateOrCreate(['key' => 'admin_email'], ['value' => strtolower($request->admin_email)]);
            if ($user = User::first()) {
                $user->update(['email' => strtolower($request->admin_email)]);
            }
        }

        // Update PIN jika diisi
        if ($request->filled('pin')) {
            $request->validate([
                'pin' => 'required|string|min:6|max:255'
            ]);
            Setting::updateOrCreate(['key' => 'admin_pin'], ['value' => $request->pin]);
            if ($user = User::first()) {
                $user->update(['password' => $request->pin]);
            }
        }

        // Update Security Question
        if ($request->filled('security_question')) {
            Setting::updateOrCreate(['key' => 'security_question'], ['value' => $request->security_question]);
        }
        if ($request->filled('security_answer')) {
            Setting::updateOrCreate(['key' => 'security_answer'], ['value' => $request->security_answer]);
        }

        // Update Toggle Switch
        $requirePhone = $request->has('require_phone') ? '1' : '0';
        $requireEmail = $request->has('require_email') ? '1' : '0';

        Setting::updateOrCreate(['key' => 'require_phone'], ['value' => $requirePhone]);
        Setting::updateOrCreate(['key' => 'require_email'], ['value' => $requireEmail]);

        // Update Kategori Tamu
        if ($request->has('categories')) {
            $categories = json_decode($request->input('categories'), true);

            $request->merge(['categories_decoded' => $categories]);
            $request->validate([
                'categories_decoded' => 'required|array|min:1',
                'categories_decoded.*.name' => 'required|string|max:100|distinct',
                'categories_decoded.*.description' => 'nullable|string|max:255',
            ], [
                'categories_decoded.required' => 'Minimal harus ada 1 kategori tamu.',
                'categories_decoded.min' => 'Minimal harus ada 1 kategori tamu.',
                'categories_decoded.*.name.required' => 'Nama kategori wajib diisi.',
                'categories_decoded.*.name.distinct' => 'Nama kategori tidak boleh duplikat.',
            ]);

            $sanitized = collect($categories)->map(fn ($item) => [
                'name' => trim($item['name']),
                'description' => trim($item['description'] ?? ''),
            ])->values()->all();

            Setting::setJson('guest_categories', $sanitized);
        }

        // Update Tujuan / Bertemu
        if ($request->has('tujuan_options')) {
            $tujuanOptions = json_decode($request->input('tujuan_options'), true);

            $request->merge(['tujuan_decoded' => $tujuanOptions]);
            $request->validate([
                'tujuan_decoded' => 'required|array|min:1',
                'tujuan_decoded.*' => 'required|string|max:100|distinct',
            ], [
                'tujuan_decoded.required' => 'Minimal harus ada 1 opsi tujuan.',
                'tujuan_decoded.min' => 'Minimal harus ada 1 opsi tujuan.',
                'tujuan_decoded.*.required' => 'Nama tujuan wajib diisi.',
                'tujuan_decoded.*.distinct' => 'Nama tujuan tidak boleh duplikat.',
            ]);

            $sanitized = collect($tujuanOptions)
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();

            Setting::setJson('tujuan_options', $sanitized);
        }

        // Update Pertanyaan Kustom (Custom Questions)
        if ($request->has('custom_questions')) {
            $customQuestions = json_decode($request->input('custom_questions'), true);
            if (is_array($customQuestions)) {
                $sanitizedCQ = collect($customQuestions)->map(function ($item) {
                    return [
                        'label' => trim($item['label'] ?? ''),
                        'type' => $item['type'] ?? 'text',
                        'required' => !empty($item['required']),
                        'placeholder' => trim($item['placeholder'] ?? ''),
                        'options' => trim($item['options'] ?? ''),
                    ];
                })->filter(fn ($item) => $item['label'] !== '')->values()->all();

                Setting::setJson('custom_questions', $sanitizedCQ);
            }
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Ekspor Data Tamu ke format Excel atau PDF
     */
    public function export(Request $request)
    {
        $query = Visit::query();

        // Terapkan filter yang sama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('asal_instansi', 'like', "%{$search}%")
                  ->orWhere('id_kunjungan', 'like', "%{$search}%");
            });
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('tujuan')) {
            $query->where('tujuan_bertemu', $request->tujuan);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $visits = $query->orderBy('created_at', 'desc')->get();

        $format = $request->get('format', 'excel');

        if ($format === 'pdf') {
            return view('admin.export', compact('visits'))->with('print_pdf', true);
        }

        // Default to Excel (HTML format)
        $filename = "Hubinmas_BukuTamu_Export_" . date('Ymd_His') . ".xls";

        return response(view('admin.export', compact('visits'))->render())
            ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Pragma', 'no-cache')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }

    /**
     * Hapus Data Tamu
     */
    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Data tamu berhasil dihapus.');
    }
}
