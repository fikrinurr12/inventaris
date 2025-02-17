<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Models\DataBarang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class UserController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('index');
    }

    public function dashboard() {

        // Data saat ini untuk superadmin dan admin
        $totalUser = User::count();
        $totalProduk = DataBarang::sum('stok_tersedia');
        $totalRusak = DataBarang::sum('stok_total_rusak');
        $totalPeminjaman = Peminjaman::where('keterangan', 'Disetujui')->sum('sisa_pinjam');

        // Data saat ini untuk user
        $user = auth()->user();

        $pinjamanUser = Peminjaman::where('id_peminjam', $user->id)->where('keterangan', 'Disetujui');
        $pengembalianUser = Pengembalian::where('id_peminjam', $user->id)->where('keterangan', 'Disetujui');

        $totalPinjamanUser = $pinjamanUser->sum('jumlah');
        $totalSisaPinjamanUser = $pinjamanUser->sum('sisa_pinjam');
        $totalPengembalianUser = $pengembalianUser->sum('jumlah');

        // Ambil total jumlah barang yang dipinjam per bulan
        $dataPeminjaman = Peminjaman::selectRaw('MONTH(tgl_peminjaman) as bulan, SUM(jumlah) as total')
        ->whereYear('tgl_peminjaman', Carbon::now()->year)
        ->where('keterangan', 'Disetujui')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        // Ambil total jumlah barang yang dikembalikan per bulan
        $dataPengembalian = Pengembalian::selectRaw('MONTH(tgl_pengembalian) as bulan, SUM(kondisi_baik + kondisi_rusak) as total')
        ->whereYear('tgl_pengembalian', Carbon::now()->year)
        ->where('keterangan', 'Disetujui')
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

        // Label bulan (jika ada data kosong, isi dengan 0)
        $bulanLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $chartDataPeminjaman = array_fill(0, 12, 0); // Inisialisasi semua bulan dengan 0
        $chartDataPengembalian = array_fill(0, 12, 0); 

        // Menyusun data peminjaman
        foreach ($dataPeminjaman as $bulan => $total) {
            $chartDataPeminjaman[$bulan - 1] = $total; 
        }

        // Menyusun data pengembalian
        foreach ($dataPengembalian as $bulan => $total) {
            $chartDataPengembalian[$bulan - 1] = $total; 
        }

        $tahunSekarang = Carbon::now()->year;
        
        $peminjamanChart = (new LarapexChart)
        ->setType('bar') // Jenis chart bar
        ->setXAxis($bulanLabels) // Label bulan
        ->setHeight(250) // Atur tinggi chart
        ->setDataset([
            [
                'name' => "Peminjaman Tahun $tahunSekarang",
                'data' => $chartDataPeminjaman // Data Peminjaman
            ],
            [
                'name' => "Pengembalian Tahun $tahunSekarang",
                'data' => $chartDataPengembalian // Data Pengembalian
            ]
        ])
        ->setToolbar(true) // Menampilkan opsi interaksi
        ->setDataLabels(true); // Menampilkan nilai di chart;

        //chart
        // Ambil total stok dari tabel DataBarang
        $totalTersedia = DataBarang::sum('stok_tersedia') ?? 0;
        $totalBaik = DataBarang::sum('stok_total_baik') ?? 0;
        $totalRusak = DataBarang::sum('stok_total_rusak') ?? 0;

        // Buat chart donut
        $stokChart = (new LarapexChart)
        ->setType('donut')
        ->setLabels([
            "Tersedia ({$totalTersedia})", 
            "Total Baik ({$totalBaik})", 
            "Total Rusak ({$totalRusak})"
        ])
        ->setDataset([
            (int) $totalTersedia, 
            (int) $totalBaik, 
            (int) $totalRusak
        ])
        ->setHeight(263)
        ->setToolbar(true) // Menampilkan opsi interaksi
        ->setDataLabels(true); // Menampilkan nilai di chart
    
        return view('dashboard', compact(
            'totalUser', 
            'totalProduk', 
            'totalRusak', 
            'totalPeminjaman',
            'totalPinjamanUser',
            'totalSisaPinjamanUser',
            'totalPengembalianUser',
            'peminjamanChart',
            'stokChart'
        ));
    }

    // Proses login
    public function proses_login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login menggunakan email dan password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect ke dashboard jika login berhasil
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }else if (!User::where('email', $request->email)->exists()) {
            //cek apakah email ada
            return back()->with('failed', 'Email / Pasword Salah!');
        }else if (!User::where('password', $request->password)->exists()) {
            //cek apakah password ada
            return back()->with('failed', 'Email / Pasword Salah!');
        }

        // Jika email ada tetapi password salah
        return back()->with('failed', 'Email / Pasword Salah!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }

    // manajemen data pengguna

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            $query = User::query();

            if (!$user->hasRole('superadmin')) {
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['admin', 'user']);
                });
            }

            return DataTables::of($query)
                ->addColumn('role', function ($user) {
                    return $user->getRoleNames()->implode(', ');
                })
                ->addColumn('aksi', function ($user) {
                    $buttons = '';

                    $buttons .= '<a href="' . route('edit_user', $user->id) . '" class="btn btn-warning btn-sm square-btn">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>';
                    $buttons .= '<form action="' . route('hapus_user', $user->id) . '" method="POST" class="square-btn d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-sm square-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>';
                    return $buttons;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('user.index');
    }

    public function tambah(){
        $dataRole = Role::all();
        return view('user.tambah', compact('dataRole'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|exists:roles,id',
        ]);

        // Cek apakah user yang login adalah admin
        $currentUser = auth()->user();
        $role = Role::findOrFail($request->role);

        // Jika user yang login adalah admin, mereka tidak boleh memilih role superadmin
        if ($currentUser->hasRole('admin') && $role->name === 'superadmin') {
            return redirect()->back()->with('failed', 'Anda tidak memiliki izin untuk menambahkan Superadmin.');
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role ke user
        $user->assignRole($role->name);

        return redirect()->route('data_pengguna')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil semua roles yang tersedia
        $roles = Role::all();

        // Kembalikan data ke view, dengan membawa data user dan roles
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:6',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:' . implode(',', Role::all()->pluck('name')->toArray()), // Validasi role
            'password' => 'nullable|min:6',
        ]);

        $currentUser = auth()->user();

        // Cek jika role yang ingin diubah adalah superadmin
        if ($validated['role'] == 'superadmin') {
            

            // Jika user yang login adalah admin, mereka tidak boleh memilih role superadmin
            if ($currentUser->hasRole('admin')) {
                return redirect()->back()->with('failed', 'Anda tidak memiliki izin untuk mengubah menjadi Superadmin.');
            }else{
                $superadminCount = User::role('superadmin')->count();

                // Jika hanya ada satu superadmin, jangan izinkan mengubah ke superadmin
                if ($superadminCount <= 1) {
                    return redirect()->route('data_pengguna')->with('failed', 'Tidak bisa menetapkan role superadmin karena hanya ada satu superadmin.');
                }
            }
        }

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        //ganti email
        $user->email = $validated['email'];

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Hapus role lama
        $user->removeRole($user->roles->first()->name);

        // Assign role baru
        $user->assignRole($validated['role']);

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('data_pengguna')->with('success', 'User berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $user = User::findOrFail($id);


        $currentUser = auth()->user();
        // Jika user yang login adalah admin, mereka tidak boleh memilih role superadmin
        if ($currentUser->hasRole('admin')) {
            return redirect()->route('data_pengguna')->with('failed', 'Anda tidak memiliki izin untuk menghapus Superadmin.');
        }
        
        // Cek apakah user yang akan dihapus adalah superadmin
        if ($user->hasRole('superadmin') && User::role('superadmin')->count() == 1) {
            return redirect()->route('data_pengguna')->with('failed', 'Tidak bisa menghapus superadmin terakhir.');
        }

        // Cek apakah barang memiliki data terkait
        if (!$user->canBeDeleted()) {
            return redirect()->route('data_pengguna')
                ->with('failed', 'User tidak dapat dihapus karena masih memiliki transaksi terkait.');
        }

        // Hapus relasi user dengan role dari tabel model_has_roles
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        // Hapus user dari database
        $user->delete();

        return redirect()->route('data_pengguna')->with('success', 'User berhasil dihapus.');
    }

    public function lupaPassword(){
        return view('user.lupaPassword');
    }


}
