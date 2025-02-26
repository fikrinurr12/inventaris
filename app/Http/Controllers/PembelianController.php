<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBarang;
use App\Models\Pembelian;
use App\Models\Supplier;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pembelian = Pembelian::with(['barang', 'supplier'])->orderBy('updated_at', 'desc'); // Load relasi supplier

            return DataTables::of($pembelian)
                ->addColumn('kode_barang', function ($row) {
                    return $row->barang->kode ?? 'Tidak ada Kode Barang';
                })
                ->addColumn('nama_barang', function ($row) {
                    return $row->barang->nama ?? '-';
                })
                ->addColumn('supplier', function ($row) {
                    return $row->supplier->nama ?? '-';
                })
                ->editColumn('harga', function ($row) {
                    return 'Rp. ' . number_format($row->harga, 0, ',', '.');
                })
                ->addColumn('aksi', function ($row) {
                    $cancelUrl = route('pembelian.cancel', $row->id);
                    $printUrl = route('pembelian.print', $row->id);
                    
                    $buttons = '';
                    
                    if ($row->keterangan === 'Dibatalkan') {
                        $buttons .= '<button class="btn btn-sm btn-secondary square-btn" disabled>
                                        <i class="fas fa-print"></i>
                                    </button>';
                    } else {
                        $buttons .= '<form action="'.$cancelUrl.'" method="POST" class="d-inline delete-form">
                                        '.csrf_field().'
                                        <button type="submit" class="btn btn-sm btn-warning square-btn">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>';
                        $buttons .= '<a href="'.$printUrl.'" class="btn btn-sm btn-success square-btn">
                                        <i class="fas fa-print"></i>
                                    </a>';
                    }

                    return $buttons;
                })->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('no_transaksi', 'LIKE', "%{$search}%")
                              ->orWhere('tgl_transaksi', 'LIKE', "%{$search}%")
                              ->orWhere('no_invoice', 'LIKE', "%{$search}%")
                              ->orWhere('harga', 'LIKE', "%{$search}%")
                              ->orWhere('keterangan', 'LIKE', "%{$search}%")
                              ->orWhereHas('barang', function ($q) use ($search) {
                                  $q->where('kode', 'LIKE', "%{$search}%")
                                    ->orWhere('nama', 'LIKE', "%{$search}%");
                              })
                              ->orWhereHas('supplier', function ($q) use ($search) {
                                  $q->where('nama', 'LIKE', "%{$search}%");
                              });
                        });
                    }
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('pembelian.index');
    }
    
    public function tambah()
    {
        // Ambil data barang untuk ditampilkan di form pembelian
        $dataBarang = DataBarang::all(); // Menampilkan semua data barang
        $dataSupplier = Supplier::all();

        return view('pembelian.tambah', compact('dataBarang','dataSupplier'));
    }

    // Fungsi untuk menyimpan pembelian
    public function store(Request $request)
    {
        // Validasi input pembelian
        $validated = $request->validate([
            'no_invoice' => 'required|min:8',
            'id_barang' => 'required|exists:data_barangs,id', // Pastikan barang ada
            'id_supplier' => 'required|exists:suppliers,id', // Pastikan supplier ada
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|min:6',
        ]);

        // Konversi harga dari format AutoNumeric ke integer
        $validated['harga'] = (int) str_replace(['Rp', '.', ','], '', trim($validated['harga']));

        if($validated['keterangan'] === "Dibatalkan" || $validated['keterangan'] === "dibatalkan"){
            return back()->with('failed','Keterangan tidak bisa ditambahkan');
        }

        // Ambil barang berdasarkan kode
        $barang = DataBarang::where('id', $validated['id_barang'])->first();

        // Ambil supplier berdasarkan kode
        $supplier = Supplier::where('id', $validated['id_supplier'])->first();

        // Menyimpan data pembelian
        $pembelian = Pembelian::create([
            'no_transaksi' => 'TRXPB' . Carbon::now()->timestamp, // Generate no transaksi
            'tgl_transaksi' => $validated['tanggal'],
            'no_invoice' => $validated['no_invoice'],
            'id_barang' => $validated['id_barang'],
            'supplier_id' => $validated['id_supplier'],
            'jumlah' => $validated['jumlah'],
            'harga' => $validated['harga'],
            'keterangan' => $validated['keterangan'],
        ]);

        // Update stok barang
        $barang->harga_terakhir = $validated['harga']; // Update harga terakhir
        $barang->stok_total_baik += $validated['jumlah']; // Tambah stok barang yang baik
        $barang->stok_tersedia += $validated['jumlah']; // Tambah stok yang tersedia
        $barang->save(); // Simpan perubahan ke database

        // Redirect setelah berhasil
        return redirect()->route('pembelian')->with('success', 'Pembelian berhasil ditambahkan!');
    }

    public function cancel($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $dataBarang = DataBarang::where('id', $pembelian->id_barang)->first();

        // Cek apakah peminjaman masih dalam status "Menunggu"
        if ($pembelian->jumlah <= $dataBarang->stok_tersedia) {
            $dataBarang->stok_tersedia -= $pembelian->jumlah;
            $dataBarang->stok_total_baik -= $pembelian->jumlah;
            $dataBarang->save();

            $pembelian->keterangan = 'Dibatalkan';
            $pembelian->save();
            
            return back()->with('success', 'Pembelian berhasil dibatalkan.');
        }

        return back()->with('failed', 'Pembelian tidak dapat dibatalkan, karena stok sudah berkurang.');
    }

}
