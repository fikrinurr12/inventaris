<?php

// LaporanController.php
namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Peminjaman;
use App\Models\Pembelian;
use App\Models\Pengembalian;
use App\Models\Kategori;
use App\Models\PenyesuaianStok;
use App\Models\Supplier;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    //laporan master barang
    public function laporanMasterBarang()
    {
        $kategoriList = Kategori::all(); // Ambil daftar kategori untuk dropdown
        return view('laporan.master_barang.index', compact('kategoriList'));
    }

    public function getDataMasterBarang(Request $request)
    {
        $query = DataBarang::with('kategori')->orderBy('created_at', 'desc');

        // Filter berdasarkan kategori (jika dipilih)
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan rentang tanggal (jika dipilih)
        if ($request->filled('tanggal')) {
            $dates = explode(' - ', $request->tanggal);
            if (count($dates) == 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Format tanggal tidak valid'], 400);
                }
            }
        }

        return DataTables::eloquent($query)
            ->addColumn('kategori', function ($dataBarang) {
                return $dataBarang->kategori ? $dataBarang->kategori->nama : '-';
            })
            ->editColumn('created_at', function ($dataBarang) {
                return $dataBarang->created_at ? $dataBarang->created_at->format('d-m-Y') : '-';
            })
            ->editColumn('harga_terakhir', function ($dataBarang) {
                return 'Rp ' . number_format($dataBarang->harga_terakhir, 0, ',', '.');
            })            
            ->rawColumns(['kategori'])
            ->toJson();
    }

    //laporan pembelian
    public function laporanPembelian()
    {
        $supplierList = Supplier::all();
        return view('laporan.pembelian.index', compact('supplierList'));
    }

    public function getDataPembelian(Request $request)
    {
        $query = Pembelian::with(['barang', 'supplier'])->orderBy('tgl_transaksi', 'desc');

        // Filter berdasarkan tanggal transaksi (jika dipilih)
        if ($request->filled('tanggal')) {
            $dates = explode(' - ', $request->tanggal);
            if (count($dates) == 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('tgl_transaksi', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Format tanggal tidak valid'], 400);
                }
            }
        }

        // Filter berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', $request->keterangan);
        }

        // Filter berdasarkan ID supplier
        if ($request->filled('id_supplier')) {
            $query->where('supplier_id', $request->id_supplier);
        }

        return DataTables::eloquent($query)
            ->addColumn('nama_barang', function ($pembelian) {
                return $pembelian->barang ? $pembelian->barang->nama : '-';
            })
            ->addColumn('nama_supplier', function ($pembelian) {
                return $pembelian->supplier ? $pembelian->supplier->nama : '-';
            })
            ->editColumn('tgl_transaksi', function ($pembelian) {
                return Carbon::parse($pembelian->tgl_transaksi)->format('d-m-Y');
            })
            ->editColumn('harga', function ($pembelian) {
                return 'Rp ' . number_format($pembelian->harga, 0, ',', '.');
            })
            ->rawColumns(['nama_barang','nama_supplier'])
            ->toJson();
    }

    //laporan penyesuaian stok
    public function laporanPenyesuaianStok()
    {
        return view('laporan.penyesuaian_stok.index');
    }

    public function getDataPenyesuaianStok(Request $request)
    {
        $query = PenyesuaianStok::with('barang')->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal transaksi (created_at)
        if ($request->filled('tanggal')) {
            $dates = explode(' - ', $request->tanggal);
            if (count($dates) == 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Format tanggal tidak valid'], 400);
                }
            }
        }

        // Filter berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', $request->keterangan);
        }

        return DataTables::eloquent($query)
            ->addColumn('nama_barang', function ($penyesuaian) {
                return $penyesuaian->barang ? $penyesuaian->barang->nama : '-';
            })
            ->editColumn('created_at', function ($penyesuaian) {
                return Carbon::parse($penyesuaian->created_at)->format('d-m-Y');
            })
            ->rawColumns(['nama_barang'])
            ->toJson();
    }

    //laporan peminjaman
    public function laporanPeminjaman()
    {
        $kategoriList = Kategori::all(); // Ambil daftar kategori untuk dropdown
        return view('laporan.peminjaman.index', compact('kategoriList'));
    }

    public function getDataPeminjaman(Request $request)
    {
        $query = Peminjaman::with('barang')->orderBy('created_at', 'desc');

        // Filter berdasarkan rentang tanggal transaksi (tgl_peminjaman)
        if ($request->filled('tanggal')) {
            $dates = explode(' - ', $request->tanggal);
            if (count($dates) == 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('tgl_peminjaman', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Format tanggal tidak valid'], 400);
                }
            }
        }

        // Filter berdasarkan kategori (harus melalui relasi barang)
        if ($request->filled('kategori')) {
            $query->whereHas('barang.kategori', function ($q) use ($request) {
                $q->where('id', $request->kategori);
            });
        }

        // Filter berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', $request->keterangan);
        }

        return DataTables::eloquent($query)
            ->addColumn('nama_peminjam', function ($peminjaman) {
                return $peminjaman->user ? $peminjaman->user->name : '-';
            })
            ->addColumn('kategori', function ($peminjaman) {
                return $peminjaman->barang->kategori ? $peminjaman->barang->kategori->nama : '-';
            })
            ->addColumn('nama_barang', function ($peminjaman) {
                return $peminjaman->barang ? $peminjaman->barang->nama : '-';
            })
            ->editColumn('tgl_peminjaman', function ($peminjaman) {
                return Carbon::parse($peminjaman->tgl_peminjaman)->format('d-m-Y');
            })
            ->rawColumns(['nama_barang'])
            ->toJson();
    }
    
    //laporan pengembalian
    public function laporanPengembalian()
    {
        $kategoriList = Kategori::all(); // Ambil daftar kategori untuk dropdown
        return view('laporan.pengembalian.index', compact('kategoriList'));
    }

    public function getDataPengembalian(Request $request)
    {
        $query = Pengembalian::with('barang')->orderBy('created_at', 'desc');

        // Filter berdasarkan rentang tanggal transaksi (tgl_peminjaman)
        if ($request->filled('tanggal')) {
            $dates = explode(' - ', $request->tanggal);
            if (count($dates) == 2) {
                try {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('tgl_peminjaman', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Format tanggal tidak valid'], 400);
                }
            }
        }

        // Filter berdasarkan kategori (harus melalui relasi barang)
        if ($request->filled('kategori')) {
            $query->whereHas('barang.kategori', function ($q) use ($request) {
                $q->where('id', $request->kategori);
            });
        }

        // Filter berdasarkan keterangan
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'like', $request->keterangan);
        }

        return DataTables::eloquent($query)
            ->addColumn('nama_peminjam', function ($pengembalian) {
                return $pengembalian->user ? $pengembalian->user->name : '-';
            })
            ->addColumn('kategori', function ($pengembalian) {
                return $pengembalian->barang->kategori ? $pengembalian->barang->kategori->nama : '-';
            })
            ->addColumn('nama_barang', function ($pengembalian) {
                return $pengembalian->barang ? $pengembalian->barang->nama : '-';
            })
            ->editColumn('tgl_pengembalian', function ($pengembalian) {
                return Carbon::parse($pengembalian->tgl_pengembalian)->format('d-m-Y');
            })
            ->rawColumns(['nama_barang'])
            ->toJson();
    }

    public function printTransaksiPembelian($id)
    {
        $pembelian = Pembelian::with('barang')->findOrFail($id);
        
        $pdf = PDF::loadView('print.pembelian_pdf', compact('pembelian'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("transaksi_pembelian_$id.pdf");
    }

    public function printTransaksiPenyesuaian($id)
    {
        $penyesuaian = PenyesuaianStok::with('barang')->findOrFail($id);
        
        $pdf = PDF::loadView('print.penyesuaian_stok_pdf', compact('penyesuaian'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("transaksi_penyesuaian_$id.pdf");
    }

    public function printTransaksiPeminjaman($id)
    {
        $user = auth()->user(); // Ambil user yang sedang login

        $query = Peminjaman::with(['barang', 'user']);

        // Jika bukan superadmin/admin, hanya bisa melihat transaksi miliknya
        if (!$user->hasRole(['superadmin', 'admin'])) {
            $query->where('id_peminjam', $user->id);
        }

        $peminjaman = $query->findOrFail($id);

        $pdf = PDF::loadView('print.peminjaman_pdf', compact('peminjaman'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("transaksi_peminjaman_$id.pdf");
    }

    public function printTransaksiPengembalian($id)
    {
        $user = auth()->user(); // Ambil user yang sedang login

        $query = Pengembalian::with(['barang', 'user', 'peminjaman']);

        // Jika bukan superadmin/admin, hanya bisa melihat transaksi miliknya
        if (!$user->hasRole(['superadmin', 'admin'])) {
            $query->where('id_peminjam', $user->id);
        }

        $pengembalian = $query->findOrFail($id);

        $pdf = PDF::loadView('print.pengembalian_pdf', compact('pengembalian'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("transaksi_pengembalian_$id.pdf");
    }


}