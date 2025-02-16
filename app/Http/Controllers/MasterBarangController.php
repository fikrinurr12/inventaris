<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DataBarang;
use App\Models\Kategori;

use App\Helpers\GitHubStorage;

use Yajra\DataTables\Facades\DataTables;

class MasterBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $dataBarang = DataBarang::with('kategori')->select('data_barangs.*');

            return DataTables::of($dataBarang)
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->nama : 'Tidak ada kategori';
                })
                ->addColumn('keterangan', function ($row) {
                    return '<button 
                                class="btn btn-outline-info btn-sm btn-lihat-keterangan square-btn" 
                                data-foto="'.$row->foto.'"
                                data-keterangan="'.$row->keterangan.'" 
                                data-harga="'.$row->harga_terakhir.'"
                                data-spesifikasi="'.$row->spesifikasi.'"
                                data-stok_baik="'.$row->stok_total_baik.'"
                                data-stok_rusak="'.$row->stok_total_rusak.'"
                                data-stok_tersedia="'.$row->stok_tersedia.'">
                                <i class="fas fa-eye"></i>
                            </button>';
                })
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('edit_barang', $row->id);
                    $deleteUrl = route('hapus_barang', $row->id);
                    
                    return '<a href="'.$editUrl.'" class="btn btn-sm btn-warning square-btn">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="'.$deleteUrl.'" method="POST" class="d-inline form-hapus">
                                '.csrf_field().'
                                '.method_field("DELETE").'
                                <button type="submit" class="btn btn-sm btn-danger square-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>';
                })
                ->rawColumns(['keterangan', 'aksi']) // Pastikan kolom tombol ditampilkan sebagai HTML
                ->make(true);
        }
        
        return view('master_barang.index');
    }

    public function stok_sedikit(Request $request)
    {
        if ($request->ajax()) {
            $dataBarang = DataBarang::with('kategori')->select('data_barangs.*')
            ->where('stok_tersedia', '<', 5);

            return DataTables::of($dataBarang)
                ->addColumn('kategori', function ($row) {
                    return $row->kategori ? $row->kategori->nama : 'Tidak ada kategori';
                })
                ->rawColumns(['kategori']) // Pastikan kolom tombol ditampilkan sebagai HTML
                ->make(true);
        }

        return view('dashboard');
    }

    public function tambah()
    {
        $kategoris = Kategori::all(); // Ambil semua kategori
        return view('master_barang.tambah', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Hapus 'kode' dari validasi karena akan dibuat otomatis
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255|min:2',
            'merk' => 'required|string|max:255|min:2',
            'kategori_id' => 'required|exists:kategoris,id',
            'spesifikasi' => 'nullable|string',
            'keterangan' => 'nullable',
            'harga_terakhir' => 'required|numeric',
            'stok_total_baik' => 'required|integer',
            'stok_total_rusak' => 'required|integer',
            'stok_tersedia' => 'required|integer',
        ]);

        // **Generate kode unik otomatis**
        $lastBarang = DataBarang::latest('id')->first(); // Ambil data terakhir
        $nextNumber = $lastBarang ? (intval(substr($lastBarang->kode, 4)) + 1) : 1;
        $kodeBaru = 'INV-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT); // Format: INV-001, INV-002

        $validated['kode'] = $kodeBaru; // Masukkan kode ke dalam data yang akan disimpan

        // **Upload ke GitHub**
        if ($request->hasFile('foto')) {
            $uploadPath = 'tree/master/public/assets/img/upload';
            $uploadedUrl = GitHubStorage::uploadImage($request->file('foto'), $uploadPath);

            if ($uploadedUrl) {
                $validated['foto'] = $uploadedUrl; // Simpan URL GitHub
            } else {
                return back()->with('error', 'Gagal mengunggah gambar ke GitHub.');
            }
        }

        // // **Proses upload foto storage**
        // if ($request->hasFile('foto')) {
        //     $foto = $request->file('foto');
        //     $fotoName = time() . '.' . $foto->getClientOriginalExtension();
        //     $foto->move(public_path('assets/img/upload'), $fotoName);
        //     $validated['foto'] = 'assets/img/upload/' . $fotoName;
        // }

        // **Simpan data barang**
        DataBarang::create($validated);

        return redirect()->route('master_barang')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan form untuk edit barang
    public function edit($id)
    {
        $barang = DataBarang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('master_barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $barang = DataBarang::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|string|max:255|min:3|unique:data_barangs,kode,' . $id, // Kode unik tapi bisa tetap sama
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255|min:2',
            'merk' => 'required|string|max:255|min:2',
            'kategori_id' => 'required|exists:kategoris,id',
            'spesifikasi' => 'nullable|string|min:6',
            'keterangan' => 'nullable|string|min:6',
            'harga_terakhir' => 'required|numeric',
        ]);

        // **Update foto jika ada file baru diunggah**
        if ($request->hasFile('foto')) {
            // Hapus foto lama di GitHub jika ada
            if ($barang->foto) {
                $oldPath = str_replace("https://raw.githubusercontent.com/fikrinurr12/inventaris/tree/master/public/assets/img/upload", "", $barang->foto);
                GitHubStorage::deleteImage($oldPath);
            }

            // Upload foto baru ke GitHub
            $uploadPath = 'tree/master/public/assets/img/upload';
            $uploadedUrl = GitHubStorage::uploadImage($request->file('foto'), $uploadPath);

            if ($uploadedUrl) {
                $validated['foto'] = $uploadedUrl;
            } else {
                return back()->with('error', 'Gagal mengunggah gambar ke GitHub.');
            }
        }

        // // **Proses update foto jika ada**
        // if ($request->hasFile('foto')) {
        //     // Hapus foto lama jika ada
        //     if ($barang->foto && file_exists(public_path($barang->foto))) {
        //         unlink(public_path($barang->foto));
        //     }
            
        //     // Simpan foto baru
        //     $foto = $request->file('foto');
        //     $fotoName = time() . '.' . $foto->getClientOriginalExtension();
        //     $foto->move(public_path('assets/img/upload'), $fotoName);
        //     $validated['foto'] = 'assets/img/upload/' . $fotoName;
        // }

        // **Update data barang**
        $barang->update($validated);

        return redirect()->route('master_barang')->with('success', 'Barang berhasil diperbarui!');
    }


    public function hapus($id)
    {
        $barang = DataBarang::findOrFail($id);

        // Cek apakah barang memiliki data terkait
        if (!$barang->canBeDeleted()) {
            return redirect()->route('master_barang')
                ->with('failed', 'Barang tidak dapat dihapus karena masih memiliki transaksi terkait.');
        }

        // // Hapus foto jika ada
        // if ($barang->foto && file_exists(public_path($barang->foto))) {
        //     unlink(public_path($barang->foto)); // Hapus file dari folder
        // }

        // **Hapus gambar dari GitHub**
        if ($barang->foto) {
            $filePath = str_replace("https://raw.githubusercontent.com/fikrinurr12/inventaris/tree/master/public/assets/img/upload", "", $barang->foto);
            GitHubStorage::deleteImage($filePath);
        }

        // Hapus barang
        $barang->delete();

        return redirect()->route('master_barang')->with('success', 'Barang berhasil dihapus!');
    }

}
