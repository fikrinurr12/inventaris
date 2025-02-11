<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penyesuaian Stok</title>
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
        <h2>Laporan Penyesuaian Stok</h2>
    </div>
    <p><strong>No Transaksi:</strong> {{ $penyesuaian->no_transaksi }}</p>
    <p><strong>Nama Barang:</strong> {{ $penyesuaian->barang->nama }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Stok Baik</th>
                <th>Stok Rusak</th>
                <th>Stok Tersedia</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $penyesuaian->stok_total_baik }}</td>
                <td>{{ $penyesuaian->stok_total_rusak }}</td>
                <td>{{ $penyesuaian->stok_tersedia }}</td>
                <td>{{ $penyesuaian->keterangan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
