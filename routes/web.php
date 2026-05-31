<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/tentang', function () {
    return view('about');
});

Route::get('/kuesioner', function () {
    return view('questionnaire');
});

Route::post('/kuesioner', [QuestionnaireController::class, 'store']);

Route::get('/hasil', function () {
    return view('hasil');
});

Route::get('/hasil/comparison-image', function (Request $request) {
    $tps = floatval($request->query('tps', 0));
    $mw = floatval($request->query('mw', 0));
    $script = base_path('python/plot_comparison.py');
    $cmd = 'python ' . escapeshellarg($script) . ' ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
    $output = null;
    $retval = null;

    exec($cmd, $output, $retval);
    if ($retval !== 0 || empty($output)) {
        abort(500, 'Gagal membuat grafik perbandingan.');
    }

    $png = base64_decode(implode('', $output));
    return response($png, 200)
        ->header('Content-Type', 'image/png');
});

Route::get('/hasil/calculate', function (Request $request) {
    $tps = floatval($request->query('tps', 0));
    $mw = floatval($request->query('mw', 0));
    $script = base_path('python/fuzzy_calculator.py');
    $cmd = 'python ' . escapeshellarg($script) . ' calculate ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
    $output = null;
    $retval = null;

    exec($cmd, $output, $retval);
    if ($retval !== 0 || empty($output)) {
        return response()->json(['error' => 'Gagal menghitung fuzzy logic'], 500);
    }

    $result = json_decode(implode('', $output), true);
    return response()->json($result);
});

Route::get('/hasil/tsukamoto-image', function (Request $request) {
    $tps = floatval($request->query('tps', 0));
    $mw = floatval($request->query('mw', 0));
    $script = base_path('python/fuzzy_calculator.py');
    $cmd = 'python ' . escapeshellarg($script) . ' tsukamoto ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
    $output = null;
    $retval = null;

    exec($cmd, $output, $retval);
    if ($retval !== 0 || empty($output)) {
        abort(500, 'Gagal membuat grafik Tsukamoto.');
    }

    $png = base64_decode(implode('', $output));
    return response($png, 200)
        ->header('Content-Type', 'image/png');
});

Route::get('/hasil/mamdani-image', function (Request $request) {
    $tps = floatval($request->query('tps', 0));
    $mw = floatval($request->query('mw', 0));
    $script = base_path('python/fuzzy_calculator.py');
    $cmd = 'python ' . escapeshellarg($script) . ' mamdani ' . escapeshellarg($tps) . ' ' . escapeshellarg($mw);
    $output = null;
    $retval = null;

    exec($cmd, $output, $retval);
    if ($retval !== 0 || empty($output)) {
        abort(500, 'Gagal membuat grafik Mamdani.');
    }

    $png = base64_decode(implode('', $output));
    return response($png, 200)
        ->header('Content-Type', 'image/png');
});




Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/data-mahasiswa', [StudentController::class, 'index']);
route::get('/pengaturan-fuzzy', function () {
    return view('admin.setting.index');
});
route::get('/hasil-kuesioner', [ResultController::class, 'index']);
route::get('/hasil-kuesioner/{id}/detail', [ResultController::class, 'detail']);
route::get('/hasil-kuesioner/export', [ResultController::class, 'export'])->name('hasil.export');
Route::get('/analisis-statistik', [DashboardController::class, 'statistics']);

route::get('/login', function () {
    return view('auth.login');
});
