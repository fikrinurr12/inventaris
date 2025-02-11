<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategori = Kategori::select('id', 'nama');
    
            return DataTables::of($kategori)
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('edit_kategori', $row->id);
                    $deleteUrl = route('hapus_kategori', $row->id);
                    
                    return '
                        <a href="'.$editUrl.'" class="btn btn-warning btn-sm square-btn">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="'.$deleteUrl.'" method="POST" class="d-inline delete-form">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger btn-sm delete-button square-btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('kategori.index');
    }

    public function tambah()
    {
        return view('kategori.tambah');
    }

    public function store(Request $request)
    {
        // Validasi input untuk memastikan nama kategori unik
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ]);

        // Menambahkan kategori baru ke database
        Kategori::create([
            'nama' => $request->nama
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $id,
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update(['nama' => $request->nama]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori memiliki barang terkait
        if (!$kategori->canBeDeleted()) {
            return redirect()->route('kategori')->with('failed', 'Kategori tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $kategori->delete();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus.');
    }

    public function storeAjax(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:kategoris,nama',
            ]);

            $kategori = Kategori::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Kategori berhasil ditambahkan!',
                'id' => $kategori->id,
                'nama' => $kategori->nama,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal, Kategori Sudah Ada!',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

}

