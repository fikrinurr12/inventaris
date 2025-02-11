<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\DataBarang;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($request->ajax()) {
            $query = Pengembalian::with(['peminjaman', 'barang', 'user'])->orderBy('updated_at', 'desc');

            if ($user->hasRole('user')) {
                $query->where('id_peminjam', $user->id);
            }

            return DataTables::of($query)
                ->addColumn('aksi', function ($pengembalian) {
                    $buttons = '';

                    if (auth()->user()->hasRole('superadmin')) {
                        if ($pengembalian->keterangan === 'Menunggu') {
                            $buttons .= '<form action="' . route('pengembalian.approve', $pengembalian->id) . '" method="POST" style="display:inline;">'
                                . csrf_field() . method_field('PATCH') . '
                                <button type="submit" class="btn btn-sm btn-success square-btn">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>';

                            $buttons .= '<button type="button" class="btn btn-sm btn-danger square-btn" data-bs-toggle="modal" data-bs-target="#rejectModal-' . $pengembalian->id . '">
                                <i class="fas fa-times"></i>
                            </button>';
                        }
                    }

                    if (auth()->user()->hasAnyRole(['admin', 'user']) && $pengembalian->keterangan === 'Menunggu') {
                        $buttons .= '<form action="' . route('pengembalian.cancel', $pengembalian->id) . '" method="POST" style="display:inline;">'
                            . csrf_field() . method_field('POST') . '
                            <button type="submit" class="btn btn-sm btn-warning square-btn">
                                <i class="fas fa-ban"></i>
                            </button>
                        </form>';
                    }

                    if ($pengembalian->keterangan === 'Disetujui') {
                        $buttons .= '<a href="' . route('pengembalian.print', $pengembalian->id) . '" class="btn btn-sm btn-success square-btn">
                            <i class="fas fa-print"></i>
                        </a>';
                    }else{
                        $buttons .= '<button class="btn btn-sm btn-secondary square-btn" disabled>
                            <i class="fas fa-print"></i>
                        </button>';
                    }

                    return $buttons;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('pengembalian.index');
    }

    public function tambah()
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name');

        if ($roles->contains('superadmin') || $roles->contains('admin')) {
            // Admin melihat semua peminjam yang masih memiliki sisa pinjaman
            $dataPeminjaman = Peminjaman::where('keterangan', 'Disetujui')
                ->where('sisa_pinjam', '>', 0)
                ->distinct()
                ->get();
            
            $dataPeminjamanUser = collect(); // Kosongkan untuk admin
            $id_peminjam = null;
            $nama_peminjam = null;
        } else {
            // User hanya melihat peminjaman mereka sendiri yang masih ada sisa pinjaman
            $dataPeminjamanUser = Peminjaman::where('id_peminjam', $user->id)
                ->where('keterangan', 'Disetujui')
                ->where('sisa_pinjam', '>', 0)
                ->get();

            $id_peminjam = $user->id;
            $nama_peminjam = $user->name;
            $dataPeminjaman = collect(); // Kosongkan untuk user
        }

        return view('pengembalian.tambah', compact('dataPeminjaman', 'nama_peminjam', 'id_peminjam', 'dataPeminjamanUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kondisi_baik' => 'required|integer|min:0',
            'kondisi_rusak' => 'required|integer|min:0',
            'tgl_pengembalian' => 'required|date',
        ]);

        if ($request->kondisi_baik == 0 && $request->kondisi_rusak == 0) {
            return redirect()->route('pengembalian')->with('failed', 'Kondisi barang minimal harus ada salah satu.');
        }

        // Cek apakah sudah ada pengembalian dengan status "Menunggu" untuk transaksi yang sama
        $cekPengembalian = Pengembalian::where('no_transaksi', $request->no_transaksi)
            ->where('keterangan', 'Menunggu')
            ->first();

        if ($cekPengembalian) {
            return redirect()->route('tambah_pengembalian')->with('failed', 'Masih ada pengembalian yang menunggu persetujuan. Harap tunggu hingga diproses.');
        }

        // Ambil data peminjaman berdasarkan no_transaksi
        $peminjaman = Peminjaman::where('no_transaksi', $request->no_transaksi)->firstOrFail();

        // Hitung total barang yang dikembalikan
        $total_kembali = $request->kondisi_baik + $request->kondisi_rusak;

        // Cek apakah jumlah yang dikembalikan tidak melebihi yang dipinjam
        if ($total_kembali > $peminjaman->sisa_pinjam) {
            return redirect()->route('tambah_pengembalian')->with('failed', 'Jumlah pengembalian melebihi jumlah pinjaman.');
        }

        // Tentukan status pengembalian berdasarkan role
        if (Auth::user()->hasRole('superadmin')) {
            // Jika superadmin, bisa memilih Disetujui/Ditolak
            $keterangan = $request->keterangan;
        } else {
            // Admin dan User defaultnya adalah Menunggu
            $keterangan = 'Menunggu';
        }

        // Simpan data pengembalian dengan keterangan 'Menunggu' jika belum disetujui
        $pengembalian = Pengembalian::create([
            'no_transaksi' => 'TRXPG' . Carbon::now()->timestamp,
            'transaksi_keluar_id' => $peminjaman->no_transaksi,
            'id_barang' => $peminjaman->barang->id,
            'id_peminjam' => $peminjaman->id_peminjam,
            'kondisi_baik' => $request->kondisi_baik,
            'kondisi_rusak' => $request->kondisi_rusak,
            'jumlah' => $total_kembali,
            'sisa_pinjam' => $peminjaman->sisa_pinjam,
            'keterangan' => $keterangan,
            'tgl_pengembalian' => $request->tgl_pengembalian
        ]);

        // Jika pengembalian disetujui oleh superadmin, update stok barang
        if ($keterangan == 'Disetujui') {
            // Ambil data barang
            $barang = DataBarang::where('id', $peminjaman->barang->id)->firstOrFail();

            // Update stok barang
            $barang->stok_total_baik -= $pengembalian->kondisi_rusak;
            $barang->stok_total_rusak += $pengembalian->kondisi_rusak;
            $barang->stok_tersedia += $pengembalian->kondisi_baik;
            $barang->save();

            $pengembalian->sisa_pinjam = $peminjaman->sisa_pinjam;
            $pengembalian->save();

            $pengembalian->sisa_pinjam -= $total_kembali;   
            $pengembalian->save();

            // Kurangi sisa pinjaman di peminjaman
            $peminjaman->sisa_pinjam -= $total_kembali;
            $peminjaman->save();
            return redirect()->route('pengembalian')->with('success', 'Pengembalian berhasil disimpan.');
        }

        return redirect()->route('pengembalian')->with('success', 'Pengembalian berhasil disimpan. Menunggu konfirmasi.');
    }

    public function approve($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->keterangan === 'Menunggu') {
            $peminjaman = Peminjaman::where('no_transaksi', $pengembalian->transaksi_keluar_id)->firstOrFail();

            if (!$peminjaman) {
                return back()->with('failed', 'Peminjaman tidak ditemukan.');
            }

            $barang = DataBarang::where('id', $peminjaman->barang->id)->first();

            if (!$barang) {
                return back()->with('failed', 'Barang tidak ditemukan.');
            }

            $jumlahDikembalikan = $pengembalian->kondisi_baik + $pengembalian->kondisi_rusak;

            // Cek apakah jumlah dikembalikan tidak lebih dari sisa pinjaman
            if ($peminjaman->sisa_pinjam < $jumlahDikembalikan) {
                return redirect()->route('tambah_pengembalian')->with('failed', 'Jumlah barang dikembalikan melebihi sisa pinjaman.');
            }

            $total_kembali = $pengembalian->kondisi_baik + $pengembalian->kondisi_rusak;

            $pengembalian->sisa_pinjam = $peminjaman->sisa_pinjam - $total_kembali;
            $pengembalian->save();

            // Update stok barang sesuai kondisi barang yang dikembalikan
            $peminjaman->sisa_pinjam -= $total_kembali;
            $peminjaman->save();

            // Update stok barang
            $barang->stok_total_baik -= $pengembalian->kondisi_rusak;
            $barang->stok_total_rusak += $pengembalian->kondisi_rusak;
            $barang->stok_tersedia += $pengembalian->kondisi_baik;
            $barang->save();

            // Update status pengembalian menjadi Disetujui
            $pengembalian->keterangan = 'Disetujui';
            $pengembalian->save();
        }

        return back()->with('success', 'Pengembalian telah disetujui dan stok barang diperbarui.');
    }

    public function reject(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->keterangan === 'Menunggu') {
            // Simpan alasan penolakan
            $pengembalian->keterangan = 'Ditolak: ' . $request->alasan;
            $pengembalian->save();
            
            return back()->with('success', 'Pengembalian telah ditolak dengan alasan: ' . $request->alasan);
        }

        return back()->with('failed', 'Pengembalian tidak dapat ditolak.');
    }

    public function cancel($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->keterangan === 'Menunggu') {
            $pengembalian->keterangan = 'Dibatalkan';
            $pengembalian->save();
            
            return back()->with('success', 'Pengembalian berhasil dibatalkan.');
        }

        return back()->with('failed', 'Pengembalian tidak dapat dibatalkan.');
    }

    public function getPendingCount()
    {
        $pendingPengembalianCount = Pengembalian::where('keterangan', 'Menunggu')->count();
        return response()->json(['pending_pengembalian' => $pendingPengembalianCount]);
    }

    public function getPendingCountUser()
    {
        $user = auth()->user();
        if($user->hasRole('admin')){
            $pendingPengembalianCountUser = Pengembalian::where('keterangan', 'Menunggu')->count();
        }else{
            $pendingPengembalianCountUser = Pengembalian::where('id_peminjam', $user->id)
            ->where('keterangan', 'Menunggu')
            ->count();
        }

        return response()->json(['pending_pengembalian_user' => $pendingPengembalianCountUser]);
    }

}
