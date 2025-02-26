<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use App\Models\PenyesuaianStok;
use App\Models\DataBarang;
use App\Models\Pembelian;

class PenyesuaianStokController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataPenyesuaian = PenyesuaianStok::with('barang')->select('penyesuaian_stok.*')->orderBy('updated_at', 'desc');

            return DataTables::of($dataPenyesuaian)
                ->addColumn('kode_barang', function ($row) {
                    return $row->barang ? $row->barang->kode : '-';
                })
                ->addColumn('nama_barang', function ($row) {
                    return $row->barang ? $row->barang->nama : '-';
                })
                ->editColumn('keterangan', function ($row) {
                    return $row->keterangan ?? '-';
                })->addColumn('aksi', function ($row) {
                    $printUrl = route('penyesuaian_stok.print', $row->id);
                    
                    return '<a href="'.$printUrl.'" class="btn btn-sm btn-success square-btn">
                            <i class="fas fa-print"></i>
                        </a>';
                })->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('keterangan', 'LIKE', "%{$search}%")
                              ->orWhere('no_transaksi', 'LIKE', "%{$search}%")
                              ->orWhereHas('barang', function ($q) use ($search) {
                                  $q->where('kode', 'LIKE', "%{$search}%")
                                    ->orWhere('nama', 'LIKE', "%{$search}%");
                              });
                        });
                    }
                })
                ->rawColumns(['kode_barang', 'nama_barang', 'keterangan', 'aksi'])
                ->make(true);
        }

        return view('penyesuaian_stok.index');
    }

    public function tambah(){
        $dataBarang = DataBarang::all();

        return view('penyesuaian_stok.tambah', compact('dataBarang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:data_barangs,id',
            'penyesuaian' => 'required|in:penambahan_stok_baik,pengurangan_stok_baik,penambahan_stok_rusak,pengurangan_stok_rusak',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $barang = DataBarang::where('id', $validated['id_barang'])->firstOrFail();
        
        // Mengecek apakah barang memiliki riwayat pembelian
        $hasPurchase = Pembelian::where('id_barang', $validated['id_barang'])->exists();
        if (!$hasPurchase) {
            return redirect()->back()->with('failed', 'Barang ini belum memiliki riwayat pembelian, tidak bisa melakukan penyesuaian stok.');
        }

        // Logika penyesuaian stok
        if ($validated['penyesuaian'] == 'penambahan_stok_baik') {
            $barang->stok_total_baik += $validated['jumlah'];
            $barang->stok_tersedia += $validated['jumlah'];
        } elseif ($validated['penyesuaian'] == 'pengurangan_stok_baik') {
            if ($barang->stok_total_baik >= $validated['jumlah']) {
                $barang->stok_total_baik -= $validated['jumlah'];
                $barang->stok_tersedia -= $validated['jumlah'];
            } else {
                return redirect()->back()->with('failed', 'Stok baik tidak mencukupi!');
            }
        } elseif ($validated['penyesuaian'] == 'penambahan_stok_rusak') {
            if($barang->stok_total_baik >= $validated['jumlah']){
                $barang->stok_total_rusak += $validated['jumlah'];
                $barang->stok_total_baik -= $validated['jumlah'];
                $barang->stok_tersedia -= $validated['jumlah'];
            }else{
                return redirect()->back()->with('failed', 'Stok baik tidak mencukupi!');
            }
        } elseif ($validated['penyesuaian'] == 'pengurangan_stok_rusak') {
            if ($barang->stok_total_rusak >= $validated['jumlah']) {
                $barang->stok_total_rusak -= $validated['jumlah'];
            } else {
                return redirect()->back()->with('failed', 'Stok rusak tidak mencukupi!');
            }
        }

        // Perhitungan stok tersedia
        $barang->save();

        // Simpan riwayat penyesuaian stok
        PenyesuaianStok::create([
            'no_transaksi' => 'TRXPS' . Carbon::now()->timestamp,
            'id_barang' => $validated['id_barang'],
            'stok_total_baik' => $barang->stok_total_baik,
            'stok_total_rusak' => $barang->stok_total_rusak,
            'stok_tersedia' => $barang->stok_tersedia,
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('penyesuaian_stok')->with('success', 'Penyesuaian stok berhasil ditambahkan!');
    }

}