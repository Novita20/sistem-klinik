<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DokterPasienController;
use App\Http\Controllers\DokterRekamMedisController;
use App\Http\Controllers\DokterResepController;
use App\Http\Controllers\HasilKunjunganController;
use App\Http\Controllers\HomePasienController;
use App\Http\Controllers\K3RestockController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LogObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ParamedisRekamMedisController;
use App\Http\Controllers\PasienDokterController;
use App\Http\Controllers\PemeriksaanAwalController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapObatController;
use App\Http\Controllers\ResepObatController;
use App\Http\Controllers\RestockObatController;
use App\Http\Controllers\SdmLaporanObatController;
use App\Http\Controllers\SdmRekamMedisController;

// ========================
// 🏠 HALAMAN AWAL
// ========================
Route::get('/', function () {
    return view('welcome');
});

// ========================
// 🔐 AUTHENTIKASI
// ========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'logincek']);

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);


    //Forgot password
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.change');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ========================
// 📥 SEMUA ROUTE YANG BUTUH LOGIN
// ========================
Route::middleware('auth')->group(function () {

    // ========================
    // 🎯 DASHBOARD PER ROLE
    // ========================
    Route::get('/dashboard', [HomePasienController::class, 'index'])->name('dashboard'); // default pasien

    Route::get('/paramedis/dashboard', function () {
        return view('paramedis.dashboard');
    })->name('paramedis.dashboard');

    Route::get('/dokter/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::get('/k3/dashboard', function () {
        return view('k3.dashboard');
    })->name('k3.dashboard');

    Route::get('/sdm/dashboard', function () {
        return view('sdm.dashboard');
    })->name('sdm.dashboard');

    // ========================
    // 📋 KUNJUNGAN (UMUM/PASIEN)
    // ========================
    Route::get('/kunjungan/form', [KunjunganController::class, 'create'])->name('kunjungan.form');
    Route::post('/kunjungan/store', [KunjunganController::class, 'store'])->name('kunjungan.store');
    Route::get('/kunjungan/riwayat', [KunjunganController::class, 'riwayat'])->name('kunjungan.riwayat');

    Route::get('rekam-medis', [RekamMedisController::class, 'index'])->name('rekam.medis');


    // routes/web.php
    // Route::get('/rekam-medis/{id}/download', [RekamMedisController::class, 'download'])->name('rekam.medis.download');


    // ========================
    // 💊 RESEP OBAT
    // ========================

    Route::get('/resep/pasien', [ResepObatController::class, 'indexResep'])->name('pasien.resep.index');


    // ========================
    // 👤 PROFIL USER
    // ========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');





    //PARAMEDIS

    // 📋 HASIL KUNJUNGAN PARAMEDIS)
    Route::get('/paramedis/kunjungan', [HasilKunjunganController::class, 'index'])->name('paramedis.kunjungan.index');
    Route::get('/paramedis/kunjungan/hasil', [HasilKunjunganController::class, 'hasil'])->name('paramedis.kunjungan.hasil');
    Route::get('/paramedis/kunjungan/{id}', [HasilKunjunganController::class, 'show'])->name('paramedis.kunjungan.show');
    Route::get('/paramedis/riwayat-kunjungan', [HasilKunjunganController::class, 'riwayat'])->name('paramedis.kunjungan.riwayat');
    Route::get('/paramedis/riwayat-kunjungan/export', [HasilKunjunganController::class, 'export'])->name('paramedis.kunjungan.export');

    // Route::get('/paramedis/rekam-medis/create', [HasilKunjunganController::class, 'create'])->name('paramedis.rekammedis.create');
    // Route::post('/paramedis/rekam-medis/store', [HasilKunjunganController::class, 'store'])->name('paramedis.rekammedis.store');


    // 🩺 PEMERIKSAAN AWAL PARAMEDIS
    Route::get('/pemeriksaan-awal', [PemeriksaanAwalController::class, 'index'])->name('paramedis.pemeriksaan.awal');
    Route::get('/pemeriksaan-awal/{id}', [PemeriksaanAwalController::class, 'show'])->name('paramedis.pemeriksaan.awal.show');
    Route::post('/pemeriksaan-awal/store', [PemeriksaanAwalController::class, 'store'])->name('paramedis.pemeriksaan.awal.store');

    // // 💊 RESEP OBAT untuk PARAMEDIS (menampilkan semua resep)

    Route::get('/paramedis/resep', [ResepObatController::class, 'index'])->name('paramedis.resep.index');
    Route::get('/paramedis/resep/{id}/edit', [ResepObatController::class, 'edit'])->name('paramedis.resep.edit');
    Route::delete('/paramedis/resep/{id}', [ResepObatController::class, 'destroy'])->name('paramedis.resep.destroy');
    Route::put('/paramedis/resep/{id}', [ResepObatController::class, 'update'])->name('paramedis.resep.update');
    Route::get('/paramedis/resep/create', [ResepObatController::class, 'create'])->name('paramedis.resep.create');
    Route::post('/resep-obat/berikan/{id}', [ResepObatController::class, 'berikanObat'])->name('paramedis.resep.berikan');

    // Route::post('/resep/{id}/berikan', [ObatController::class, 'berikanObat'])->name('resep.berikan');




    // REKAM MEDIS
    Route::get('/rekammedis', [ParamedisRekamMedisController::class, 'index'])->name('paramedis.rekammedis.index');
    Route::get('/rekammedis/create/{kunjunganId}', [ParamedisRekamMedisController::class, 'create'])->name('paramedis.rekammedis.create');
    Route::post('/rekammedis/store', [ParamedisRekamMedisController::class, 'store'])->name('paramedis.rekammedis.store');
    Route::get('/paramedis/rekam-medis/export', [ParamedisRekamMedisController::class, 'export'])->name('paramedis.rekammedis.export');
    Route::get('/rekammedis/{id}', [ParamedisRekamMedisController::class, 'show'])->name('paramedis.rekammedis.show');



    // ✅ Tambahan route edit, update, destroy
    Route::get('/rekammedis/{id}/edit', [ParamedisRekamMedisController::class, 'edit'])->name('paramedis.rekammedis.edit');
    Route::put('/rekammedis/{id}', [ParamedisRekamMedisController::class, 'update'])->name('paramedis.rekammedis.update');
    Route::delete('/rekammedis/{id}', [ParamedisRekamMedisController::class, 'destroy'])->name('paramedis.rekammedis.destroy');
    Route::get('/rekammedis/{id}/pdf', [ParamedisRekamMedisController::class, 'downloadPDF'])->name('paramedis.rekammedis.pdf');

    //INPUT OBAT

    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');

    //tambah obat baru
    Route::get('/obat/input', [ObatController::class, 'create'])->name('obat.input'); // untuk tambah stok
    Route::get('/obat/baru', [ObatController::class, 'formObatBaru'])->name('obat.baru'); // untuk obat baru
    Route::post('/obat/baru', [ObatController::class, 'storeObatBaru'])->name('obat.storeBaru');


    //MUTASI OBAT
    // Menu mutasi
    Route::get('/obat/mutasi', [LogObatController::class, 'mutasi'])->name('logobat.mutasi');
    // Route::get('/obat/mutasi/create', [LogObatController::class, 'createLog'])->name('logobat.create');
    Route::post('/obat/mutasi', [LogObatController::class, 'storeLog'])->name('logobat.store');
    Route::get('/obat/mutasi/{id}/edit', [LogObatController::class, 'editLog'])->name('logobat.edit');
    Route::put('/obat/mutasi/{id}', [LogObatController::class, 'updateLog'])->name('logobat.update');

    // Route update: simpan perubahan data obat
    Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');



    //REKAP OBAT (PARAMEDIS)
    Route::get('/paramedis/rekap-obat', [RekapObatController::class, 'index'])->name('obat.rekap');
    Route::get('/obat/rekap/export', [RekapObatController::class, 'exportExcel'])->name('obat.rekap.export');




    // 📦 PENGAJUAN (PARAMEDIS)
    Route::get('/paramedis/restock', [RestockObatController::class, 'index'])->name('paramedis.restock.index');
    Route::get('/paramedis/restock/create', [RestockObatController::class, 'create'])->name('paramedis.restock.create');
    Route::post('/paramedis/restock', [RestockObatController::class, 'store'])->name('paramedis.restock.store');









    //DOKTER
    // 🩺 DATA PASIEN (DOKTER)
    // ========================


    // Halaman daftar kunjungan pasien (utama)
    Route::get('/dokter/kunjungan', [DokterPasienController::class, 'index'])->name('dokter.kunjungan');
    Route::get('/dokter/kunjungan/show/{id}', [DokterPasienController::class, 'showKunjungan'])->name('dokter.kunjungan.show');
    Route::get('/dokter/kunjungan/detail/{id}', [DokterPasienController::class, 'detailKunjungan'])->name('dokter.kunjungan.detail');
    Route::post('/dokter/rekam-medis/store', [DokterRekamMedisController::class, 'store'])->name('dokter.rekammedis.store');
    Route::get('/dokter/kunjungan/{id}/edit', [DokterPasienController::class, 'edit'])->name('dokter.kunjungan.edit');
    Route::put('/dokter/kunjungan/{id}', [DokterPasienController::class, 'update'])->name('dokter.kunjungan.update');
    Route::delete('/dokter/kunjungan/{id}', [DokterPasienController::class, 'destroy'])->name('dokter.kunjungan.destroy');
    Route::get('/dokter/kunjungan/{id}/pdf', [DokterPasienController::class, 'exportPdf'])->name('dokter.kunjungan.pdf');




    // 🩺 REKAM MEDIS (DOKTER)
    // ========================
    Route::get('/dokter/rekam-medis/anamnesa', [DokterRekamMedisController::class, 'anamnesa'])->name('dokter.rekammedis.anamnesa');
    Route::get('/dokter/rekam-medis/ttv', [DokterRekamMedisController::class, 'ttv'])->name('dokter.rekammedis.ttv');
    Route::get('/dokter/rekam-medis/diagnosis', [DokterRekamMedisController::class, 'diagnosis'])->name('dokter.rekammedis.diagnosis');
    Route::get('/dokter/rekam-medis/tindakan', [DokterRekamMedisController::class, 'tindakan'])->name('dokter.rekammedis.tindakan');
    // Route::post('/dokter/rekam-medis/store', [DokterRekamMedisController::class, 'store'])->name('dokter.rekammedis.store');
    Route::put('/dokter/rekammedis/update/{id}', [DokterRekamMedisController::class, 'update'])->name('dokter.rekammedis.update');
    Route::get('/dokter/kunjungan/detail/{id}', [DokterPasienController::class, 'detailKunjungan'])->name('dokter.kunjungan.detail');
    // Route::get('/dokter/diagnosis/{id}', [DokterRekamMedisController::class, 'diagnosisById'])->name('dokter.diagnosis.byid');




    // Dokter - Resep Obat
    Route::get('/dokter/resep', [DokterResepController::class, 'index'])->name('dokter.resep');
    Route::get('/dokter/resep/buat/{rekam_medis_id}', [DokterResepController::class, 'create'])->name('dokter.resep.create');
    Route::post('/dokter/resep/simpan', [DokterResepController::class, 'store'])->name('dokter.resep.store');
    Route::get('/dokter/resep/lihat/{rekam_medis_id}', [DokterResepController::class, 'showByRekamMedis'])->name('dokter.resep.show');
    Route::get('/resep/{id}/edit', [DokterResepController::class, 'edit'])->name('dokter.resep.edit');
    Route::delete('/resep/{id}', [DokterResepController::class, 'destroy'])->name('dokter.resep.destroy');
    Route::put('/dokter/resep/{id}', [DokterResepController::class, 'update'])->name('dokter.resep.update');

    Route::get('/dokter/resep/form-item', [DokterResepController::class, 'formItem'])->name('dokter.resep.formItem');
    Route::get('/obat/search', [DokterResepController::class, 'search'])->name('obat.search');
    Route::get('/obat/autocomplete', [DokterResepController::class, 'autocomplete'])->name('obat.autocomplete');


    Route::post('/dokter/resep/store-multiple', [DokterResepController::class, 'storeMultiple'])
        ->name('dokter.resep.storeMultiple');





    //K3


    // K3 - Restock Obat
    Route::get('/k3/restock', [K3RestockController::class, 'index'])->name('k3.restock');
    Route::post('/k3/restock/{id}/setujui', [K3RestockController::class, 'setujui'])->name('k3.restock.setujui');
    Route::post('/k3/restock/{id}/tolak', [K3RestockController::class, 'tolak'])->name('k3.restock.tolak');
    Route::get('/k3/laporan-obat', [K3RestockController::class, 'laporan'])->name('k3.restock.laporan');
    Route::get('/k3/restock/{id}/edit', [K3RestockController::class, 'edit'])->name('k3.restock.edit');
    Route::put('/k3/restock/{id}/update', [K3RestockController::class, 'update'])->name('k3.restock.update');
    Route::delete('/k3/restock/{id}/delete', [K3RestockController::class, 'destroy'])->name('k3.restock.destroy');


    // 📋 LAPORAN PENGGUNAAN OBAT (K3)
    Route::get('/k3/obat', [K3RestockController::class, 'laporan'])->name('k3.obat');
    Route::get('/k3/laporan-obat/export', [K3RestockController::class, 'export'])->name('k3.restock.export');
});

Route::get('/debug-mail', function () {
    return config('mail.mailers.smtp');
});





//SDM

Route::get('/sdm/rekam-medis', [SdmRekamMedisController::class, 'index'])->name('sdm.rekammedis.index');
Route::get('/sdm/rekam-medis/export', [SdmRekamMedisController::class, 'export'])->name('rekam_medis.export');


// Tampilkan laporan penggunaan obat
Route::get('/sdm/laporan-obat', [SdmLaporanObatController::class, 'index'])->name('laporan_obat');

// Export laporan penggunaan obat ke Excel
Route::get('/sdm/laporan-obat/export', [SdmLaporanObatController::class, 'export'])->name('laporan_obat.export');







//INI UNTUK RESET PASSWORD USER KE NID

// use App\Models\User;
// use Illuminate\Support\Facades\Hash;

// Route::get('/reset-password-nid', function () {
//     foreach (User::all() as $user) {
//         $user->password = Hash::make($user->nid);
//         $user->save();
//     }

//     return '✅ Semua password user berhasil di-reset ke NID.';
// });
