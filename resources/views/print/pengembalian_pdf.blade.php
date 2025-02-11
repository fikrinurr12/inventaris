<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengembalian</title>
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
        <h2>Laporan Pengembalian</h2>
    </div>
    
    <p><strong>No Transaksi:</strong> {{ $pengembalian->no_transaksi }}</p>
    <p><strong>Nama Peminjam:</strong> {{ $pengembalian->user->name }}</p>
    <p><strong>Barang:</strong> {{ $pengembalian->barang->nama }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Baik</th>
                <th>Rusak</th>
                <th>Jumlah</th>
                <th>Sisa Pinjam</th>
                <th>Tanggal Pengembalian</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $pengembalian->kondisi_baik }}</td>
                <td>{{ $pengembalian->kondisi_rusak }}</td>
                <td>{{ $pengembalian->jumlah }}</td>
                <td>{{ $pengembalian->sisa_pinjam }}</td>
                <td>{{ $pengembalian->tgl_pengembalian }}</td>
                <td>{{ $pengembalian->keterangan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
