<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Peminjaman</h2>
    </div>
    
    <p><strong>No Transaksi:</strong> {{ $peminjaman->no_transaksi }}</p>
    <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Sisa Pinjam</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $peminjaman->barang->nama }}</td>
                <td>{{ $peminjaman->jumlah }}</td>
                <td>{{ $peminjaman->sisa_pinjam }}</td>
                <td>{{ $peminjaman->keterangan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
