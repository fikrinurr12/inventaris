<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenyesuaianStokController;
use App\Http\Controllers\MasterSupplierController;

use App\Models\Peminjaman;

//guest
Route::get('/', [UserController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::get('/lupa_password', [UserController::class, 'lupaPassword'])->name('lupa_password')->middleware('guest');
Route::post('/proses_login', [UserController::class, 'proses_login'])->name('login.post');

//superadmin
Route::group(['middleware' => ['role:superadmin']], function () {
    // Peminjaman
    Route::patch('/peminjaman/approve/{id}', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/reject/{id}', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

    // Pengembalian
    Route::patch('/pengembalian/approve/{id}', [PengembalianController::class, 'approve'])->name('pengembalian.approve');
    Route::patch('/pengembalian/reject/{id}', [PengembalianController::class, 'reject'])->name('pengembalian.reject');

    //notifikasi persetujuan
    Route::get('/peminjaman/pending-count', [PeminjamanController::class, 'getPendingCount'])->name('peminjaman.pending_count');
    Route::get('/pengembalian/pending-count', [PengembalianController::class, 'getPendingCount'])->name('pengembalian.pending_count');
    
});


//superadmin & admin
Route::group(['middleware' => ['role:superadmin|admin']], function () {

    //Master Barang (SuperAdmin & Admin)
    Route::get('/master_barang', [MasterBarangController::class, 'index'])->name('master_barang');
    Route::get('/master_barang/stok_sedikit', [MasterBarangController::class, 'stok_sedikit'])->name('master_barang.stok_sedikit');
    Route::get('/master_barang/tambah_barang', [MasterBarangController::class, 'tambah'])->name('tambah_barang');
    Route::post('/master_barang/tambah_barang/tambah', [MasterBarangController::class, 'store'])->name('tambah_barang.store');
    Route::get('/master_barang/edit_barang/{id}', [MasterBarangController::class, 'edit'])->name('edit_barang');
    Route::put('/master_barang/edit_barang/update/{id}', [MasterBarangController::class, 'update'])->name('edit_barang.store');
    Route::delete('/master_barang/hapus_barang/{id}', [MasterBarangController::class, 'hapus'])->name('hapus_barang');

    //Penyesuaian Stok
    Route::get('/penyesuaian_stok', [PenyesuaianStokController::class, 'index'])->name('penyesuaian_stok');
    Route::get('/penyesuaian_stok/tambah', [PenyesuaianStokController::class, 'tambah'])->name('tambah_penyesuaian_stok');
    Route::post('/penyesuaian_stok/tambah/store', [PenyesuaianStokController::class, 'store'])->name('penyesuaian_stok.store');
    

    //Master Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('/kategori/tambah', [KategoriController::class, 'tambah'])->name('tambah_kategori');
    Route::post('/kategori/tambah/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('/kategori/tambah/storeAjax', [KategoriController::class, 'storeAjax'])->name('proses_tambah_kategori');
    Route::get('/kategori/edit_kategori/{id}', [KategoriController::class, 'edit'])->name('edit_kategori');
    Route::put('/kategori/edit_kategori/update/{id}', [KategoriController::class, 'update'])->name('edit_kategori.store');
    Route::delete('/kategori/hapus_kategori/{id}', [KategoriController::class, 'hapus'])->name('hapus_kategori');

    //Master Supplier
    Route::get('/supplier', [MasterSupplierController::class, 'index'])->name('supplier');
    Route::get('/supplier/tambah', [MasterSupplierController::class, 'tambah'])->name('tambah_supplier');
    Route::post('/supplier/tambah/store', [MasterSupplierController::class, 'store'])->name('supplier.store');
    Route::get('/supplier/edit_supplier/{id}', [MasterSupplierController::class, 'edit'])->name('edit_supplier');
    Route::put('/supplier/edit_supplier/update/{id}', [MasterSupplierController::class, 'update'])->name('edit_supplier.store');
    Route::delete('/supplier/hapus_supplier/{id}', [MasterSupplierController::class, 'hapus'])->name('hapus_supplier');
    
    //Master Pembelian
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('/pembelian/tambah_pembelian', [PembelianController::class, 'tambah'])->name('tambah_pembelian');
    Route::post('/pembelian/tambah_pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::post('/pembelian/cancel/{id}', [PembelianController::class, 'cancel'])->name('pembelian.cancel');

    // Master Laporan
    Route::get('/laporan/master_barang', [LaporanController::class, 'laporanMasterBarang'])->name('laporan.master_barang');
    Route::get('/laporan/master_barang/data', [LaporanController::class, 'getDataMasterBarang'])->name('laporan.master_barang.data');

    Route::get('/laporan/pembelian', [LaporanController::class, 'laporanPembelian'])->name('laporan.pembelian');
    Route::get('/laporan/pembelian/data', [LaporanController::class, 'getDataPembelian'])->name('laporan.pembelian.data');
    
    Route::get('/laporan/penyesuaian_stok', [LaporanController::class, 'laporanPenyesuaianStok'])->name('laporan.penyesuaian_stok');
    Route::get('/laporan/penyesuaian_stok/data', [LaporanController::class, 'getDataPenyesuaianStok'])->name('laporan.penyesuaian_stok.data');
    
    Route::get('/laporan/peminjaman', [LaporanController::class, 'laporanPeminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/peminjaman/data', [LaporanController::class, 'getDataPeminjaman'])->name('laporan.peminjaman.data');
    
    Route::get('/laporan/pengembalian', [LaporanController::class, 'laporanPengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/pengembalian/data', [LaporanController::class, 'getDataPengembalian'])->name('laporan.pengembalian.data');

    //master data pengguna
    Route::get('/data_pengguna', [UserController::class, 'index'])->name('data_pengguna');
    Route::get('/data_pengguna/tambah_user', [UserController::class, 'tambah'])->name('tambah_user');
    Route::post('/data_pengguna/tambah_user', [UserController::class, 'store'])->name('tambah_user.store');
    Route::get('/data_pengguna/edit_user/{id}', [UserController::class, 'edit'])->name('edit_user');
    Route::put('/data_pengguna/edit_user/update/{id}', [UserController::class, 'update'])->name('edit_user.update');
    Route::delete('/data_pengguna/hapus_user/{id}', [UserController::class, 'hapus'])->name('hapus_user');

});

//master user
Route::group(['middleware' => ['role:superadmin|admin|user']], function () {

    //master user
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'logout'])->name('profile');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    //master peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/tambah_peminjaman', [PeminjamanController::class, 'tambah'])->name('tambah_peminjaman');
    Route::post('/peminjaman/tambah_peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/get-barang-peminjaman/{id}', [PeminjamanController::class, 'getBarangPeminjaman'])
     ->name('get.barang.peminjaman');

    //master pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::get('/pengembalian/tambah_pengembalian', [PengembalianController::class, 'tambah'])->name('tambah_pengembalian');
    Route::post('/pengembalian/tambah_pengembalian/store', [PengembalianController::class, 'store'])->name('pengembalian.store');

    //notifikasi persetujuan
    Route::get('/peminjaman/pending-count-user', [PeminjamanController::class, 'getPendingCountUser'])->name('peminjaman.pending_count_user');
    Route::get('/pengembalian/pending-count-user', [PengembalianController::class, 'getPendingCountUser'])->name('pengembalian.pending_count_user');

    //Master print
    Route::get('/pembelian/print_transaksi_pembelian/{id}', [LaporanController::class, 'printTransaksiPembelian'])->name('pembelian.print');
    Route::get('/penyesuaian_stok/print_transaksi_penyesuaian/{id}', [LaporanController::class, 'printTransaksiPenyesuaian'])->name('penyesuaian_stok.print');
    Route::get('/peminjaman/print_transaksi_peminjaman/{id}', [LaporanController::class, 'printTransaksiPeminjaman'])->name('peminjaman.print');
    Route::get('/pengembalian/print_transaksi_pengembalian/{id}', [LaporanController::class, 'printTransaksiPengembalian'])->name('pengembalian.print');
});

//peminjaman
Route::group(['middleware' => ['role:admin|user']], function () {

    Route::post('/peminjaman/cancel/{id}', [PeminjamanController::class, 'cancel'])->name('peminjaman.cancel');
    Route::post('/pengembalian/cancel/{id}', [PengembalianController::class, 'cancel'])->name('pengembalian.cancel');

});



