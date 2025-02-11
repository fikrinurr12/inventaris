<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DataBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $query = Peminjaman::with(['user', 'barang'])->orderBy('updated_at', 'desc');
    
            if ($user->hasRole('user')) {
                $query->where('id_peminjam', $user->id);
            }
    
            return DataTables::of($query)
                ->addColumn('nama_peminjam', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->addColumn('nama_barang', function ($row) {
                    return $row->barang->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    $approveUrl = route('peminjaman.approve', $row->id);
                    $rejectUrl = route('peminjaman.reject', $row->id);
                    $cancelUrl = route('peminjaman.cancel', $row->id);
                    $printUrl = route('peminjaman.print', $row->id);
    
                    $buttons = '';
    
                    if (Auth::user()->hasRole('superadmin')) {
                        if ($row->keterangan === 'Menunggu') {
                            $buttons .= '<form action="'.$approveUrl.'" method="POST" class="d-inline">'.csrf_field().method_field('PATCH').'<button type="submit" class="btn btn-sm btn-success square-btn"><i class="fas fa-check"></i></button></form>';
                            $buttons .= '<button type="button" class="btn btn-sm btn-danger square-btn" data-bs-toggle="modal" data-bs-target="#rejectModal-'.$row->id.'"><i class="fas fa-times"></i></button>';
                        }
                    }
                    
                    if (Auth::user()->hasAnyRole(['admin', 'user'])) {
                        if ($row->keterangan === 'Menunggu') {
                            $buttons .= '<form action="'.$cancelUrl.'" method="POST" class="d-inline">'.csrf_field().'<button type="submit" class="btn btn-sm btn-warning square-btn"><i class="fas fa-ban"></i></button></form>';
                        }
                    }
    
                    if ($row->keterangan === 'Disetujui') {
                        $buttons .= '<a href="'.$printUrl.'" class="btn btn-sm btn-success square-btn"><i class="fas fa-print"></i></a>';
                    } else {
                        $buttons .= '<button class="btn btn-sm btn-secondary square-btn" disabled><i class="fas fa-print"></i></button>';
                    }
                    
                    return $buttons;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('peminjaman.index');
    }

    public function tambah(){
        $user = Auth::user(); // Mengambil data pengguna yang sedang login
    
        // Ambil semua data barang
        $dataBarang = DataBarang::all();

        $dataUser = User::all();
        
        // Periksa apakah pengguna memiliki role superadmin atau admin
        $roles = $user->roles->pluck('name'); // Mendapatkan role pengguna

        // Jika pengguna adalah superadmin atau admin, kirim data pengguna lain
        if ($roles->contains('superadmin') || $roles->contains('admin')) {
            $id_peminjam = null;
            $nama_peminjam = null; // Boleh memilih nama peminjam
        } else {
            $id_peminjam = $user->id;
            $nama_peminjam = $user->name; // Nama otomatis diambil dari pengguna yang login
        }

        return view('peminjaman.tambah', compact('dataBarang', 'nama_peminjam', 'id_peminjam', 'dataUser'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'id_peminjam' => 'required|exists:users,id',
            'id_barang' => 'required|exists:data_barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_peminjaman' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Ambil data peminjam berdasarkan ID yang dipilih (bisa admin atau user)
        $peminjam = User::find($validated['id_peminjam']);

        if (!$peminjam) {
            return back()->with('failed', 'Peminjam tidak ditemukan.');
        }

        // Ambil data barang berdasarkan kode
        $barang = DataBarang::where('id', $validated['id_barang'])->first();

        if (!$barang) {
            return back()->with('failed', 'Barang tidak ditemukan.');
        } elseif ($barang->stok_tersedia < $validated['jumlah']) {
            return back()->with('failed', 'Jumlah Stok Tidak Mencukupi.');
        }

        // Jika user atau admin biasa, set keterangan "Menunggu"
        if ($user->hasRole('superadmin')) {
            $keterangan = $validated['keterangan']; // Superadmin bisa memilih keterangan
        } else {
            $keterangan = 'Menunggu';
        }

        // Simpan data peminjaman
        $peminjaman = Peminjaman::create([
            'id_peminjam' => $validated['id_peminjam'],
            'no_transaksi' => 'TRXPJ' . Carbon::now()->timestamp,
            'tgl_peminjaman' => $validated['tgl_peminjaman'],
            'id_barang' => $validated['id_barang'],
            'jumlah' => $validated['jumlah'],
            'sisa_pinjam' => $validated['jumlah'],
            'keterangan' => $keterangan, // Simpan status peminjaman di keterangan
        ]);

        // Stok barang hanya berkurang jika superadmin menyetujui langsung
        if ($keterangan === 'Disetujui') {
            $barang->stok_tersedia -= $validated['jumlah'];
            $barang->save();
        }

        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->keterangan === 'Menunggu') {
            $barang = DataBarang::where('id', $peminjaman->barang->id)->first();

            if (!$barang) {
                return back()->with('failed', 'Barang tidak ditemukan.');
            }

            // Cek apakah stok cukup sebelum dikurangi
            if ($barang->stok_tersedia < $peminjaman->jumlah) {
                return back()->with('failed', 'Stok barang tidak mencukupi untuk peminjaman ini.');
            }

            // Kurangi stok tersedia sesuai jumlah pinjam
            $barang->stok_tersedia -= $peminjaman->jumlah;
            $barang->save();

            // Update status peminjaman menjadi Disetujui
            $peminjaman->keterangan = 'Disetujui';
            $peminjaman->save();
        }

        return back()->with('success', 'Peminjaman telah disetujui dan stok barang diperbarui.');
    }


    public function reject(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->keterangan === 'Menunggu') {
            // Simpan alasan penolakan
            $peminjaman->keterangan = 'Ditolak: ' . $request->alasan;
            $peminjaman->save();
            
            return back()->with('success', 'Peminjaman telah ditolak dengan alasan: ' . $request->alasan);
        }

        return back()->with('failed', 'Peminjaman tidak dapat ditolak.');
    }


    public function cancel($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek apakah peminjaman masih dalam status "Menunggu"
        if ($peminjaman->keterangan === 'Menunggu') {
            $peminjaman->keterangan = 'Dibatalkan';
            $peminjaman->save();
            
            return back()->with('success', 'Peminjaman berhasil dibatalkan.');
        }

        return back()->with('failed', 'Peminjaman tidak dapat dibatalkan.');
    }

    public function getBarangPeminjaman($id)
    {
        $peminjaman = Peminjaman::where('id_peminjam', $id)->where('sisa_pinjam', '>', 0)->get();

        if ($peminjaman->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada barang yang bisa dikembalikan.']);
        }

        return response()->json([
            'status' => 'success',
            'data' => $peminjaman->map(function ($item) {
                return [
                    'no_transaksi' => $item->no_transaksi,
                    'nama_barang' => $item->barang->nama,
                    'sisa_pinjam' => $item->sisa_pinjam,
                    'tgl_peminjaman' => $item->tgl_peminjaman,
                ];
            }),
        ]);
    }

    public function getPendingCount()
    {
        $pendingPeminjamanCount = Peminjaman::where('keterangan', 'Menunggu')->count();
        return response()->json(['pending_peminjaman' => $pendingPeminjamanCount]);
    }

    public function getPendingCountUser()
    {
        $user = auth()->user();
        
        if($user->hasRole('admin')){
            $pendingPeminjamanCountUser = Peminjaman::where('keterangan', 'Menunggu')->count();
        }else{
            $pendingPeminjamanCountUser = Peminjaman::where('id_peminjam', $user->id)
            ->where('keterangan', 'Menunggu')
            ->count();
        }

        return response()->json(['pending_peminjaman_user' => $pendingPeminjamanCountUser]);
    }


}
