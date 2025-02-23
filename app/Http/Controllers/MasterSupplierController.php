<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Supplier;

use Illuminate\Http\Request;

class MasterSupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::select('id', 'nama','no_telepon','alamat')->orderBy('updated_at', 'desc');
    
            return DataTables::of($supplier)
                ->addColumn('aksi', function ($row) {
                    $editUrl = route('edit_supplier', $row->id);
                    $deleteUrl = route('hapus_supplier', $row->id);
                    
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

        return view('master_supplier.index');
    }

    public function tambah()
    {
        return view('master_supplier.tambah');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:suppliers,nama',
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Simpan data supplier
        Supplier::create([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('supplier')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('master_supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:suppliers,nama,' . $id,
            'no_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Cek apakah kategori memiliki barang terkait
        if (!$supplier->canBeDeleted()) {
            return redirect()->route('supplier')->with('failed', 'Supplier tidak dapat dihapus karena masih memiliki pembelian terkait.');
        }

        $supplier->delete();

        return redirect()->route('supplier')->with('success', 'Supplier berhasil dihapus.');
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
