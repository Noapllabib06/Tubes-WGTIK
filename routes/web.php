<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DetectionHistory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Route Default (Otomatis diarahkan ke Dashboard)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. Route Dashboard (Lengkap dengan data Chart)
Route::get('/dashboard', function () {
    $totalScans = DetectionHistory::count();
    $avgConfidence = number_format(DetectionHistory::avg('confidence_score') ?? 0, 1);

    $dominant = DetectionHistory::select('ripeness_status', DB::raw('count(*) as total'))
        ->groupBy('ripeness_status')
        ->orderByDesc('total')
        ->first();
    $dominantQuality = $dominant ? $dominant->ripeness_status : '-';

    $weeklyLogData = DetectionHistory::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total', 'date')
        ->toArray();

    $classDistributionData = DetectionHistory::select('fruit_type', DB::raw('count(*) as total'))
        ->groupBy('fruit_type')
        ->pluck('total', 'fruit_type')
        ->toArray();

    $confidencePerClassData = DetectionHistory::select('fruit_type', DB::raw('AVG(confidence_score) as avg_conf'))
        ->groupBy('fruit_type')
        ->pluck('avg_conf', 'fruit_type')
        ->toArray();

    return view('pages.dashboard', compact(
        'totalScans', 
        'avgConfidence', 
        'dominantQuality', 
        'weeklyLogData', 
        'classDistributionData',
        'confidencePerClassData'
    ));
})->name('dashboard');

// 3. Route Live Scan
Route::get('/scan', function () {
    return view('pages.scan');
})->name('scan');

// 4. Route History
Route::get('/history', function () {
    // Mengambil data riwayat dari database, urutkan dari terbaru
    $histories = DetectionHistory::latest()->get(); 
    return view('pages.history', compact('histories'));
})->name('history');

// 5. Route Report (Kosongkan atau arahkan ke dashboard jika sudah tidak dipakai)
Route::get('/report', function () {
    return view('pages.report');
})->name('report');

// 6. Route Setting
Route::get('/setting', function () {
    return view('pages.setting');
})->name('setting');


/*
|--------------------------------------------------------------------------
| API Routes (Untuk dipanggil oleh JavaScript Teachable Machine)
|--------------------------------------------------------------------------
*/

// API untuk mengambil data History (opsional jika dibutuhkan JS)
Route::get('/api/history', function () {
    $histories = DetectionHistory::latest()->take(50)->get();
    return response()->json($histories);
});

// API untuk menyimpan hasil deteksi dari halaman Scan ke Database
Route::post('/api/history', function (Request $request) {
    $validated = $request->validate([
        'fruit_type' => 'required|string',
        'ripeness_status' => 'required|string',
        'confidence_score' => 'required|numeric',
    ]);

    DetectionHistory::create([
        'fruit_type' => $validated['fruit_type'],
        'ripeness_status' => $validated['ripeness_status'],
        'confidence_score' => $validated['confidence_score']
    ]);

    return response()->json(['message' => 'Data tersimpan sukses']);
});


// API untuk mereset (menghapus semua) data History
Route::delete('/api/history/reset', function () {
    // truncate() akan mengosongkan tabel secara keseluruhan dan mereset ID kembali ke 1
    \App\Models\DetectionHistory::truncate(); 
    
    return response()->json(['message' => 'History berhasil direset']);
});



// API untuk menyimpan hasil deteksi dari halaman Scan ke Database
Route::post('/api/history', function (Request $request) {
    $validated = $request->validate([
        'fruit_type' => 'required|string',
        'ripeness_status' => 'required|string',
        'confidence_score' => 'required|numeric',
    ]);

    DetectionHistory::create([
        'fruit_type' => $validated['fruit_type'],
        'ripeness_status' => $validated['ripeness_status'],
        'confidence_score' => $validated['confidence_score']
    ]);

    return redirect()->route('history')->with('success', 'Data tersimpan sukses');
})->name('history.store'); // <-- Tambahkan name ini

// API untuk menghapus SATU data riwayat (Dibutuhkan oleh tombol hapus di mobile)
Route::delete('/api/history/{id}', function ($id) {
    DetectionHistory::destroy($id);
    return back();
})->name('history.destroy'); // <-- Tambahkan rute dan name ini